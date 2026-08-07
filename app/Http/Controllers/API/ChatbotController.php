<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use OpenApi\Attributes as OA;
use SplFileObject;

class ChatbotController extends Controller
{
    #[OA\Post(
        path: '/chatbot',
        summary: 'Chatbot AI referensi perpustakaan',
        description: 'Mengirim pesan ke asisten AI perpustakaan yang didukung oleh Google Gemini. Chatbot dapat menjawab pertanyaan seputar koleksi buku, lokasi rak, ketersediaan, dan informasi perpustakaan umum. Chatbot juga memiliki fallback ke dataset Senayan lokal untuk pencarian judul buku secara cepat.',
        tags: ['Chatbot'],
        requestBody: new OA\RequestBody(
            required: true,
            description: 'Pesan pengguna dan riwayat percakapan',
            content: new OA\JsonContent(
                required: ['message'],
                properties: [
                    new OA\Property(
                        property: 'message',
                        type: 'string',
                        maxLength: 1000,
                        example: 'Ada buku tentang sistem navigasi pesawat?',
                        description: 'Pesan / pertanyaan dari pengguna'
                    ),
                    new OA\Property(
                        property: 'history',
                        type: 'array',
                        nullable: true,
                        description: 'Riwayat percakapan sebelumnya (maks 10 pesan)',
                        items: new OA\Items(
                            properties: [
                                new OA\Property(property: 'role',    type: 'string', enum: ['user', 'assistant', 'model'], example: 'user'),
                                new OA\Property(property: 'content', type: 'string', maxLength: 2000, example: 'Halo, saya butuh bantuan'),
                            ]
                        )
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Chatbot berhasil membalas pesan',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status',  type: 'string', example: 'success'),
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: "📚 **Buku ditemukan**\n\n**Judul** : Sistem Navigasi Udara\n**Nomor Panggil** : 629.13\n**Lokasi Rak** : Rak A-5\n**Status** : ✅ Tersedia"
                        ),
                        new OA\Property(
                            property: 'source',
                            type: 'string',
                            enum: ['senayan_dataset', 'gemini_ai'],
                            example: 'gemini_ai',
                            description: 'Sumber jawaban: dataset lokal Senayan atau Gemini AI'
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validasi gagal (pesan kosong atau terlalu panjang)',
                content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse')
            ),
            new OA\Response(
                response: 503,
                description: 'Gemini API tidak tersedia atau konfigurasi belum ada',
                content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse')
            ),
        ]
    )]
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array',
            'history.*.role' => 'nullable|string|in:user,assistant,model',
            'history.*.content' => 'nullable|string|max:2000',
        ]);

        $apiKey = config('services.gemini.api_key');
        $userMessage = trim($validated['message']);

        $senayanItem = $this->findSenayanItem($userMessage);

        if ($senayanItem) {
            return response()->json([
                'status' => 'success',
                'message' => $this->formatSenayanReply($senayanItem),
                'source' => 'senayan_dataset',
            ]);
        }

        if (!$apiKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'GEMINI_API_KEY belum diatur di environment.',
            ], 503);
        }

        $model = config('services.gemini.model', 'gemini-1.5-flash');
        $history = collect($validated['history'] ?? [])
            ->filter(function ($item) {
                return is_array($item)
                    && !empty($item['content'])
                    && in_array($item['role'] ?? 'user', ['user', 'assistant', 'model'], true);
            })
            ->take(10)
            ->values();

        $bookContext = 'Data koleksi belum tersedia saat ini.';

        try {
            $bookContext = Book::query()
                ->with('category')
                ->latest()
                ->limit(8)
                ->get()
                ->map(function (Book $book) {
                    return sprintf(
                        '- %s | Penulis: %s | Kategori: %s | Lokasi: %s | Status: %s | Stok: %s',
                        $book->title,
                        $book->author ?? '-',
                        optional($book->category)->name ?? '-',
                        $book->location ?? '-',
                        $book->status ?? '-',
                        $book->stock ?? 0
                    );
                })
                ->implode("\n");
        } catch (\Throwable $throwable) {
            report($throwable);
        }

        $systemInstruction = trim(<<<TEXT
Anda adalah asisten perpustakaan untuk Perpustakaan Politeknik Penerbangan Indonesia Curug.
Tugas Anda adalah menjawab pertanyaan pengguna dengan sopan, ringkas, dan relevan.
Gunakan data koleksi yang tersedia jika pertanyaan berkaitan dengan buku, kategori, lokasi rak, stok, atau status eksemplar.
Jika data tidak cukup, akui keterbatasannya dan sarankan pengguna menghubungi pustakawan atau mencari di katalog.

Data koleksi terbaru:
{$bookContext}
TEXT);

        $contents = [];

        foreach ($history as $item) {
            $role = $item['role'] ?? 'user';
            $contents[] = [
                'role' => $role === 'assistant' ? 'model' : $role,
                'parts' => [[
                    'text' => trim((string) $item['content']),
                ]],
            ];
        }

        $contents[] = [
            'role' => 'user',
            'parts' => [[
                'text' => $userMessage,
            ]],
        ];

        try {
            $response = Http::timeout(30)
                ->acceptJson()
                ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                    'systemInstruction' => [
                        'parts' => [[
                            'text' => $systemInstruction,
                        ]],
                    ],
                    'contents' => $contents,
                    'generationConfig' => [
                        'temperature' => 0.3,
                        'topP' => 0.9,
                        'maxOutputTokens' => 600,
                    ],
                ]);

            if (!$response->successful()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal menghubungi Gemini API.',
                    'details' => $response->json(),
                ], $response->status());
            }

            $reply = data_get($response->json(), 'candidates.0.content.parts.0.text');

            if (!$reply) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gemini tidak mengembalikan jawaban yang valid.',
                ], 502);
            }

            return response()->json([
                'status' => 'success',
                'message' => $reply,
            ]);
        } catch (\Throwable $throwable) {
            report($throwable);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memproses chatbot.',
            ], 500);
        }
    }

    private function findSenayanItem(string $message): ?array
    {
        $query = $this->normalizeText($message);

        if ($query === '') {
            return null;
        }

        $queryTokens = $this->filterSearchTokens(explode(' ', $query));

        if (empty($queryTokens)) {
            return null;
        }

        $bestItem = null;
        $bestScore = 0;

        foreach ($this->loadSenayanItems() as $item) {
            $score = 0;

            $titleTokens = $item['title_tokens'];

            if ($item['title_normalized'] !== '' && Str::contains($item['title_normalized'], $query)) {
                $score += 140;
            }

            foreach ($queryTokens as $token) {
                if ($item['title_normalized'] !== '' && Str::contains($item['title_normalized'], $token)) {
                    $score += 35;
                }

                if ($item['call_number_normalized'] !== '' && Str::contains($item['call_number_normalized'], $token)) {
                    $score += 18;
                }

                if ($item['code_normalized'] !== '' && Str::contains($item['code_normalized'], $token)) {
                    $score += 10;
                }
            }

            $matchedTokens = count(array_intersect($queryTokens, $titleTokens));
            $score += $matchedTokens * 16;

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestItem = $item;
            }
        }

        return $bestScore >= 30 ? $bestItem : null;
    }

    private function loadSenayanItems(): array
    {
        static $items = null;

        if ($items !== null) {
            return $items;
        }

        $csvPath = base_path('training/senayan_item_export.csv');
        $items = [];

        if (!is_file($csvPath)) {
            return $items;
        }

        $file = new SplFileObject($csvPath);
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);

        foreach ($file as $row) {
            if (!is_array($row) || count($row) < 19) {
                continue;
            }

            $title = trim((string) ($row[18] ?? ''));

            if ($title === '') {
                continue;
            }

            $callNumber = trim((string) ($row[1] ?? ''));
            $code = trim((string) ($row[0] ?? ''));
            $shelf = trim((string) ($row[7] ?? ''));
            $rawStatus = trim((string) ($row[9] ?? ''));

            $items[] = [
                'code' => $code,
                'call_number' => $callNumber,
                'shelf' => $shelf,
                'status' => $rawStatus !== '' ? $rawStatus : 'Available',
                'title' => $title,
                'title_normalized' => $this->normalizeText($title),
                'call_number_normalized' => $this->normalizeText($callNumber),
                'code_normalized' => $this->normalizeText($code),
                'title_tokens' => array_values(array_filter(explode(' ', $this->normalizeText($title)))),
            ];
        }

        return $items;
    }

    private function formatSenayanReply(array $item): string
    {
        $statusLabel = Str::contains(Str::lower($item['status']), 'missing')
            ? '❌ Tidak tersedia'
            : '✅ Tersedia';

        return "📚 **Buku ditemukan**\n\n"
            . "**Judul** : {$item['title']}\n\n"
            . "**Nomor Panggil** : {$item['call_number']}\n\n"
            . "**Lokasi Rak** : {$item['shelf']}\n\n"
            . "**Status** : {$statusLabel}";
    }

    private function normalizeText(string $value): string
    {
        $value = Str::lower($value);
        $value = preg_replace('/[^\pL\pN\s\.\-]+/u', ' ', $value) ?? $value;
        $value = preg_replace('/\s+/', ' ', $value) ?? $value;

        return trim($value);
    }

    private function filterSearchTokens(array $tokens): array
    {
        $stopwords = [
            'buku', 'baca', 'cari', 'cariin', 'carikan', 'tolong', 'mohon', 'ada', 'tentang',
            'judul', 'nomor', 'panggil', 'rak', 'lokasi', 'status', 'yang', 'untuk', 'dengan',
            'di', 'ke', 'dan', 'atau', 'the', 'a', 'an', 'of', 'in', 'on', 'for', 'book',
        ];

        return array_values(array_filter(array_map(function ($token) {
            return $this->normalizeText((string) $token);
        }, $tokens), function ($token) use ($stopwords) {
            return $token !== ''
                && strlen($token) >= 3
                && !in_array($token, $stopwords, true);
        }));
    }
}