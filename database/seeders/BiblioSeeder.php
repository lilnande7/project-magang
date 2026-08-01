<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class BiblioSeeder extends Seeder
{
    /**
     * Import data koleksi dari senayan_biblio_export.csv ke tabel books.
     * Kolom CSV: title, gmd_name, edition, isbn_issn, publisher_name,
     *            publish_year, collation, series_title, call_number,
     *            language_name, place_name, classification, notes, image,
     *            sor, authors, topics, item_code
     */
    public function run(): void
    {
        $csvPath = base_path('training/senayan_biblio_export.csv');

        if (!file_exists($csvPath)) {
            $this->command->error("File tidak ditemukan: $csvPath");
            return;
        }

        $file = fopen($csvPath, 'r');
        // Baca header
        $headers = fgetcsv($file);
        if (!$headers) {
            $this->command->error('CSV kosong atau header tidak terbaca.');
            fclose($file);
            return;
        }

        // Map header ke index (trim whitespace & BOM)
        $headers = array_map(fn($h) => trim(preg_replace('/\x{FEFF}/u', '', $h)), $headers);
        $idx = array_flip($headers);

        // Buat atau ambil kategori default
        $categoryCache = [];
        $getOrCreateCategory = function (string $name) use (&$categoryCache): int {
            $key = strtolower(trim($name)) ?: 'umum';
            if (!isset($categoryCache[$key])) {
                $cleanName = ucfirst(trim($name)) ?: 'Umum';
                // Buat kode unik dari nama (maks 20 char)
                $code = strtoupper(preg_replace('/[^A-Za-z0-9]/', '_', substr($cleanName, 0, 18)));
                $code = rtrim($code, '_') ?: 'UMUM';
                // Pastikan kode unik jika sudah ada
                $baseCode = $code;
                $i = 1;
                while (Category::where('code', $code)->exists() && !Category::where('name', $cleanName)->exists()) {
                    $code = $baseCode . '_' . $i++;
                }
                $cat = Category::firstOrCreate(
                    ['name' => $cleanName],
                    ['code' => $code, 'description' => 'Diimport dari SLiMS', 'is_active' => true]
                );
                $categoryCache[$key] = $cat->id;
            }
            return $categoryCache[$key];
        };

        $inserted = 0;
        $skipped  = 0;
        $batchSize = 100;
        $batch = [];

        $col = fn(array $row, string $name, string $default = '') =>
            isset($idx[$name]) && isset($row[$idx[$name]])
                ? trim($row[$idx[$name]])
                : $default;

        // Fungsi bersihkan tag <> dari SLiMS export
        $clean = fn(string $v) => trim(preg_replace('/[<>]/', '', $v));

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 3) continue;

            $title = $col($row, 'title');
            if (empty($title)) { $skipped++; continue; }

            $author  = $clean($col($row, 'authors', 'Unknown'));
            $topics  = $clean($col($row, 'topics', ''));
            $itemCode = $clean($col($row, 'item_code', ''));
            $isbn    = $col($row, 'isbn_issn', '');
            $pub     = $col($row, 'publisher_name', '');
            $year    = $col($row, 'publish_year', '');
            $yearInt = is_numeric($year) ? (int)$year : null;
            $lang    = $col($row, 'language_name', 'Indonesia');
            $place   = $col($row, 'place_name', '');
            $gmd     = $col($row, 'gmd_name', 'Text');
            $edition = $col($row, 'edition', '');
            $notes   = $col($row, 'notes', '');
            $image   = $col($row, 'image', '');
            $callNum = $col($row, 'call_number', '');
            $classif = $col($row, 'classification', '');
            $series  = $col($row, 'series_title', '');
            $collat  = $col($row, 'collation', '');

            // Tentukan kategori berdasarkan classification (DDC prefix)
            $classPrefix = substr($classif, 0, 3);
            $catName = $this->getDdcCategory($classPrefix);
            $catId   = $getOrCreateCategory($catName);

            // Hitung stok dari item_code (jumlah kode yang dipisah <>)
            preg_match_all('/<([^>]+)>/', $col($row, 'item_code', ''), $matches);
            $stock = max(1, count($matches[1]));

            $now = now()->toDateTimeString();
            $batch[] = [
                'title'          => $title,
                'author'         => $author ?: 'Unknown',
                'isbn'           => $isbn ?: null,
                'publisher'      => $pub ?: null,
                'year'           => $yearInt,
                'language'       => $lang,
                'description'    => $notes ?: null,
                'location'       => $callNum ?: null,
                'status'         => 'available',
                'category_id'    => $catId,
                'cover_image'    => null,
                'subjects'       => $topics ?: null,
                'stock'          => $stock,
                // kolom baru biblio
                'gmd_name'       => $gmd ?: null,
                'call_number'    => $callNum ?: null,
                'place_name'     => $place ?: null,
                'classification' => $classif ?: null,
                'series_title'   => ($series && $series !== $title) ? $series : null,
                'collation'      => $collat ?: null,
                'cover_url'      => $image ?: null,
                'item_code'      => $itemCode ?: null,
                'topics'         => $topics ?: null,
                'created_at'     => $now,
                'updated_at'     => $now,
            ];

            if (count($batch) >= $batchSize) {
                DB::table('books')->insertOrIgnore($batch);
                $inserted += count($batch);
                $batch = [];
                $this->command->info("Imported $inserted records...");
            }
        }

        if (!empty($batch)) {
            DB::table('books')->insertOrIgnore($batch);
            $inserted += count($batch);
        }

        fclose($file);

        $this->command->info("✅ Selesai! $inserted buku berhasil diimport. $skipped baris dilewati.");
    }

    /**
     * Map 3-digit DDC prefix ke nama kategori
     */
    private function getDdcCategory(string $prefix): string
    {
        $map = [
            '000' => 'Ilmu Komputer & Informasi',
            '001' => 'Ilmu Pengetahuan Umum',
            '020' => 'Ilmu Perpustakaan',
            '100' => 'Filsafat & Psikologi',
            '200' => 'Agama',
            '300' => 'Ilmu Sosial',
            '310' => 'Statistik',
            '330' => 'Ekonomi',
            '340' => 'Hukum',
            '350' => 'Administrasi Publik',
            '370' => 'Pendidikan',
            '380' => 'Perdagangan',
            '390' => 'Adat & Tradisi',
            '400' => 'Bahasa',
            '500' => 'Sains & Matematika',
            '510' => 'Matematika',
            '520' => 'Astronomi',
            '530' => 'Fisika',
            '540' => 'Kimia',
            '550' => 'Ilmu Bumi',
            '560' => 'Paleontologi',
            '570' => 'Biologi',
            '580' => 'Botani',
            '590' => 'Zoologi',
            '600' => 'Teknologi & Ilmu Terapan',
            '610' => 'Ilmu Kedokteran',
            '620' => 'Teknik & Rekayasa',
            '623' => 'Teknik Penerbangan',
            '629' => 'Teknik Penerbangan & Transportasi',
            '630' => 'Pertanian',
            '650' => 'Manajemen & Bisnis',
            '658' => 'Manajemen',
            '700' => 'Seni & Rekreasi',
            '800' => 'Sastra',
            '900' => 'Sejarah & Geografi',
        ];

        $num = intval($prefix);
        // Coba exact match dulu
        if (isset($map[$prefix])) return $map[$prefix];

        // Cari grup terdekat
        $groups = [900,800,700,658,650,629,623,620,610,600,590,570,550,530,510,
                   500,400,390,380,370,350,340,330,310,300,200,100,020,001,000];
        foreach ($groups as $g) {
            if ($num >= $g) return $map[str_pad($g, 3, '0', STR_PAD_LEFT)] ?? 'Umum';
        }

        return 'Umum';
    }
}
