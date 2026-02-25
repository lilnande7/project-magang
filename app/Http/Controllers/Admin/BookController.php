<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of books
     */
    public function index(Request $request)
    {
        $query = Book::with('category');
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $books = $query->orderBy('title')->paginate(15);
        $categories = Category::active()->orderBy('name')->get();
        
        return view('admin.books.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new book
     */
    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a newly created book
     */
    public function store(Request $request)
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
            'status' => 'required|in:available,borrowed,maintenance,lost',
            'category_id' => 'nullable|exists:categories,id',
            'subjects' => 'nullable|string',
            'stock' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        // Handle image upload
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('books', $imageName, 'public');
            $validatedData['cover_image'] = $imagePath;
        }

        Book::create($validatedData);

        return redirect()->route('admin.books.index')
                        ->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified book
     */
    public function show(Book $book)
    {
        $book->load(['category', 'borrowings.user']);
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified book
     */
    public function edit(Book $book)
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified book
     */
    public function update(Request $request, Book $book)
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
            'status' => 'required|in:available,borrowed,maintenance,lost',
            'category_id' => 'nullable|exists:categories,id',
            'subjects' => 'nullable|string',
            'stock' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        // Handle image upload
        if ($request->hasFile('cover_image')) {
            // Delete old image
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            
            $image = $request->file('cover_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('books', $imageName, 'public');
            $validatedData['cover_image'] = $imagePath;
        }

        $book->update($validatedData);

        return redirect()->route('admin.books.index')
                        ->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified book
     */
    public function destroy(Book $book)
    {
        // Check if book has active borrowings
        if ($book->borrowings()->active()->exists()) {
            return redirect()->route('admin.books.index')
                            ->with('error', 'Cannot delete book with active borrowings.');
        }

        // Delete cover image
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('admin.books.index')
                        ->with('success', 'Book deleted successfully.');
    }
}
