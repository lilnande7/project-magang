<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get category IDs
        $categories = Category::all()->pluck('id', 'code');
        
        $books = [
            // Teknik Penerbangan Udara
            [
                'title' => 'Dasar-dasar Penerbangan',
                'author' => 'Dr. Ahmad Wahyudi',
                'isbn' => '978-602-123-456-7',
                'publisher' => 'Penerbit Penerbangan Indonesia',
                'year' => 2023,
                'pages' => 320,
                'language' => 'Indonesia',
                'description' => 'Buku ini membahas dasar-dasar penerbangan yang mencakup prinsip-prinsip aerodinamika, sistem navigasi, dan teknologi avionik modern.',
                'location' => 'Rak A-1, Lantai 2',
                'status' => 'available',
                'category_id' => $categories['D3-TPU'] ?? null,
                'subjects' => 'Penerbangan, Avionik, Teknologi',
                'stock' => 5
            ],
            [
                'title' => 'Teknologi Avionik Modern',
                'author' => 'Prof. Budi Santoso',
                'isbn' => '978-602-234-567-8',
                'publisher' => 'Airlangga Press',
                'year' => 2022,
                'pages' => 280,
                'language' => 'Indonesia',
                'description' => 'Panduan lengkap tentang teknologi avionik terkini dalam industri penerbangan.',
                'location' => 'Rak A-2, Lantai 2',
                'status' => 'available',
                'category_id' => $categories['D3-TPU'] ?? null,
                'subjects' => 'Avionik, Elektronika, Sistem Navigasi',
                'stock' => 3
            ],
            [
                'title' => 'Keselamatan Penerbangan',
                'author' => 'Ir. Siti Nurhaliza',
                'isbn' => '978-602-345-678-9',
                'publisher' => 'Aviation Safety Publisher',
                'year' => 2021,
                'pages' => 245,
                'language' => 'Indonesia',
                'description' => 'Buku komprehensif tentang sistem keselamatan dalam industri penerbangan.',
                'location' => 'Rak B-1, Lantai 2', 
                'status' => 'available',
                'category_id' => $categories['D3-KPU'] ?? null,
                'subjects' => 'Keselamatan, Safety Management, Penerbangan',
                'stock' => 4
            ],
            
            // Teknik Bangunan dan Bandar Udara
            [
                'title' => 'Konstruksi Bandar Udara',
                'author' => 'Dr. Eng. Bambang Riyanto',
                'isbn' => '978-602-456-789-0',
                'publisher' => 'Teknik Sipil Press',
                'year' => 2023,
                'pages' => 410,
                'language' => 'Indonesia',
                'description' => 'Panduan teknis tentang perencanaan dan konstruksi infrastruktur bandar udara.',
                'location' => 'Rak C-1, Lantai 1',
                'status' => 'available',
                'category_id' => $categories['D3-TBU'] ?? null,
                'subjects' => 'Konstruksi, Infrastruktur, Bandar Udara',
                'stock' => 2
            ],
            [
                'title' => 'Sistem Drainase Bandar Udara',
                'author' => 'Ir. Made Sutrisna',
                'isbn' => '978-602-567-890-1',
                'publisher' => 'Graha Ilmu',
                'year' => 2022,
                'pages' => 185,
                'language' => 'Indonesia',
                'description' => 'Sistem drainase dan pengelolaan air di area bandar udara.',
                'location' => 'Rak C-2, Lantai 1',
                'status' => 'available',
                'category_id' => $categories['D3-TBU'] ?? null,
                'subjects' => 'Drainase, Hidrologi, Teknik Sipil',
                'stock' => 3
            ],
            
            // Elektronika Bandar Udara
            [
                'title' => 'Sistem Komunikasi Penerbangan',
                'author' => 'Dr. Agus Setiawan',
                'isbn' => '978-602-678-901-2',
                'publisher' => 'Elektro Publishing',
                'year' => 2023,
                'pages' => 295,
                'language' => 'Indonesia',
                'description' => 'Teknologi komunikasi dan elektronika dalam operasional bandar udara.',
                'location' => 'Rak D-1, Lantai 3',
                'status' => 'available',
                'category_id' => $categories['D3-EAU'] ?? null,
                'subjects' => 'Komunikasi, Elektronika, Radar',
                'stock' => 4
            ],
            [
                'title' => 'Teknologi Radar Bandar Udara', 
                'author' => 'Prof. Dr. Hendri Laksono',
                'isbn' => '978-602-789-012-3',
                'publisher' => 'Radar Tech Books',
                'year' => 2021,
                'pages' => 350,
                'language' => 'Indonesia',
                'description' => 'Sistem radar untuk navigasi dan kontrol lalu lintas udara.',
                'location' => 'Rak D-2, Lantai 3',
                'status' => 'available',
                'category_id' => $categories['D3-EAU'] ?? null,
                'subjects' => 'Radar, Navigasi, Kontrol Lalu Lintas',
                'stock' => 2
            ],
            
            // Umum
            [
                'title' => 'Bahasa Inggris untuk Penerbangan',
                'author' => 'Sarah Johnson',
                'isbn' => '978-602-890-123-4',
                'publisher' => 'Aviation English Press',
                'year' => 2023,
                'pages' => 220,
                'language' => 'Indonesia/Inggris',
                'description' => 'Panduan bahasa Inggris khusus untuk komunikasi dalam industri penerbangan.',
                'location' => 'Rak E-1, Lantai 1',
                'status' => 'available',
                'category_id' => $categories['UMUM'] ?? null,
                'subjects' => 'Bahasa Inggris, Komunikasi, Penerbangan',
                'stock' => 6
            ],
            [
                'title' => 'Manajemen Bandar Udara',
                'author' => 'Dr. Sutomo Wijaya',
                'isbn' => '978-602-901-234-5',
                'publisher' => 'Management Press',
                'year' => 2022,
                'pages' => 380,
                'language' => 'Indonesia',
                'description' => 'Konsep dan praktik manajemen operasional bandar udara.',
                'location' => 'Rak E-2, Lantai 1',
                'status' => 'borrowed',
                'category_id' => $categories['UMUM'] ?? null,
                'subjects' => 'Manajemen, Operasional, Administrasi',
                'stock' => 1
            ]
        ];
        
        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
