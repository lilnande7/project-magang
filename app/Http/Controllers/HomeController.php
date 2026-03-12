<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Display the homepage with featured news and library stats
     */
    public function index()
    {
        // Get featured news (is_featured = true and status = published)
        $featuredNews = News::where('is_featured', true)
                          ->where('status', 'published')
                          ->orderBy('created_at', 'desc')
                          ->take(3)
                          ->get();

        // Get latest news (non-featured but published)
        $latestNews = News::where('is_featured', false)
                        ->where('status', 'published')
                        ->orderBy('created_at', 'desc')
                        ->take(6)
                        ->get();

        // Get top categories with book count
        $topCategories = Category::withCount('books')
                        ->orderBy('books_count', 'desc')
                        ->take(6)
                        ->get();

        // Get some statistics for homepage
        $totalBooks = Book::count();
        $totalCategories = Category::count();
        $availableBooks = Book::where('status', 'available')->count();
        $totalMembers = User::count();

<<<<<<< HEAD
        $librarians = User::select('id', 'name', 'email', 'avatar_path', 'created_at')
            ->whereHas('roles', function ($query) {
                $query->where('slug', 'librarian');
            })
            ->with(['roles' => function ($query) {
                $query->select('roles.id', 'roles.name', 'roles.slug');
            }])
            ->orderBy('name')
            ->get()
            ->map(function ($librarian) {
                $nameParts = array_filter(preg_split('/\s+/', trim($librarian->name)) ?: []);
                $initials = '';

                foreach ($nameParts as $part) {
                    $initials .= mb_substr($part, 0, 1);
                    if (mb_strlen($initials) >= 2) {
                        break;
                    }
                }

                $librarian->initials = mb_strtoupper($initials ?: mb_substr($librarian->name, 0, 1));
                $librarian->primary_role = $librarian->roles->firstWhere('slug', 'librarian') ?? $librarian->roles->first();

                return $librarian;
            });

=======
        $expertises = [
            'Kurasi Koleksi & Referensi',
            'Layanan Sirkulasi & Reservasi',
            'Literasi Informasi & Pelatihan',
            'Pengelolaan Repositori Digital',
        ];

        $librarianProfiles = User::whereHas('roles', function ($query) {
                $query->where('slug', 'librarian');
            })
            ->select('name', 'email')
            ->orderBy('name')
            ->take(count($expertises))
            ->get()
            ->map(function ($user, $index) use ($expertises) {
                return [
                    'name' => $user->name,
                    'email' => $user->email,
                    'expertise' => $expertises[$index % count($expertises)],
                ];
            });

        if ($librarianProfiles->isEmpty()) {
            $librarianProfiles = collect([
                [
                    'name' => 'Ayu Pratama',
                    'email' => 'referensi@ppic.ac.id',
                    'expertise' => $expertises[0],
                ],
                [
                    'name' => 'Raka Wirawan',
                    'email' => 'sirkulasi@ppic.ac.id',
                    'expertise' => $expertises[1],
                ],
                [
                    'name' => 'Nadya Hanifah',
                    'email' => 'literasi@ppic.ac.id',
                    'expertise' => $expertises[2],
                ],
                [
                    'name' => 'Bima Kusuma',
                    'email' => 'repository@ppic.ac.id',
                    'expertise' => $expertises[3],
                ],
            ]);
        }

>>>>>>> main
        return view('home', [
            'title' => 'Beranda - Perpustakaan PPIC',
            'featuredNews' => $featuredNews,
            'latestNews' => $latestNews,
            'topCategories' => $topCategories,
            'librarians' => $librarians,
            'stats' => [
                'total_books' => $totalBooks,
                'total_categories' => $totalCategories,
                'available_books' => $availableBooks,
                'total_members' => $totalMembers,
            ],
            'librarians' => $librarianProfiles,
        ]);
    }

    /**
     * Display all news articles with pagination
     */
    public function news()
    {
        $news = News::where('status', 'published')
                   ->orderBy('created_at', 'desc')
                   ->paginate(12);
        
        $featuredNews = News::where('is_featured', true)
                          ->where('status', 'published')
                          ->orderBy('created_at', 'desc')
                          ->take(3)
                          ->get();

        return view('news.index', [
            'title' => 'Berita - Perpustakaan PPIC',
            'news' => $news,
            'featuredNews' => $featuredNews
        ]);
    }

    /**
     * Show single news article
     */
    public function showNews($id)
    {
        $news = News::where('status', 'published')->findOrFail($id);
        
        return view('news.show', [
            'title' => $news->title . ' - Perpustakaan PPIC',
            'news' => $news
        ]);
    }
}
