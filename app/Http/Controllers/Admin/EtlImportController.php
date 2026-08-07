<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use SplFileObject;

class EtlImportController extends Controller
{
    // ─────────────────────────────────────────────
    //  GET /admin/etl-import
    // ─────────────────────────────────────────────
    public function index()
    {
        $stats = [
            'total_books'      => Book::count(),
            'total_categories' => Category::count(),
            'last_import'      => cache('etl_last_import'),
        ];
        return view('admin.etl.index', compact('stats'));
    }

    // ─────────────────────────────────────────────
    //  POST /admin/etl-import/preview
    // ─────────────────────────────────────────────
    public function preview(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|max:20480',
            'csv_type' => 'required|in:biblio,item',
        ], [
            'csv_file.required' => 'File CSV wajib diupload.',
            'csv_file.max'      => 'Ukuran file maksimum 20 MB.',
            'csv_type.required' => 'Tipe CSV wajib dipilih.',
        ]);

        $fileUploaded = $request->file('csv_file');
        $ext = strtolower($fileUploaded->getClientOriginalExtension());
        if (!in_array($ext, ['csv', 'txt'])) {
            return response()->json([
                'success' => false,
                'message' => 'Format file harus ber-ekstensi .csv atau .txt (File yang diupload: .' . $ext . ')'
            ], 422);
        }

        $path    = $request->file('csv_file')->getRealPath();
        $csvType = $request->csv_type;
        $preview = [];
        $headers = [];
        $total   = 0;

        $file = new SplFileObject($path, 'r');
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD);

        $isHeader = ($csvType === 'biblio'); // biblio punya header row, item tidak

        foreach ($file as $row) {
            if (empty($row) || (count($row) === 1 && $row[0] === null)) continue;

            if ($isHeader && empty($headers)) {
                $row[0]  = ltrim($row[0], "\xEF\xBB\xBF");
                $headers = array_map('trim', $row);
                continue;
            }

            $total++;
            if ($total <= 5) {
                if (!empty($headers)) {
                    $preview[] = array_combine(
                        array_slice($headers, 0, count($row)),
                        array_map('trim', $row)
                    );
                } else {
                    // Item CSV pakai kolom bawaan
                    $itemCols = ['item_code','call_number','gmd_name','biblio_id','date_in',
                                 'c6','c7','location','c9','c10','c11','stock','c13','c14',
                                 'c15','c16','created_at','updated_at','title'];
                    $preview[] = array_combine(
                        array_slice($itemCols, 0, count($row)),
                        array_map('trim', $row)
                    );
                    $headers = $itemCols;
                }
            }
        }

        $tmpPath = $request->file('csv_file')->store('etl_tmp', 'local');

        return response()->json([
            'success'  => true,
            'headers'  => $headers,
            'preview'  => $preview,
            'total'    => $total,
            'tmp_path' => $tmpPath,
            'csv_type' => $csvType,
        ]);
    }

    // ─────────────────────────────────────────────
    //  POST /admin/etl-import/run
    // ─────────────────────────────────────────────
    public function run(Request $request)
    {
        $request->validate([
            'tmp_path' => 'required|string',
            'csv_type' => 'required|in:biblio,item',
            'mode'     => 'required|in:insert_new,upsert,dry_run',
        ]);

        $tmpPath = storage_path('app/' . $request->tmp_path);
        $csvType = $request->csv_type;
        $mode    = $request->mode;

        if (!file_exists($tmpPath)) {
            return response()->json(['success' => false, 'message' => 'File sementara tidak ditemukan. Upload ulang file CSV.'], 422);
        }

        $result = ($csvType === 'biblio')
            ? $this->processBiblioCSV($tmpPath, $mode)
            : $this->processItemCSV($tmpPath, $mode);

        if ($result['success'] && $mode !== 'dry_run') {
            @unlink($tmpPath);
            cache(['etl_last_import' => [
                'type'      => $csvType,
                'mode'      => $mode,
                'inserted'  => $result['inserted'],
                'updated'   => $result['updated'],
                'skipped'   => $result['skipped'],
                'errors'    => count($result['errors']),
                'timestamp' => now()->format('d M Y H:i'),
            ]], now()->addDays(7));
        }

        return response()->json($result);
    }

    // ─────────────────────────────────────────────
    //  POST /admin/etl-import/chunk
    //  Proses satu chunk (150 baris) — dipanggil
    //  berulang oleh frontend untuk progress real
    // ─────────────────────────────────────────────
    public function runChunk(Request $request)
    {
        $request->validate([
            'tmp_path'    => 'required|string',
            'csv_type'    => 'required|in:biblio,item',
            'mode'        => 'required|in:insert_new,upsert,dry_run',
            'offset'      => 'required|integer|min:0',
            'chunk_size'  => 'required|integer|min:1|max:500',
            'session_key' => 'required|string|max:64',
        ]);

        $tmpPath    = storage_path('app/' . $request->tmp_path);
        $csvType    = $request->csv_type;
        $mode       = $request->mode;
        $offset     = (int) $request->offset;
        $chunkSize  = (int) $request->chunk_size;
        $cacheKey   = 'etl_chunk_' . preg_replace('/[^a-zA-Z0-9_]/', '', $request->session_key);

        if (!file_exists($tmpPath)) {
            return response()->json(['success' => false, 'message' => 'File tidak ditemukan. Upload ulang CSV.'], 422);
        }

        // Ambil accumulated state dari cache
        $state = cache($cacheKey) ?? [
            'inserted'      => 0,
            'updated'       => 0,
            'skipped'       => 0,
            'errors'        => [],
            'categoryCache' => Category::pluck('id', 'name')->toArray(),
        ];

        // Proses chunk sesuai tipe
        if ($csvType === 'biblio') {
            $chunk = $this->processBiblioChunk(
                $tmpPath, $mode, $offset, $chunkSize, $state['categoryCache']
            );
            $state['categoryCache'] = $chunk['categoryCache'];
        } else {
            $chunk = $this->processItemChunk($tmpPath, $mode, $offset, $chunkSize);
        }

        // Akumulasi hasil
        $state['inserted'] += $chunk['inserted'];
        $state['updated']  += $chunk['updated'];
        $state['skipped']  += $chunk['skipped'];
        $state['errors']    = array_merge($state['errors'], $chunk['errors']);

        $nextOffset = $offset + $chunk['processed'];
        $isDone     = $chunk['processed'] < $chunkSize; // chunk terakhir jika kurang dari ukuran

        if ($isDone) {
            // Import selesai — cleanup
            cache()->forget($cacheKey);
            if ($mode !== 'dry_run') {
                @unlink($tmpPath);
                cache(['etl_last_import' => [
                    'type'      => $csvType,
                    'mode'      => $mode,
                    'inserted'  => $state['inserted'],
                    'updated'   => $state['updated'],
                    'skipped'   => $state['skipped'],
                    'errors'    => count($state['errors']),
                    'timestamp' => now()->format('d M Y H:i'),
                ]], now()->addDays(7));
            }
        } else {
            // Simpan state untuk chunk berikutnya
            cache([$cacheKey => $state], now()->addMinutes(30));
        }

        return response()->json([
            'success'     => true,
            'done'        => $isDone,
            'next_offset' => $nextOffset,
            'processed'   => $chunk['processed'],
            'inserted'    => $state['inserted'],
            'updated'     => $state['updated'],
            'skipped'     => $state['skipped'],
            'errors'      => array_slice($state['errors'], 0, 50),
        ]);
    }

    // ─────────────────────────────────────────────
    //  ETL: Biblio CSV → books table
    // ─────────────────────────────────────────────
    private function processBiblioCSV(string $path, string $mode): array
    {
        $inserted      = 0;
        $updated       = 0;
        $skipped       = 0;
        $errors        = [];
        $rowNum        = 0;
        $categoryCache = Category::pluck('id', 'name')->toArray();

        $file = new SplFileObject($path, 'r');
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD);

        $headers = [];

        foreach ($file as $rawRow) {
            if (empty($rawRow) || (count($rawRow) === 1 && $rawRow[0] === null)) continue;

            if (empty($headers)) {
                $rawRow[0] = ltrim($rawRow[0], "\xEF\xBB\xBF");
                $headers   = array_map('trim', $rawRow);
                $rowNum++;
                continue;
            }

            $rowNum++;
            if (count($rawRow) < 3) { $skipped++; continue; }

            // ── EXTRACT ──────────────────────────────────
            $row = [];
            foreach ($headers as $i => $h) {
                $row[$h] = isset($rawRow[$i]) ? $this->clean($rawRow[$i]) : '';
            }

            // ── TRANSFORM ────────────────────────────────
            $title = Str::limit(trim($row['title'] ?? ''), 500);
            if (empty($title)) { $skipped++; continue; }

            $authors = $this->parseAngled($row['authors'] ?? '');
            $author  = Str::limit(implode('; ', array_slice($authors, 0, 3)) ?: 'Unknown', 255);
            $topics  = implode(', ', $this->parseAngled($row['topics'] ?? ''));
            $items   = implode(', ', array_slice($this->parseAngled($row['item_code'] ?? ''), 0, 5));

            $year  = null;
            if (!empty($row['publish_year'])) {
                preg_match('/(\d{4})/', $row['publish_year'], $m);
                $year = isset($m[1]) ? (int)$m[1] : null;
            }

            $pages = null;
            if (!empty($row['collation'])) {
                preg_match('/(\d+)\s*(?:hlm|hal|p\b|pp\b)/', $row['collation'], $pm);
                $pages = isset($pm[1]) ? (int)$pm[1] : null;
            }

            $isbn = Str::limit(preg_replace('/[^0-9\-xX]/', '', $row['isbn_issn'] ?? ''), 30) ?: null;

            $lang = match(strtolower($row['language_name'] ?? '')) {
                'indonesia','indonesian','bahasa indonesia' => 'Indonesia',
                'english','inggris'                        => 'English',
                'arab','arabic'                            => 'Arabic',
                default => Str::limit($row['language_name'] ?? 'Indonesia', 50),
            };

            // Auto-create kategori dari DDC + GMD
            $classCode = trim($row['classification'] ?? '');
            $catName   = $this->ddcToCategory($classCode, $row['gmd_name'] ?? '');
            $catId     = null;

            if ($catName && $mode !== 'dry_run') {
                if (!isset($categoryCache[$catName])) {
                    $cat = Category::firstOrCreate(
                        ['name' => $catName],
                        ['code' => Str::upper(Str::slug($catName, '-')), 'is_active' => true]
                    );
                    $categoryCache[$catName] = $cat->id;
                }
                $catId = $categoryCache[$catName];
            }

            $bookData = [
                'title'          => $title,
                'author'         => $author,
                'isbn'           => $isbn,
                'publisher'      => Str::limit(trim($row['publisher_name'] ?? ''), 200) ?: null,
                'year'           => $year,
                'pages'          => $pages,
                'language'       => $lang,
                'description'    => Str::limit(trim($row['notes'] ?? ''), 3000) ?: null,
                'location'       => null,
                'status'         => 'available',
                'category_id'    => $catId,
                'cover_image'    => Str::limit(trim($row['image'] ?? ''), 255) ?: null,
                'subjects'       => Str::limit($topics, 500) ?: null,
                'stock'          => 1,
                'gmd_name'       => Str::limit(trim($row['gmd_name'] ?? ''), 100) ?: null,
                'call_number'    => Str::limit(trim($row['call_number'] ?? ''), 100) ?: null,
                'place_name'     => Str::limit(trim($row['place_name'] ?? ''), 100) ?: null,
                'classification' => Str::limit($classCode, 50) ?: null,
                'series_title'   => Str::limit(trim($row['series_title'] ?? ''), 200) ?: null,
                'collation'      => Str::limit(trim($row['collation'] ?? ''), 200) ?: null,
                'cover_url'      => Str::limit(trim($row['image'] ?? ''), 255) ?: null,
                'item_code'      => Str::limit($items, 255) ?: null,
                'topics'         => Str::limit($topics, 500) ?: null,
            ];

            // ── LOAD ─────────────────────────────────────
            if ($mode === 'dry_run') { $inserted++; continue; }

            try {
                if ($mode === 'upsert') {
                    $existing = $isbn ? Book::where('isbn', $isbn)->first() : null;
                    if (!$existing) {
                        $existing = Book::where('title', $title)->where('author', $author)->first();
                    }
                    if ($existing) {
                        $existing->update($bookData);
                        $updated++;
                    } else {
                        Book::create($bookData);
                        $inserted++;
                    }
                } else {
                    $exists = ($isbn && Book::where('isbn', $isbn)->exists())
                           || Book::where('title', $title)->where('author', $author)->exists();
                    if ($exists) {
                        $skipped++;
                    } else {
                        Book::create($bookData);
                        $inserted++;
                    }
                }
            } catch (\Throwable $e) {
                $errors[] = "Baris {$rowNum} (\"{$title}\"): " . Str::limit($e->getMessage(), 120);
                Log::warning("ETL row {$rowNum}", ['err' => $e->getMessage()]);
            }
        }

        return [
            'success'  => true,
            'mode'     => $mode,
            'type'     => 'biblio',
            'total'    => $rowNum - 1,
            'inserted' => $inserted,
            'updated'  => $updated,
            'skipped'  => $skipped,
            'errors'   => array_slice($errors, 0, 50),
        ];
    }

    // ─────────────────────────────────────────────
    //  Biblio: proses satu chunk (offset → offset+limit)
    // ─────────────────────────────────────────────
    private function processBiblioChunk(
        string $path, string $mode, int $offset, int $limit, array $categoryCache
    ): array {
        $inserted  = 0;
        $updated   = 0;
        $skipped   = 0;
        $errors    = [];
        $processed = 0;   // jumlah baris data yg diproses chunk ini
        $dataRow   = 0;   // counter baris data (excluding header)

        $file = new SplFileObject($path, 'r');
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD);

        $headers = [];

        foreach ($file as $rawRow) {
            if (empty($rawRow) || (count($rawRow) === 1 && $rawRow[0] === null)) continue;

            // Baris header
            if (empty($headers)) {
                $rawRow[0] = ltrim($rawRow[0], "\xEF\xBB\xBF");
                $headers   = array_map('trim', $rawRow);
                continue;
            }

            // Lewati baris sebelum offset
            if ($dataRow < $offset) { $dataRow++; continue; }

            // Stop setelah limit terpenuhi
            if ($processed >= $limit) break;

            $dataRow++;
            $processed++;

            if (count($rawRow) < 3) { $skipped++; continue; }

            // ── EXTRACT ──────────────────────────────────
            $row = [];
            foreach ($headers as $i => $h) {
                $row[$h] = isset($rawRow[$i]) ? $this->clean($rawRow[$i]) : '';
            }

            // ── TRANSFORM ────────────────────────────────
            $title = Str::limit(trim($row['title'] ?? ''), 500);
            if (empty($title)) { $skipped++; continue; }

            $authors = $this->parseAngled($row['authors'] ?? '');
            $author  = Str::limit(implode('; ', array_slice($authors, 0, 3)) ?: 'Unknown', 255);
            $topics  = implode(', ', $this->parseAngled($row['topics'] ?? ''));
            $items   = implode(', ', array_slice($this->parseAngled($row['item_code'] ?? ''), 0, 5));

            $year = null;
            if (!empty($row['publish_year'])) {
                preg_match('/(\d{4})/', $row['publish_year'], $m);
                $year = isset($m[1]) ? (int)$m[1] : null;
            }

            $pages = null;
            if (!empty($row['collation'])) {
                preg_match('/(\d+)\s*(?:hlm|hal|p\b|pp\b)/', $row['collation'], $pm);
                $pages = isset($pm[1]) ? (int)$pm[1] : null;
            }

            $isbn = Str::limit(preg_replace('/[^0-9\-xX]/', '', $row['isbn_issn'] ?? ''), 30) ?: null;

            $lang = match(strtolower($row['language_name'] ?? '')) {
                'indonesia','indonesian','bahasa indonesia' => 'Indonesia',
                'english','inggris'                        => 'English',
                'arab','arabic'                            => 'Arabic',
                default => Str::limit($row['language_name'] ?? 'Indonesia', 50),
            };

            $classCode = trim($row['classification'] ?? '');
            $catName   = $this->ddcToCategory($classCode, $row['gmd_name'] ?? '');
            $catId     = null;

            if ($catName && $mode !== 'dry_run') {
                if (!isset($categoryCache[$catName])) {
                    $cat = Category::firstOrCreate(
                        ['name' => $catName],
                        ['code' => Str::upper(Str::slug($catName, '-')), 'is_active' => true]
                    );
                    $categoryCache[$catName] = $cat->id;
                }
                $catId = $categoryCache[$catName];
            }

            $bookData = [
                'title'          => $title,
                'author'         => $author,
                'isbn'           => $isbn,
                'publisher'      => Str::limit(trim($row['publisher_name'] ?? ''), 200) ?: null,
                'year'           => $year,
                'pages'          => $pages,
                'language'       => $lang,
                'description'    => Str::limit(trim($row['notes'] ?? ''), 3000) ?: null,
                'location'       => null,
                'status'         => 'available',
                'category_id'    => $catId,
                'cover_image'    => Str::limit(trim($row['image'] ?? ''), 255) ?: null,
                'subjects'       => Str::limit($topics, 500) ?: null,
                'stock'          => 1,
                'gmd_name'       => Str::limit(trim($row['gmd_name'] ?? ''), 100) ?: null,
                'call_number'    => Str::limit(trim($row['call_number'] ?? ''), 100) ?: null,
                'place_name'     => Str::limit(trim($row['place_name'] ?? ''), 100) ?: null,
                'classification' => Str::limit($classCode, 50) ?: null,
                'series_title'   => Str::limit(trim($row['series_title'] ?? ''), 200) ?: null,
                'collation'      => Str::limit(trim($row['collation'] ?? ''), 200) ?: null,
                'cover_url'      => Str::limit(trim($row['image'] ?? ''), 255) ?: null,
                'item_code'      => Str::limit($items, 255) ?: null,
                'topics'         => Str::limit($topics, 500) ?: null,
            ];

            // ── LOAD ─────────────────────────────────────
            if ($mode === 'dry_run') { $inserted++; continue; }

            try {
                if ($mode === 'upsert') {
                    $existing = $isbn ? Book::where('isbn', $isbn)->first() : null;
                    if (!$existing) {
                        $existing = Book::where('title', $title)->where('author', $author)->first();
                    }
                    if ($existing) { $existing->update($bookData); $updated++; }
                    else           { Book::create($bookData);      $inserted++; }
                } else {
                    $exists = ($isbn && Book::where('isbn', $isbn)->exists())
                           || Book::where('title', $title)->where('author', $author)->exists();
                    if ($exists) { $skipped++; }
                    else         { Book::create($bookData); $inserted++; }
                }
            } catch (\Throwable $e) {
                $errors[] = 'Offset ' . ($offset + $processed) . " (\"{$title}\"): " . Str::limit($e->getMessage(), 100);
                Log::warning('ETL chunk error', ['offset' => $offset + $processed, 'err' => $e->getMessage()]);
            }
        }

        return [
            'inserted'      => $inserted,
            'updated'       => $updated,
            'skipped'       => $skipped,
            'errors'        => $errors,
            'processed'     => $processed,
            'categoryCache' => $categoryCache,
        ];
    }

    // ─────────────────────────────────────────────
    //  Item: proses satu chunk eksemplar
    // ─────────────────────────────────────────────
    private function processItemChunk(
        string $path, string $mode, int $offset, int $limit
    ): array {
        $updated   = 0;
        $skipped   = 0;
        $errors    = [];
        $processed = 0;
        $dataRow   = 0;
        $stockMap  = [];

        $file = new SplFileObject($path, 'r');
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD);

        foreach ($file as $rawRow) {
            if (empty($rawRow) || (count($rawRow) === 1 && $rawRow[0] === null)) continue;

            if ($dataRow < $offset) { $dataRow++; continue; }
            if ($processed >= $limit) break;

            $dataRow++;
            $processed++;

            $title    = isset($rawRow[18]) ? trim($this->clean($rawRow[18])) : '';
            $itemCode = isset($rawRow[0])  ? trim($this->clean($rawRow[0]))  : '';
            $callNo   = isset($rawRow[1])  ? trim($this->clean($rawRow[1]))  : '';
            $location = isset($rawRow[7])  ? trim($this->clean($rawRow[7]))  : '';

            if (empty($title)) { $skipped++; continue; }

            if (!isset($stockMap[$title])) {
                $stockMap[$title] = ['count' => 0, 'codes' => [], 'call_no' => $callNo, 'location' => $location];
            }
            $stockMap[$title]['count']++;
            if (count($stockMap[$title]['codes']) < 5) $stockMap[$title]['codes'][] = $itemCode;
        }

        if ($mode !== 'dry_run') {
            foreach ($stockMap as $title => $data) {
                try {
                    $book = $this->findBookByTitle($title);
                    if ($book) {
                        $upd = ['stock' => $data['count']];
                        if ($data['location']) $upd['location']    = $data['location'];
                        if ($data['codes'])    $upd['item_code']   = implode(', ', $data['codes']);
                        if ($data['call_no'])  $upd['call_number'] = $data['call_no'];
                        $book->update($upd);
                        $updated++;
                    } else {
                        $skipped++;
                    }
                } catch (\Throwable $e) {
                    $errors[] = "\"{$title}\": " . Str::limit($e->getMessage(), 100);
                }
            }
        } else {
            $updated = count($stockMap);
        }

        return [
            'inserted'  => 0,
            'updated'   => $updated,
            'skipped'   => $skipped,
            'errors'    => $errors,
            'processed' => $processed,
        ];
    }

    // ─────────────────────────────────────────────
    //  ETL: Item CSV → update stock di books
    // ─────────────────────────────────────────────
    private function processItemCSV(string $path, string $mode): array
    {
        $updated  = 0;
        $skipped  = 0;
        $errors   = [];
        $rowNum   = 0;
        $stockMap = [];

        $file = new SplFileObject($path, 'r');
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD);

        foreach ($file as $rawRow) {
            if (empty($rawRow) || (count($rawRow) === 1 && $rawRow[0] === null)) continue;
            $rowNum++;

            $title    = isset($rawRow[18]) ? trim($this->clean($rawRow[18])) : '';
            $itemCode = isset($rawRow[0])  ? trim($this->clean($rawRow[0]))  : '';
            $callNo   = isset($rawRow[1])  ? trim($this->clean($rawRow[1]))  : '';
            $location = isset($rawRow[7])  ? trim($this->clean($rawRow[7]))  : '';

            if (empty($title)) { $skipped++; continue; }

            if (!isset($stockMap[$title])) {
                $stockMap[$title] = ['count' => 0, 'codes' => [], 'call_no' => $callNo, 'location' => $location];
            }
            $stockMap[$title]['count']++;
            if (count($stockMap[$title]['codes']) < 5) $stockMap[$title]['codes'][] = $itemCode;
        }

        if ($mode === 'dry_run') {
            return [
                'success'  => true, 'mode' => 'dry_run', 'type' => 'item',
                'total'    => $rowNum, 'inserted' => 0,
                'updated'  => count($stockMap), 'skipped' => $skipped, 'errors' => [],
                'dry_note' => count($stockMap) . ' judul buku akan diperbarui stoknya.',
            ];
        }

        foreach ($stockMap as $title => $data) {
            try {
                $book = $this->findBookByTitle($title);
                if ($book) {
                    $upd = ['stock' => $data['count']];
                    if ($data['location']) $upd['location']    = $data['location'];
                    if ($data['codes'])    $upd['item_code']   = implode(', ', $data['codes']);
                    if ($data['call_no'])  $upd['call_number'] = $data['call_no'];
                    $book->update($upd);
                    $updated++;
                } else {
                    $skipped++;
                }
            } catch (\Throwable $e) {
                $errors[] = "\"{$title}\": " . Str::limit($e->getMessage(), 100);
            }
        }

        return [
            'success'  => true, 'mode' => $mode, 'type' => 'item',
            'total'    => $rowNum, 'inserted' => 0,
            'updated'  => $updated, 'skipped' => $skipped,
            'errors'   => array_slice($errors, 0, 50),
        ];
    }

    // ─────────────────────────────────────────────
    //  HELPERS
    // ─────────────────────────────────────────────
    private function clean(string $v): string { return trim(str_replace(['"', "'"], '', $v)); }

    private function parseAngled(string $v): array
    {
        preg_match_all('/<([^>]+)>/', $v, $m);
        return isset($m[1]) ? array_values(array_filter(array_map('trim', $m[1]))) : [];
    }

    private function ddcToCategory(string $code, string $gmd): string
    {
        $g = strtolower($gmd);
        if (Str::contains($g, ['jurnal','journal','periodical','berkala'])) return 'Jurnal & Berkala';
        if (Str::contains($g, ['tugas akhir','skripsi','thesis','laporan ta'])) return 'Karya Ilmiah';
        if (Str::contains($g, ['standar','standard','regulation','annex','peraturan'])) return 'Regulasi & Standar';
        if (Str::contains($g, ['map','atlas','peta'])) return 'Peta & Atlas';
        if (Str::contains($g, ['cd','dvd','multimedia'])) return 'Multimedia';

        $n = (int) preg_replace('/[^0-9]/', '', substr($code, 0, 3));
        return match(true) {
            $n < 100   => 'Ilmu Komputer & Umum',
            $n < 200   => 'Filsafat & Psikologi',
            $n < 300   => 'Agama',
            $n < 400   => 'Ilmu Sosial',
            $n < 500   => 'Bahasa',
            $n < 600   => 'Ilmu Alam & Matematika',
            $n < 630   => 'Teknologi & Teknik',
            $n < 700   => 'Pertanian & Industri',
            $n < 800   => 'Seni & Olahraga',
            $n < 900   => 'Sastra',
            $n < 1000  => 'Sejarah & Geografi',
            default    => 'Buku Umum',
        };
    }

    private function findBookByTitle(string $title): ?Book
    {
        $normalized = trim(preg_replace('/\s+/', ' ', $title));

        if ($normalized === '') {
            return null;
        }

        $exactMatch = Book::whereRaw('LOWER(TRIM(title)) = ?', [Str::lower($normalized)])
            ->first();

        if ($exactMatch) {
            return $exactMatch;
        }

        return Book::whereRaw('LOWER(title) LIKE ?', ['%' . Str::lower($normalized) . '%'])
            ->first();
    }
}
