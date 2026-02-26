<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class NewsController extends Controller
{
    /**
     * Display a listing of news
     */
    public function index(Request $request)
    {
        $query = News::with('author');
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $news = $query->latest()->paginate(15);
        
        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating new news
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store newly created news
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'tags' => 'nullable|string',
            'published_at' => 'nullable|date'
        ]);
        
        // Handle tags
        if ($request->filled('tags')) {
            $validatedData['tags'] = array_map('trim', explode(',', $request->tags));
        }
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('news', $imageName, 'public');
            $validatedData['featured_image'] = $imagePath;
        }
        
        // Set author
        $validatedData['author_id'] = auth()->id();
        
        // Handle published_at
        if ($validatedData['status'] === 'published' && !$validatedData['published_at']) {
            $validatedData['published_at'] = now();
        } elseif ($validatedData['status'] !== 'published') {
            $validatedData['published_at'] = null;
        } elseif ($validatedData['published_at']) {
            $validatedData['published_at'] = Carbon::parse($validatedData['published_at']);
        }

        News::create($validatedData);

        return redirect()->route('admin.news.index')
                        ->with('success', 'News created successfully.');
    }

    /**
     * Display the specified news
     */
    public function show(News $news)
    {
        $news->load('author');
        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing news
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified news
     */
    public function update(Request $request, News $news)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'tags' => 'nullable|string',
            'published_at' => 'nullable|date'
        ]);
        
        // Handle tags
        if ($request->filled('tags')) {
            $validatedData['tags'] = array_map('trim', explode(',', $request->tags));
        } else {
            $validatedData['tags'] = null;
        }
        
        // Handle remove current image
        if ($request->has('remove_current_image') && $request->remove_current_image == '1') {
            // Delete current image
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $validatedData['featured_image'] = null;
        }
        // Handle new featured image upload
        elseif ($request->hasFile('featured_image')) {
            // Delete old image
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            
            $image = $request->file('featured_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('news', $imageName, 'public');
            $validatedData['featured_image'] = $imagePath;
        }
        // If no new image and no remove request, keep the existing image
        // Don't set featured_image in validatedData to preserve existing value
        
        // Handle published_at
        if ($validatedData['status'] === 'published' && !$validatedData['published_at']) {
            $validatedData['published_at'] = now();
        } elseif ($validatedData['status'] !== 'published') {
            $validatedData['published_at'] = null;
        } elseif ($validatedData['published_at']) {
            $validatedData['published_at'] = Carbon::parse($validatedData['published_at']);
        }

        $news->update($validatedData);

        return redirect()->route('admin.news.index')
                        ->with('success', 'News updated successfully.');
    }

    /**
     * Remove the specified news
     */
    public function destroy(News $news)
    {
        // Delete featured image
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
                        ->with('success', 'News deleted successfully.');
    }
    
    /**
     * Publish news
     */
    public function publish(News $news)
    {
        $news->publishNow();
        
        return back()->with('success', 'News published successfully.');
    }
}
