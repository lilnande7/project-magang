<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    /**
     * Display a listing of books with search and filtering
     */
    public function index(Request $request): JsonResponse
    {
        $query = Book::with('category');
        
        // Search functionality
        if ($request->filled('q')) {
            $query->search($request->q);
        }
        
        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Sort functionality
        $sortField = $request->get('sort', 'title');
        $sortDirection = $request->get('direction', 'asc');
        
        if (in_array($sortField, ['title', 'author', 'year', 'created_at'])) {
            $query->orderBy($sortField, $sortDirection);
        }
        
        // Pagination
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
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|unique:books,isbn',
            'publisher' => 'nullable|string|max:255',
            'year' => 'nullable|integer|between:1900,2030',
            'pages' => 'nullable|integer|min:1',
            'language' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'status' => 'in:available,borrowed,maintenance,lost',
            'category_id' => 'nullable|exists:categories,id',
            'subjects' => 'nullable|string',
            'stock' => 'required|integer|min:1'
        ]);

        $book = Book::create($validatedData);
        $book->load('category');

        return response()->json([
            'status' => 'success',
            'message' => 'Book created successfully',
            'data' => $book
        ], 201);
    }

    /**
     * Display the specified book
     */
    public function show(Book $book): JsonResponse
    {
        $book->load(['category', 'borrowings.user']);
        
        return response()->json([
            'status' => 'success',
            'data' => $book
        ]);
    }

    /**
     * Update the specified book
     */
    public function update(Request $request, Book $book): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|unique:books,isbn,' . $book->id,
            'publisher' => 'nullable|string|max:255',
            'year' => 'nullable|integer|between:1900,2030',
            'pages' => 'nullable|integer|min:1',
            'language' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'status' => 'in:available,borrowed,maintenance,lost',
            'category_id' => 'nullable|exists:categories,id',
            'subjects' => 'nullable|string',
            'stock' => 'required|integer|min:1'
        ]);

        $book->update($validatedData);
        $book->load('category');

        return response()->json([
            'status' => 'success',
            'message' => 'Book updated successfully',
            'data' => $book
        ]);
    }

    /**
     * Remove the specified book
     */
    public function destroy(Book $book): JsonResponse
    {
        // Check if book has active borrowings
        if ($book->borrowings()->active()->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete book with active borrowings'
            ], 400);
        }

        $book->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Book deleted successfully'
        ]);
    }
    
    /**
     * Get books statistics
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_books' => Book::count(),
            'available_books' => Book::where('status', 'available')->count(),
            'borrowed_books' => Book::where('status', 'borrowed')->count(),
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
            'data' => $stats
        ]);
    }
}
