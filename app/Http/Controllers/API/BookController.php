<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class BookController extends Controller
{
    /**
     * Display a listing of books with search and filtering
     */
    #[OA\Get(
        path: '/books',
        summary: 'Daftar semua buku',
        description: 'Mengembalikan daftar buku dengan dukungan pencarian teks, filter kategori, filter status, pengurutan, dan paginasi.',
        tags: ['Books'],
        parameters: [
            new OA\Parameter(
                name: 'q',
                in: 'query',
                description: 'Kata kunci pencarian (judul, pengarang, ISBN, subjek)',
                required: false,
                schema: new OA\Schema(type: 'string', example: 'penerbangan')
            ),
            new OA\Parameter(
                name: 'category',
                in: 'query',
                description: 'Filter berdasarkan ID atau nama kategori',
                required: false,
                schema: new OA\Schema(type: 'string', example: '2')
            ),
            new OA\Parameter(
                name: 'status',
                in: 'query',
                description: 'Filter berdasarkan status ketersediaan buku',
                required: false,
                schema: new OA\Schema(type: 'string', enum: ['available', 'borrowed', 'maintenance', 'lost'])
            ),
            new OA\Parameter(
                name: 'sort',
                in: 'query',
                description: 'Field untuk pengurutan',
                required: false,
                schema: new OA\Schema(type: 'string', enum: ['title', 'author', 'year', 'created_at'], default: 'title')
            ),
            new OA\Parameter(
                name: 'direction',
                in: 'query',
                description: 'Arah pengurutan',
                required: false,
                schema: new OA\Schema(type: 'string', enum: ['asc', 'desc'], default: 'asc')
            ),
            new OA\Parameter(
                name: 'per_page',
                in: 'query',
                description: 'Jumlah item per halaman (maksimum 50)',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 15, minimum: 1, maximum: 50)
            ),
            new OA\Parameter(
                name: 'page',
                in: 'query',
                description: 'Nomor halaman',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Berhasil mengambil daftar buku',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(
                                    property: 'data',
                                    type: 'array',
                                    items: new OA\Items(ref: '#/components/schemas/BookResource')
                                ),
                                new OA\Property(property: 'current_page', type: 'integer', example: 1),
                                new OA\Property(property: 'last_page',    type: 'integer', example: 10),
                                new OA\Property(property: 'per_page',     type: 'integer', example: 15),
                                new OA\Property(property: 'total',        type: 'integer', example: 145),
                            ]
                        ),
                        new OA\Property(
                            property: 'filters',
                            type: 'object',
                            properties: [
                                new OA\Property(
                                    property: 'categories',
                                    type: 'array',
                                    items: new OA\Items(ref: '#/components/schemas/CategoryResource')
                                ),
                                new OA\Property(
                                    property: 'statuses',
                                    type: 'array',
                                    items: new OA\Items(type: 'string'),
                                    example: ['available', 'borrowed', 'maintenance', 'lost']
                                ),
                            ]
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $query = Book::with('category');

        if ($request->filled('q')) {
            $query->search($request->q);
        }

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sortField = $request->get('sort', 'title');
        $sortDirection = $request->get('direction', 'asc');

        if (in_array($sortField, ['title', 'author', 'year', 'created_at'])) {
            $query->orderBy($sortField, $sortDirection);
        }

        $perPage = min($request->get('per_page', 15), 50);
        $books = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $books,
            'filters' => [
                'categories' => Category::active()->get(['id', 'name', 'code']),
                'statuses' => ['available', 'borrowed', 'maintenance', 'lost']
            ]
        ]);
    }

    /**
     * Store a newly created book
     */
    #[OA\Post(
        path: '/books',
        summary: 'Tambah buku baru',
        description: 'Menambahkan buku baru ke koleksi perpustakaan. **Memerlukan autentikasi dan hak akses admin.**',
        tags: ['Books'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            description: 'Data buku yang akan ditambahkan',
            content: new OA\JsonContent(
                required: ['title', 'author', 'stock'],
                properties: [
                    new OA\Property(property: 'title',       type: 'string',  maxLength: 255, example: 'Sistem Navigasi Udara'),
                    new OA\Property(property: 'author',      type: 'string',  maxLength: 255, example: 'Ahmad Fauzi'),
                    new OA\Property(property: 'isbn',        type: 'string',  example: '978-602-111-222-3', nullable: true),
                    new OA\Property(property: 'publisher',   type: 'string',  example: 'Pustaka Ilmu', nullable: true),
                    new OA\Property(property: 'year',        type: 'integer', example: 2022, minimum: 1900, maximum: 2030, nullable: true),
                    new OA\Property(property: 'pages',       type: 'integer', example: 280, minimum: 1, nullable: true),
                    new OA\Property(property: 'language',    type: 'string',  example: 'Indonesia', nullable: true),
                    new OA\Property(property: 'description', type: 'string',  example: 'Membahas sistem navigasi modern...', nullable: true),
                    new OA\Property(property: 'location',    type: 'string',  example: 'Rak B-5', nullable: true),
                    new OA\Property(property: 'stock',       type: 'integer', example: 2, minimum: 1),
                    new OA\Property(property: 'status',      type: 'string',  enum: ['available', 'borrowed', 'maintenance', 'lost'], default: 'available'),
                    new OA\Property(property: 'category_id', type: 'integer', example: 3, nullable: true),
                    new OA\Property(property: 'subjects',    type: 'string',  example: 'Navigasi, Avionik', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Buku berhasil ditambahkan',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status',  type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Book created successfully'),
                        new OA\Property(property: 'data',    ref: '#/components/schemas/BookResource'),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Tidak terautentikasi', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse')),
            new OA\Response(response: 403, description: 'Tidak memiliki hak akses', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse')),
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'isbn'        => 'nullable|string|unique:books,isbn',
            'publisher'   => 'nullable|string|max:255',
            'year'        => 'nullable|integer|between:1900,2030',
            'pages'       => 'nullable|integer|min:1',
            'language'    => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'location'    => 'nullable|string|max:255',
            'status'      => 'in:available,borrowed,maintenance,lost',
            'category_id' => 'nullable|exists:categories,id',
            'subjects'    => 'nullable|string',
            'stock'       => 'required|integer|min:1'
        ]);

        $book = Book::create($validatedData);
        $book->load('category');

        return response()->json([
            'status'  => 'success',
            'message' => 'Book created successfully',
            'data'    => $book
        ], 201);
    }

    /**
     * Display the specified book
     */
    #[OA\Get(
        path: '/books/{id}',
        summary: 'Detail buku',
        description: 'Mengembalikan detail lengkap satu buku berdasarkan ID, termasuk kategori dan riwayat peminjaman.',
        tags: ['Books'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID buku',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Detail buku berhasil diambil',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'data',   ref: '#/components/schemas/BookResource'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Buku tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse')),
        ]
    )]
    public function show(Book $book): JsonResponse
    {
        $book->load(['category', 'borrowings.user']);

        return response()->json([
            'status' => 'success',
            'data'   => $book
        ]);
    }

    /**
     * Update the specified book
     */
    #[OA\Put(
        path: '/books/{id}',
        summary: 'Update data buku',
        description: 'Memperbarui informasi buku yang sudah ada. **Memerlukan autentikasi dan hak akses admin.**',
        tags: ['Books'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', example: 1)),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title', 'author', 'stock'],
                properties: [
                    new OA\Property(property: 'title',       type: 'string',  example: 'Judul Buku Diperbarui'),
                    new OA\Property(property: 'author',      type: 'string',  example: 'Nama Penulis'),
                    new OA\Property(property: 'stock',       type: 'integer', example: 5),
                    new OA\Property(property: 'status',      type: 'string',  enum: ['available', 'borrowed', 'maintenance', 'lost']),
                    new OA\Property(property: 'category_id', type: 'integer', example: 2, nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Buku berhasil diperbarui',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status',  type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Book updated successfully'),
                        new OA\Property(property: 'data',    ref: '#/components/schemas/BookResource'),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Tidak terautentikasi'),
            new OA\Response(response: 404, description: 'Buku tidak ditemukan'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function update(Request $request, Book $book): JsonResponse
    {
        $validatedData = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'isbn'        => 'nullable|string|unique:books,isbn,' . $book->id,
            'publisher'   => 'nullable|string|max:255',
            'year'        => 'nullable|integer|between:1900,2030',
            'pages'       => 'nullable|integer|min:1',
            'language'    => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'location'    => 'nullable|string|max:255',
            'status'      => 'in:available,borrowed,maintenance,lost',
            'category_id' => 'nullable|exists:categories,id',
            'subjects'    => 'nullable|string',
            'stock'       => 'required|integer|min:1'
        ]);

        $book->update($validatedData);
        $book->load('category');

        return response()->json([
            'status'  => 'success',
            'message' => 'Book updated successfully',
            'data'    => $book
        ]);
    }

    /**
     * Remove the specified book
     */
    #[OA\Delete(
        path: '/books/{id}',
        summary: 'Hapus buku',
        description: 'Menghapus buku dari koleksi. Tidak dapat dihapus jika masih ada peminjaman aktif. **Memerlukan autentikasi dan hak akses admin.**',
        tags: ['Books'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', example: 1)),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Buku berhasil dihapus',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status',  type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Book deleted successfully'),
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Buku tidak dapat dihapus karena masih dipinjam',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status',  type: 'string', example: 'error'),
                        new OA\Property(property: 'message', type: 'string', example: 'Cannot delete book with active borrowings'),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Tidak terautentikasi'),
            new OA\Response(response: 404, description: 'Buku tidak ditemukan'),
        ]
    )]
    public function destroy(Book $book): JsonResponse
    {
        if ($book->borrowings()->active()->exists()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Cannot delete book with active borrowings'
            ], 400);
        }

        $book->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Book deleted successfully'
        ]);
    }

    /**
     * Get books statistics
     */
    #[OA\Get(
        path: '/books-statistics',
        summary: 'Statistik koleksi buku',
        description: 'Mengembalikan statistik ringkasan koleksi buku: total buku, buku tersedia, buku dipinjam, distribusi per kategori, dan 5 buku terbaru.',
        tags: ['Books'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Statistik berhasil diambil',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'total_books',     type: 'integer', example: 5524),
                                new OA\Property(property: 'available_books', type: 'integer', example: 4982),
                                new OA\Property(property: 'borrowed_books',  type: 'integer', example: 542),
                                new OA\Property(
                                    property: 'books_by_category',
                                    type: 'array',
                                    items: new OA\Items(
                                        properties: [
                                            new OA\Property(property: 'category_id',   type: 'integer', example: 1),
                                            new OA\Property(property: 'category_name', type: 'string',  example: 'Teknologi & Teknik'),
                                            new OA\Property(property: 'count',         type: 'integer', example: 1200),
                                        ]
                                    )
                                ),
                                new OA\Property(
                                    property: 'recent_additions',
                                    type: 'array',
                                    items: new OA\Items(ref: '#/components/schemas/BookResource')
                                ),
                            ]
                        ),
                    ]
                )
            ),
        ]
    )]
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_books'     => Book::count(),
            'available_books' => Book::where('status', 'available')->count(),
            'borrowed_books'  => Book::where('status', 'borrowed')->count(),
            'books_by_category' => Book::selectRaw('category_id, categories.name as category_name, COUNT(*) as count')
                ->leftJoin('categories', 'books.category_id', '=', 'categories.id')
                ->groupBy('category_id', 'categories.name')
                ->get(),
            'recent_additions' => Book::with('category')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
        ];

        return response()->json([
            'status' => 'success',
            'data'   => $stats
        ]);
    }
}
