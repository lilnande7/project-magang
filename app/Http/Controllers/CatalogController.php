<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CatalogController extends Controller
{
    /**
     * Halaman katalog buku — bisa diakses semua orang, login untuk pinjam.
     */
    public function index(Request $request)
    {
        $query = Book::with('category')->where('status', '!=', 'lost');

        // Search
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('title', 'like', "%$q%")
                  ->orWhere('author', 'like', "%$q%")
                  ->orWhere('isbn', 'like', "%$q%")
                  ->orWhere('subjects', 'like', "%$q%")
                  ->orWhere('topics', 'like', "%$q%")
                  ->orWhere('call_number', 'like', "%$q%")
                  ->orWhere('publisher', 'like', "%$q%");
            });
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter status (available / borrowed)
        if ($request->filled('availability')) {
            $query->where('status', $request->availability);
        }

        // Filter bahasa
        if ($request->filled('language')) {
            $query->where('language', $request->language);
        }

        // Sort
        $sort = $request->get('sort', 'title');
        match ($sort) {
            'newest' => $query->orderByDesc('year'),
            'oldest' => $query->orderBy('year'),
            'author' => $query->orderBy('author'),
            default  => $query->orderBy('title'),
        };

        $books       = $query->paginate(12)->withQueryString();
        $categories  = Category::active()->orderBy('name')->get();
        $languages   = Book::select('language')->distinct()->whereNotNull('language')->pluck('language');

        return view('catalog.index', compact('books', 'categories', 'languages'));
    }

    /**
     * Halaman detail buku + form permintaan peminjaman.
     */
    public function show(Book $book)
    {
        $book->load('category');

        // Cek apakah user sudah punya peminjaman aktif/pending untuk buku ini
        $userBorrowing = null;
        if (Auth::check()) {
            $userBorrowing = Borrowing::where('user_id', Auth::id())
                ->where('book_id', $book->id)
                ->whereIn('status', ['pending', 'active'])
                ->latest()
                ->first();
        }

        // Buku terkait (kategori sama)
        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->limit(4)
            ->get();

        return view('catalog.show', compact('book', 'userBorrowing', 'relatedBooks'));
    }

    /**
     * User mengajukan permintaan peminjaman.
     */
    public function requestBorrow(Request $request, Book $book)
    {
        // Harus login
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan login untuk meminjam buku.');
        }

        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        // Cek sudah ada peminjaman pending/aktif untuk buku ini
        $existing = Borrowing::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'active'])
            ->exists();

        if ($existing) {
            return back()->with('error', 'Anda sudah memiliki permintaan atau peminjaman aktif untuk buku ini.');
        }

        // Cek total peminjaman aktif user (maks 3 buku)
        $activeCount = Borrowing::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'active'])
            ->count();

        if ($activeCount >= 3) {
            return back()->with('error', 'Anda sudah mencapai batas maksimal 3 buku yang sedang dipinjam/diproses.');
        }

        // Cek stok tersedia
        if ($book->stock <= 0 || $book->status === 'maintenance') {
            return back()->with('error', 'Maaf, buku ini sedang tidak tersedia untuk dipinjam.');
        }

        Borrowing::create([
            'user_id'      => $user->id,
            'book_id'      => $book->id,
            'requested_at' => Carbon::today(),
            'borrowed_at'  => null,
            'due_date'     => null,
            'status'       => 'pending',
            'notes'        => $request->notes,
        ]);

        return redirect()->route('catalog.show', $book)
            ->with('success', 'Permintaan peminjaman berhasil dikirim! Tunggu konfirmasi dari pustakawan.');
    }

    /**
     * Riwayat peminjaman milik user yang sedang login.
     */
    public function myBorrowings()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $borrowings = Borrowing::with('book.category')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('catalog.my-borrowings', compact('borrowings'));
    }

    /**
     * User membatalkan permintaan yang masih pending.
     */
    public function cancelRequest(Borrowing $borrowing)
    {
        if ($borrowing->user_id !== Auth::id()) {
            abort(403);
        }

        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Hanya permintaan yang masih menunggu yang dapat dibatalkan.');
        }

        $borrowing->delete();

        return back()->with('success', 'Permintaan peminjaman berhasil dibatalkan.');
    }
}
