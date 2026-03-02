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

        return view('home', [
            'title' => 'Beranda - Perpustakaan PPIC',
            'featuredNews' => $featuredNews,
            'latestNews' => $latestNews,
            'topCategories' => $topCategories,
            'stats' => [
                'total_books' => $totalBooks,
                'total_categories' => $totalCategories,
                'available_books' => $availableBooks,
                'total_members' => $totalMembers,
            ]
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
