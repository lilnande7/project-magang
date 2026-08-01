<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    /**
     * Daftar semua permintaan peminjaman — dengan filter status.
     */
    public function index(Request $request)
    {
        $query = Borrowing::with(['user', 'book.category', 'approvedBy'])
            ->orderByRaw("FIELD(status, 'pending', 'active', 'overdue', 'returned', 'rejected')")
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%$s%")
                ->orWhere('email', 'like', "%$s%"))
                ->orWhereHas('book', fn($q) => $q->where('title', 'like', "%$s%"));
        }

        $borrowings = $query->paginate(20)->withQueryString();

        $counts = [
            'pending'  => Borrowing::pending()->count(),
            'active'   => Borrowing::active()->count(),
            'overdue'  => Borrowing::overdue()->count(),
            'returned' => Borrowing::where('status', 'returned')->count(),
            'rejected' => Borrowing::rejected()->count(),
        ];

        return view('admin.borrowings.index', compact('borrowings', 'counts'));
    }

    /**
     * Detail satu permintaan peminjaman.
     */
    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['user', 'book.category', 'approvedBy']);
        return view('admin.borrowings.show', compact('borrowing'));
    }

    /**
     * Setujui permintaan peminjaman → status: active.
     */
    public function approve(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Hanya permintaan dengan status pending yang dapat disetujui.');
        }

        $request->validate([
            'due_days' => 'required|integer|min:1|max:60',
            'notes'    => 'nullable|string|max:500',
        ]);

        $dueDays    = (int) $request->due_days;
        $borrowedAt = Carbon::today();
        $dueDate    = $borrowedAt->copy()->addDays($dueDays);

        // Update status buku jika stok habis
        $book = $borrowing->book;
        $activeBorrowingsCount = Borrowing::where('book_id', $book->id)
            ->where('status', 'active')
            ->count();

        $borrowing->update([
            'status'      => 'active',
            'borrowed_at' => $borrowedAt,
            'due_date'    => $dueDate,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'notes'       => $request->notes ?? $borrowing->notes,
        ]);

        // Jika stok buku habis, ubah status buku menjadi 'borrowed'
        if (($activeBorrowingsCount + 1) >= $book->stock) {
            $book->update(['status' => 'borrowed']);
        }

        // Log aktivitas
        $this->logActivity($borrowing, 'approved');

        return redirect()->route('admin.borrowings.index')
            ->with('success', "Peminjaman buku \"{$book->title}\" oleh {$borrowing->user->name} berhasil disetujui. Tenggat: {$dueDate->format('d M Y')}.");
    }

    /**
     * Tolak permintaan peminjaman → status: rejected.
     */
    public function reject(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Hanya permintaan dengan status pending yang dapat ditolak.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $borrowing->update([
            'status'           => 'rejected',
            'approved_by'      => Auth::id(),
            'approved_at'      => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        $this->logActivity($borrowing, 'rejected');

        return redirect()->route('admin.borrowings.index')
            ->with('success', "Permintaan peminjaman oleh {$borrowing->user->name} telah ditolak.");
    }

    /**
     * Tandai buku sudah dikembalikan → status: returned.
     */
    public function returnBook(Request $request, Borrowing $borrowing)
    {
        if (!in_array($borrowing->status, ['active', 'overdue'])) {
            return back()->with('error', 'Hanya peminjaman aktif atau terlambat yang dapat ditandai dikembalikan.');
        }

        $fine = $borrowing->calculateFine();

        $borrowing->update([
            'status'      => 'returned',
            'returned_at' => Carbon::today(),
            'fine_amount' => $fine,
        ]);

        // Update stok buku kembali tersedia
        $book = $borrowing->book;
        $activeCount = Borrowing::where('book_id', $book->id)->active()->count();
        if ($activeCount < $book->stock) {
            $book->update(['status' => 'available']);
        }

        $msg = "Buku \"{$book->title}\" berhasil dikembalikan.";
        if ($fine > 0) {
            $msg .= " Denda: Rp " . number_format($fine, 0, ',', '.');
        }

        $this->logActivity($borrowing, 'returned');

        return redirect()->route('admin.borrowings.index')->with('success', $msg);
    }

    /**
     * Helper: catat aktivitas ke UserActivityLog jika model tersedia.
     */
    private function logActivity(Borrowing $borrowing, string $action): void
    {
        try {
            \App\Models\UserActivityLog::create([
                'admin_id'       => Auth::id(),
                'target_user_id' => $borrowing->user_id,
                'action'         => "borrowing_{$action}",
                'description'    => "Buku: {$borrowing->book->title} | Status: {$action}",
            ]);
        } catch (\Exception $e) {
            // Log tidak kritis, abaikan jika gagal
        }
    }
}
