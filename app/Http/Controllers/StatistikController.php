<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\User;
use App\Models\VisitorLog;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    /**
     * Halaman utama statistik & analitik publik perpustakaan.
     */
    public function index(): \Illuminate\View\View
    {
        // ── Ringkasan Umum ──────────────────────────────────────
        $summary = [
            'total_koleksi'      => Book::count(),
            'total_kategori'     => Category::count(),
            'total_peminjaman'   => Borrowing::whereIn('status', ['active', 'returned'])->count(),
            'total_anggota'      => User::count(),
            'buku_tersedia'      => Book::where('status', 'available')->count(),
            'peminjaman_aktif'   => Borrowing::active()->count(),
            'total_pengunjung'   => VisitorLog::count(),
            'pengunjung_hari_ini'=> VisitorLog::whereDate('visited_on', today())->count(),
        ];

        // ── Distribusi Buku per Kategori ────────────────────────
        $bukuPerKategori = Category::withCount('books')
            ->has('books')
            ->orderByDesc('books_count')
            ->get()
            ->map(fn($c) => [
                'name'  => $c->name,
                'total' => $c->books_count,
            ]);

        // ── Top 10 Buku Paling Sering Dipinjam ─────────────────
        $topBuku = Borrowing::select('book_id')
            ->selectRaw('COUNT(*) as total_pinjam')
            ->whereIn('status', ['active', 'returned'])
            ->groupBy('book_id')
            ->orderByDesc('total_pinjam')
            ->limit(10)
            ->with('book:id,title,author,category_id')
            ->get()
            ->map(fn($b) => [
                'judul'  => $b->book->title  ?? '(Tidak Diketahui)',
                'penulis'=> $b->book->author ?? '-',
                'total'  => $b->total_pinjam,
            ]);

        // ── Tren Peminjaman 12 Bulan Terakhir ───────────────────
        $trenPeminjaman = $this->getTrenPeminjaman12Bulan();

        // ── Tren Pengunjung 12 Bulan Terakhir ───────────────────
        $trenPengunjung = $this->getTrenPengunjung12Bulan();

        // ── Distribusi Status Peminjaman ────────────────────────
        $statusPeminjaman = [
            ['label' => 'Aktif',      'value' => Borrowing::active()->count(),                            'color' => '#22c55e'],
            ['label' => 'Dikembalikan','value' => Borrowing::where('status', 'returned')->count(),         'color' => '#3b82f6'],
            ['label' => 'Terlambat',  'value' => Borrowing::overdue()->count(),                           'color' => '#f59e0b'],
            ['label' => 'Pending',    'value' => Borrowing::pending()->count(),                           'color' => '#a855f7'],
            ['label' => 'Ditolak',    'value' => Borrowing::rejected()->count(),                          'color' => '#ef4444'],
        ];

        // ── Statistik Buku per Tahun Terbit ────────────────────
        $bukuPerTahun = Book::selectRaw('year, COUNT(*) as total')
            ->whereNotNull('year')
            ->where('year', '>', 1950)
            ->where('year', '<=', now()->year)
            ->groupBy('year')
            ->orderBy('year')
            ->get()
            ->map(fn($r) => ['tahun' => (string)$r->year, 'total' => $r->total]);

        // ── Rata-rata Peminjaman per Hari (7 hari terakhir) ─────
        $avgHarian = collect(range(6, 0))->map(fn($i) => [
            'tanggal' => Carbon::now()->subDays($i)->format('d M'),
            'total'   => Borrowing::whereDate('created_at', Carbon::now()->subDays($i))->count(),
        ]);

        return view('statistik.index', compact(
            'summary',
            'bukuPerKategori',
            'topBuku',
            'trenPeminjaman',
            'trenPengunjung',
            'statusPeminjaman',
            'bukuPerTahun',
            'avgHarian',
        ));
    }

    /**
     * Endpoint JSON untuk refresh data chart (AJAX).
     */
    public function apiData(): JsonResponse
    {
        return response()->json([
            'tren_peminjaman' => $this->getTrenPeminjaman12Bulan(),
            'tren_pengunjung' => $this->getTrenPengunjung12Bulan(),
            'generated_at'   => now()->toIso8601String(),
        ]);
    }

    // ── Private helpers ──────────────────────────────────────────

    private function getTrenPeminjaman12Bulan(): array
    {
        $labels = [];
        $data   = [];

        for ($i = 11; $i >= 0; $i--) {
            $date     = Carbon::now()->startOfMonth()->subMonths($i);
            $labels[] = $date->format('M Y');
            $data[]   = Borrowing::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->whereIn('status', ['active', 'returned'])
                ->count();
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getTrenPengunjung12Bulan(): array
    {
        $labels = [];
        $data   = [];

        for ($i = 11; $i >= 0; $i--) {
            $date     = Carbon::now()->startOfMonth()->subMonths($i);
            $labels[] = $date->format('M Y');

            if (\DB::getDriverName() === 'sqlite') {
                $count = VisitorLog::whereRaw("strftime('%Y', visited_on) = ?", [$date->format('Y')])
                    ->whereRaw("strftime('%m', visited_on) = ?", [$date->format('m')])
                    ->count();
            } else {
                $count = VisitorLog::whereYear('visited_on', $date->year)
                    ->whereMonth('visited_on', $date->month)
                    ->count();
            }

            $data[] = $count;
        }

        return ['labels' => $labels, 'data' => $data];
    }
}
