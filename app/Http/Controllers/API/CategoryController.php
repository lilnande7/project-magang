<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    #[OA\Get(
        path: '/categories',
        summary: 'Daftar semua kategori',
        description: 'Mengembalikan seluruh kategori buku yang tersedia, disertai jumlah buku di setiap kategori.',
        tags: ['Categories'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Daftar kategori berhasil diambil',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/CategoryResource')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $categories = Category::withCount('books')
            ->orderBy('name')
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $categories
        ]);
    }

    /**
     * Store a newly created category
     */
    #[OA\Post(
        path: '/categories',
        summary: 'Tambah kategori baru',
        description: 'Membuat kategori buku baru. **Memerlukan autentikasi dan hak akses admin.**',
        tags: ['Categories'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'code'],
                properties: [
                    new OA\Property(property: 'name',        type: 'string',  maxLength: 255, example: 'Ilmu Sosial'),
                    new OA\Property(property: 'code',        type: 'string',  maxLength: 20,  example: 'ILMU-SOSIAL'),
                    new OA\Property(property: 'description', type: 'string',  example: 'Buku-buku ilmu sosial dan kemasyarakatan', nullable: true),
                    new OA\Property(property: 'is_active',   type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Kategori berhasil dibuat',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status',  type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Category created successfully'),
                        new OA\Property(property: 'data',    ref: '#/components/schemas/CategoryResource'),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Tidak terautentikasi'),
            new OA\Response(response: 422, description: 'Validasi gagal (misal: kode sudah dipakai)'),
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:20|unique:categories,code',
            'description' => 'nullable|string',
            'is_active'   => 'boolean'
        ]);

        $category = Category::create($validatedData);

        return response()->json([
            'status'  => 'success',
            'message' => 'Category created successfully',
            'data'    => $category
        ], 201);
    }

    /**
     * Display the specified category
     */
    #[OA\Get(
        path: '/categories/{id}',
        summary: 'Detail kategori',
        description: 'Mengembalikan detail kategori beserta 10 buku tersedia terbaru dalam kategori tersebut.',
        tags: ['Categories'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'ID kategori',
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Detail kategori berhasil diambil',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(
                            property: 'data',
                            allOf: [
                                new OA\Schema(ref: '#/components/schemas/CategoryResource'),
                                new OA\Schema(
                                    properties: [
                                        new OA\Property(
                                            property: 'books',
                                            type: 'array',
                                            items: new OA\Items(ref: '#/components/schemas/BookResource'),
                                            description: 'Hingga 10 buku tersedia di kategori ini'
                                        ),
                                    ]
                                ),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Kategori tidak ditemukan'),
        ]
    )]
    public function show(Category $category): JsonResponse
    {
        $category->load(['books' => function ($query) {
            $query->available()->limit(10);
        }]);
        $category->loadCount('books');

        return response()->json([
            'status' => 'success',
            'data'   => $category
        ]);
    }

    /**
     * Update the specified category
     */
    #[OA\Put(
        path: '/categories/{id}',
        summary: 'Update kategori',
        description: 'Memperbarui data kategori. **Memerlukan autentikasi dan hak akses admin.**',
        tags: ['Categories'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', example: 1)),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'code'],
                properties: [
                    new OA\Property(property: 'name',        type: 'string', example: 'Nama Kategori Baru'),
                    new OA\Property(property: 'code',        type: 'string', example: 'KODE-BARU'),
                    new OA\Property(property: 'description', type: 'string', nullable: true),
                    new OA\Property(property: 'is_active',   type: 'boolean'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Kategori berhasil diperbarui'),
            new OA\Response(response: 401, description: 'Tidak terautentikasi'),
            new OA\Response(response: 404, description: 'Kategori tidak ditemukan'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function update(Request $request, Category $category): JsonResponse
    {
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:20|unique:categories,code,' . $category->id,
            'description' => 'nullable|string',
            'is_active'   => 'boolean'
        ]);

        $category->update($validatedData);

        return response()->json([
            'status'  => 'success',
            'message' => 'Category updated successfully',
            'data'    => $category
        ]);
    }

    /**
     * Remove the specified category
     */
    #[OA\Delete(
        path: '/categories/{id}',
        summary: 'Hapus kategori',
        description: 'Menghapus kategori. Tidak dapat dihapus jika masih memiliki buku. **Memerlukan autentikasi dan hak akses admin.**',
        tags: ['Categories'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', example: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Kategori berhasil dihapus'),
            new OA\Response(
                response: 400,
                description: 'Kategori memiliki buku — tidak bisa dihapus',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status',  type: 'string', example: 'error'),
                        new OA\Property(property: 'message', type: 'string', example: 'Cannot delete category that has books assigned'),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Tidak terautentikasi'),
            new OA\Response(response: 404, description: 'Kategori tidak ditemukan'),
        ]
    )]
    public function destroy(Category $category): JsonResponse
    {
        if ($category->books()->exists()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Cannot delete category that has books assigned'
            ], 400);
        }

        $category->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Category deleted successfully'
        ]);
    }
}
