<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Borrowing;
use App\Models\User;
use App\Models\News;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic statistics
        $stats = [
            'total_books' => Book::count(),
            'available_books' => Book::where('status', 'available')->count(),
            'borrowed_books' => Book::where('status', 'borrowed')->count(),
            'total_categories' => Category::active()->count(),
            'total_users' => User::count(),
            'active_borrowings' => Borrowing::active()->count(),
            'overdue_borrowings' => Borrowing::overdue()->count(),
            'total_news' => News::count(),
            'published_news' => News::published()->count(),
        ];
        
        // Recent activities
        $recent_borrowings = Borrowing::with(['user', 'book'])
            ->latest()
            ->limit(5)
            ->get();
            
        $recent_books = Book::with('category')
            ->latest()
            ->limit(5)
            ->get();
            
        $recent_news = News::with('author')
            ->latest()
            ->limit(5)
            ->get();
            
        // Featured news for dashboard
        $featured_news = News::with('author')
            ->where('is_featured', true)
            ->where('status', 'published')
            ->latest()
            ->limit(4)
            ->get();
            
        // Charts data
        $borrowings_chart = $this->getBorrowingsChartData();
        $books_by_category = $this->getBooksByCategoryData();
        
        return view('admin.dashboard', compact(
            'stats', 
            'recent_borrowings', 
            'recent_books', 
            'recent_news',
            'featured_news',
            'borrowings_chart',
            'books_by_category'
        ));
    }
    
    private function getBorrowingsChartData()
    {
        $data = [];
        $labels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('M d');
            $data[] = Borrowing::whereDate('created_at', $date)->count();
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
    
    private function getBooksByCategoryData()
    {
        return Category::withCount('books')
            ->having('books_count', '>', 0)
            ->orderBy('books_count', 'desc')
            ->get();
    }
}
