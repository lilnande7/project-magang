<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Borrowing;
use App\Models\User;
use App\Models\UserActivityLog;
use App\Models\News;
use App\Models\VisitorLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->query('year', Carbon::today()->year);
        if ($year < 2000 || $year > 2100) {
            $year = (int) Carbon::today()->year;
        }

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

        $recent_user_logs = UserActivityLog::with(['admin', 'targetUser'])
            ->latest()
            ->limit(8)
            ->get();
            
        // Charts data
        $borrowings_chart = $this->getBorrowingsChartData();
        $books_by_category = $this->getBooksByCategoryData();
        $visitors_chart = $this->getVisitorsYearChartData($year);
        $visitors_year_total = VisitorLog::whereYear('visited_on', $year)->count();
        
        return view('admin.dashboard', compact(
            'stats', 
            'recent_borrowings', 
            'recent_books', 
            'recent_news',
            'featured_news',
            'borrowings_chart',
            'books_by_category',
            'recent_user_logs',
            'visitors_chart',
            'visitors_year_total',
            'year'
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

    private function getVisitorsYearChartData(int $year): array
    {
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $totalsByMonth = VisitorLog::query()
            ->selectRaw('MONTH(visited_on) as month, COUNT(*) as total')
            ->whereYear('visited_on', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $labels = $monthNames;
        $data = [];
        for ($month = 1; $month <= 12; $month++) {
            $data[] = (int) ($totalsByMonth[$month] ?? 0);
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    public function exportVisitorsYear(Request $request): Response
    {
        $year = (int) $request->query('year', Carbon::today()->year);
        if ($year < 2000 || $year > 2100) {
            $year = (int) Carbon::today()->year;
        }

        $chart = $this->getVisitorsYearChartData($year);

        $reportTitle = 'Pengunjung Website Perpustakaan PPI Curug Tahun '.$year;
        $chartBase64Png = $this->renderVisitorsChartPngBase64(
            title: $reportTitle,
            labels: $chart['labels'],
            data: $chart['data'],
        );

        $rows = [];
        $total = 0;
        foreach ($chart['labels'] as $i => $label) {
            $count = (int) ($chart['data'][$i] ?? 0);
            $total += $count;
            $rows[] = [
                'month' => $label,
                'visitors' => $count,
            ];
        }

        $html = view('admin.exports.visitors-year', [
            'year' => $year,
            'title' => $reportTitle,
            'rows' => $rows,
            'total' => $total,
            'generated_at' => Carbon::now(),
            'chart_base64_png' => $chartBase64Png,
        ])->render();

        $filename = 'laporan_pengunjung_'.$year.'.xls';

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            'Cache-Control' => 'no-store, no-cache',
        ]);
    }

    private function renderVisitorsChartPngBase64(string $title, array $labels, array $data): ?string
    {
        if (! extension_loaded('gd') || ! function_exists('imagecreatetruecolor')) {
            return null;
        }

        $width = 1100;
        $height = 420;
        $paddingLeft = 70;
        $paddingRight = 30;
        $paddingTop = 60;
        $paddingBottom = 70;

        $img = imagecreatetruecolor($width, $height);
        if (! $img) {
            return null;
        }

        imageantialias($img, true);

        $white = imagecolorallocate($img, 255, 255, 255);
        $text = imagecolorallocate($img, 20, 20, 20);
        $grid = imagecolorallocate($img, 230, 230, 230);
        $axis = imagecolorallocate($img, 160, 160, 160);
        $line = imagecolorallocate($img, 34, 197, 94);
        $point = imagecolorallocate($img, 22, 163, 74);

        imagefilledrectangle($img, 0, 0, $width, $height, $white);

        $plotLeft = $paddingLeft;
        $plotRight = $width - $paddingRight;
        $plotTop = $paddingTop;
        $plotBottom = $height - $paddingBottom;
        $plotWidth = $plotRight - $plotLeft;
        $plotHeight = $plotBottom - $plotTop;

        $max = 0;
        foreach ($data as $v) {
            $max = max($max, (int) $v);
        }
        $max = max(1, $max);

        $steps = 5;
        $stepValue = (int) ceil($max / $steps);
        $maxScale = $stepValue * $steps;

        // Grid + Y labels
        for ($i = 0; $i <= $steps; $i++) {
            $y = (int) ($plotBottom - ($plotHeight * $i / $steps));
            imageline($img, $plotLeft, $y, $plotRight, $y, $grid);
            $labelVal = (string) ($stepValue * $i);
            imagestring($img, 3, 10, $y - 7, $labelVal, $text);
        }

        // Axes
        imageline($img, $plotLeft, $plotTop, $plotLeft, $plotBottom, $axis);
        imageline($img, $plotLeft, $plotBottom, $plotRight, $plotBottom, $axis);

        $count = count($data);
        if ($count < 2) {
            $count = 2;
        }

        $xStep = $plotWidth / ($count - 1);
        $points = [];

        for ($i = 0; $i < count($data); $i++) {
            $x = (int) round($plotLeft + ($xStep * $i));
            $val = (int) ($data[$i] ?? 0);
            $y = (int) round($plotBottom - ($plotHeight * ($val / $maxScale)));
            $points[] = [$x, $y, $val];

            // X labels (month)
            $lab = (string) ($labels[$i] ?? '');
            imagestring($img, 3, $x - 10, $plotBottom + 10, $lab, $text);
        }

        // Line
        for ($i = 0; $i < count($points) - 1; $i++) {
            imageline($img, $points[$i][0], $points[$i][1], $points[$i + 1][0], $points[$i + 1][1], $line);
        }

        // Points
        foreach ($points as [$x, $y]) {
            imagefilledellipse($img, (int) $x, (int) $y, 8, 8, $point);
        }

        // Title (basic; GD built-in font)
        imagestring($img, 5, (int) ($width / 2 - (strlen($title) * 4)), 18, $title, $text);

        ob_start();
        imagepng($img);
        $png = ob_get_clean();

        imagedestroy($img);

        if (! is_string($png) || $png === '') {
            return null;
        }

        return base64_encode($png);
    }
}
