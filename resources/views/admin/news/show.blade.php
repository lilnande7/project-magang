@extends('admin.layout')

@section('title', 'View News')
@section('page-title', 'View News')

@section('content')
<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-newspaper me-2"></i>
                    {{ $news->title }}
                </h5>
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil me-1"></i>
                        Edit
                    </a>
                    @if($news->status !== 'published')
                        <form action="{{ route('admin.news.publish', $news) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" 
                                    class="btn btn-outline-success"
                                    onclick="return confirm('Are you sure you want to publish this news?')">
                                <i class="bi bi-upload me-1"></i>
                                Publish
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('admin.news.destroy', $news) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-outline-danger"
                                onclick="return confirm('Are you sure you want to delete this news?')">
                            <i class="bi bi-trash me-1"></i>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="card-body">
                <!-- Featured Image -->
                @if($news->featured_image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $news->featured_image) }}" 
                             alt="Featured Image" 
                             class="img-fluid rounded w-100" 
                             style="max-height: 400px; object-fit: cover;">
                    </div>
                @endif
                
                <!-- Meta Information -->
                <div class="row g-3 mb-4 text-muted">
                    <div class="col-auto">
                        <i class="bi bi-person me-1"></i>
                        <strong>{{ $news->author->name }}</strong>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar me-1"></i>
                        Created: {{ $news->created_at->format('F d, Y \a\t H:i') }}
                    </div>
                    @if($news->published_at)
                    <div class="col-auto">
                        <i class="bi bi-clock me-1"></i>
                        Published: {{ $news->published_at->format('F d, Y \a\t H:i') }}
                    </div>
                    @endif
                    @if($news->updated_at != $news->created_at)
                    <div class="col-auto">
                        <i class="bi bi-pencil me-1"></i>
                        Updated: {{ $news->updated_at->format('F d, Y \a\t H:i') }}
                    </div>
                    @endif
                </div>
                
                <!-- Excerpt -->
                @if($news->excerpt)
                    <div class="alert alert-light border-start border-4 border-primary mb-4">
                        <h6 class="mb-1">Excerpt</h6>
                        <p class="mb-0">{{ $news->excerpt }}</p>
                    </div>
                @endif
                
                <!-- Content -->
                <div class="news-content">
                    {!! nl2br(e($news->content)) !!}
                </div>
                
                <!-- Tags -->
                @if($news->tags && count($news->tags) > 0)
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="mb-2">Tags</h6>
                        @foreach($news->tags as $tag)
                            <span class="badge bg-primary me-2 mb-2">{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Status Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    Article Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-4">
                        <small class="text-muted">Status:</small>
                    </div>
                    <div class="col-8">
                        @if($news->status === 'published')
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>
                                Published
                            </span>
                        @elseif($news->status === 'draft')
                            <span class="badge bg-warning">
                                <i class="bi bi-pencil me-1"></i>
                                Draft
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                <i class="bi bi-archive me-1"></i>
                                Archived
                            </span>
                        @endif
                    </div>
                    
                    <div class="col-4">
                        <small class="text-muted">Featured:</small>
                    </div>
                    <div class="col-8">
                        @if($news->is_featured)
                            <span class="badge bg-warning">
                                <i class="bi bi-star-fill me-1"></i>
                                Yes
                            </span>
                        @else
                            <span class="text-muted">No</span>
                        @endif
                    </div>
                    
                    <div class="col-4">
                        <small class="text-muted">Views:</small>
                    </div>
                    <div class="col-8">
                        <span class="fw-bold">{{ $news->views_count ?? 0 }}</span>
                    </div>
                    
                    <div class="col-4">
                        <small class="text-muted">Word Count:</small>
                    </div>
                    <div class="col-8">
                        <span>{{ str_word_count(strip_tags($news->content)) }} words</span>
                    </div>
                    
                    <div class="col-4">
                        <small class="text-muted">Reading Time:</small>
                    </div>
                    <div class="col-8">
                        <span>{{ ceil(str_word_count(strip_tags($news->content)) / 200) }} min</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-lightning me-2"></i>
                    Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-pencil me-2"></i>
                        Edit Article
                    </a>
                    
                    @if($news->status === 'draft')
                        <form action="{{ route('admin.news.publish', $news) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-success btn-sm w-100"
                                    onclick="return confirm('Publish this news article?')">
                                <i class="bi bi-upload me-2"></i>
                                Publish Now
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('admin.news.create') }}" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-plus-lg me-2"></i>
                        Create New Article
                    </a>
                    
                    <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-list me-2"></i>
                        All Articles
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Preview -->
        @if($news->status === 'published')
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-eye me-2"></i>
                        Public View
                    </h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">
                        This article is live and visible to the public. 
                        You can preview how it appears on your website.
                    </p>
                    <a href="{{ route('home') }}#news-{{ $news->id }}" 
                       target="_blank" 
                       class="btn btn-outline-primary btn-sm w-100">
                        <i class="bi bi-box-arrow-up-right me-2"></i>
                        View on Website
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.news-content {
    font-size: 1.1rem;
    line-height: 1.7;
    color: #333;
}

.news-content p {
    margin-bottom: 1.2rem;
}

.news-content h1, 
.news-content h2, 
.news-content h3, 
.news-content h4, 
.news-content h5, 
.news-content h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.news-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #6c757d;
}

.news-content ul, 
.news-content ol {
    margin-bottom: 1.2rem;
    padding-left: 2rem;
}

.news-content li {
    margin-bottom: 0.5rem;
}
</style>
@endpush