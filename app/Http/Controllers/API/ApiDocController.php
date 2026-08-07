<?php

namespace App\Http\Controllers\API;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Perpustakaan PPIC API',
    description: 'REST API untuk Sistem Informasi Perpustakaan Politeknik Penerbangan Indonesia Curug. API ini menyediakan akses ke katalog buku, kategori, dan layanan chatbot AI referensi perpustakaan.',
    contact: new OA\Contact(
        name: 'Perpustakaan PPIC',
        email: 'ppicurug.library@gmail.com'
    ),
    license: new OA\License(
        name: 'MIT',
        url: 'https://opensource.org/licenses/MIT'
    )
)]
#[OA\Server(url: '/api/v1', description: 'API Server v1')]
#[OA\Server(url: '/api',    description: 'API Server (base)')]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT',
    description: 'Masukkan token Bearer untuk akses endpoint yang memerlukan autentikasi'
)]
#[OA\Tag(name: 'Books',      description: 'Operasi terkait koleksi buku perpustakaan')]
#[OA\Tag(name: 'Categories', description: 'Operasi terkait kategori / klasifikasi buku')]
#[OA\Tag(name: 'Chatbot',    description: 'Layanan chatbot AI berbasis Google Gemini untuk referensi buku')]
#[OA\Schema(
    schema: 'BookResource',
    type: 'object',
    properties: [
        new OA\Property(property: 'id',          type: 'integer', example: 1),
        new OA\Property(property: 'title',       type: 'string',  example: 'Pengantar Teknik Penerbangan'),
        new OA\Property(property: 'author',      type: 'string',  example: 'Budi Santoso'),
        new OA\Property(property: 'isbn',        type: 'string',  example: '978-602-123-456-7', nullable: true),
        new OA\Property(property: 'publisher',   type: 'string',  example: 'Gramedia',           nullable: true),
        new OA\Property(property: 'year',        type: 'integer', example: 2020,                 nullable: true),
        new OA\Property(property: 'pages',       type: 'integer', example: 350,                  nullable: true),
        new OA\Property(property: 'language',    type: 'string',  example: 'Indonesia',           nullable: true),
        new OA\Property(property: 'description', type: 'string',  example: 'Buku pengantar ilmu teknik penerbangan...', nullable: true),
        new OA\Property(property: 'location',    type: 'string',  example: 'Rak A-12',            nullable: true),
        new OA\Property(property: 'stock',       type: 'integer', example: 3),
        new OA\Property(property: 'status',      type: 'string',  enum: ['available', 'borrowed', 'maintenance', 'lost'], example: 'available'),
        new OA\Property(property: 'category_id', type: 'integer', example: 2,  nullable: true),
        new OA\Property(property: 'subjects',    type: 'string',  example: 'Penerbangan, Avionik', nullable: true),
        new OA\Property(property: 'call_number', type: 'string',  example: '629.13 BUD p',         nullable: true),
        new OA\Property(property: 'gmd_name',    type: 'string',  example: 'Text',                nullable: true),
        new OA\Property(property: 'cover_image', type: 'string',  example: 'covers/book1.jpg',     nullable: true),
        new OA\Property(property: 'created_at',  type: 'string',  format: 'date-time'),
        new OA\Property(property: 'updated_at',  type: 'string',  format: 'date-time'),
    ]
)]
#[OA\Schema(
    schema: 'CategoryResource',
    type: 'object',
    properties: [
        new OA\Property(property: 'id',          type: 'integer', example: 1),
        new OA\Property(property: 'name',        type: 'string',  example: 'Teknologi & Teknik'),
        new OA\Property(property: 'code',        type: 'string',  example: 'TEKNOLOGI-TEKNIK'),
        new OA\Property(property: 'description', type: 'string',  example: 'Buku-buku teknik dan teknologi terapan', nullable: true),
        new OA\Property(property: 'is_active',   type: 'boolean', example: true),
        new OA\Property(property: 'books_count', type: 'integer', example: 142),
    ]
)]
#[OA\Schema(
    schema: 'ErrorResponse',
    type: 'object',
    properties: [
        new OA\Property(property: 'status',  type: 'string', example: 'error'),
        new OA\Property(property: 'message', type: 'string', example: 'Pesan error di sini'),
    ]
)]
class ApiDocController extends \App\Http\Controllers\Controller
{
    // Controller ini kosong — hanya menampung anotasi OpenAPI global
}
