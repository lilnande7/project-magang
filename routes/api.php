<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API Routes (no authentication required)
Route::prefix('v1')->group(function () {
    
    // Books API
    Route::apiResource('books', BookController::class);
    Route::get('books-statistics', [BookController::class, 'statistics'])
        ->name('books.statistics');
    
    // Categories API
    Route::apiResource('categories', CategoryController::class);
    
    // Search endpoint
    Route::get('search', [BookController::class, 'index'])
        ->name('api.search');
        
    // OPAC API - Public book search
    Route::prefix('opac')->group(function () {
        Route::get('/', [BookController::class, 'index'])
            ->name('api.opac.index');
        Route::get('{book}', [BookController::class, 'show'])
            ->name('api.opac.show');
    });
});

// Protected API Routes (requires authentication)
Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    
    // Admin only routes
    Route::middleware(['can:admin'])->group(function () {
        // Book management (create, update, delete)
        Route::post('books', [BookController::class, 'store']);
        Route::put('books/{book}', [BookController::class, 'update']);
        Route::delete('books/{book}', [BookController::class, 'destroy']);
        
        // Category management 
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
    });
    
    // User routes (borrowing, etc)
    // TODO: Add borrowing endpoints
});