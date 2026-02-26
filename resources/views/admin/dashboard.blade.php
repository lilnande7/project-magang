@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <!-- Stats Cards -->
    <div class="col-lg-3 col-md-6">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="bi bi-book-fill display-4 mb-3"></i>
                <h4>{{ $stats['total_books'] }}</h4>
                <p class="mb-0">Total Books</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card stats-card-success">
            <div class="card-body text-center text-white">
                <i class="bi bi-people-fill display-4 mb-3"></i>
                <h4>{{ $stats['total_users'] }}</h4>
                <p class="mb-0">Total Users</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card stats-card-warning">
            <div class="card-body text-center text-white">
                <i class="bi bi-newspaper display-4 mb-3"></i>
                <h4>{{ $stats['total_news'] }}</h4>
                <p class="mb-0">Total News</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card stats-card-info">
            <div class="card-body text-center text-white">
                <i class="bi bi-bookmark-check-fill display-4 mb-3"></i>
                <h4>{{ $stats['active_borrowings'] }}</h4>
                <p class="mb-0">Active Loans</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent News -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-newspaper me-2"></i>
                    Recent News
                </h5>
                <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-primary">
                    View All
                </a>
            </div>
            <div class="card-body">
                @if($recent_news->isEmpty())
                    <p class="text-muted mb-0">No news articles yet.</p>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($recent_news as $news)
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $news->title }}</h6>
                                        <p class="mb-1 text-muted small">{{ Str::limit($news->excerpt ?? $news->content, 100) }}</p>
                                        <small class="text-muted">
                                            <i class="bi bi-person"></i> {{ $news->author->name }} • 
                                            <i class="bi bi-calendar"></i> {{ $news->created_at->format('M d, Y') }}
                                        </small>
                                    </div>
                                    <span class="badge bg-{{ $news->status === 'published' ? 'success' : ($news->status === 'draft' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($news->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Books -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-book me-2"></i>
                    Recent Books
                </h5>
                <a href="{{ route('admin.books.index') }}" class="btn btn-sm btn-primary">
                    View All
                </a>
            </div>
            <div class="card-body">
                @if($recent_books->isEmpty())
                    <p class="text-muted mb-0">No books added yet.</p>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($recent_books as $book)
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex align-items-start">
                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                             alt="Book Cover" 
                                             class="me-3 rounded" 
                                             style="width: 50px; height: 70px; object-fit: cover;">
                                    @else
                                        <div class="me-3 bg-light rounded d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 70px;">
                                            <i class="bi bi-book text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $book->title }}</h6>
                                        <p class="mb-1 text-muted small">{{ $book->author }}</p>
                                        <small class="text-muted">
                                            <i class="bi bi-tag"></i> {{ $book->category->name ?? 'No Category' }} • 
                                            <i class="bi bi-calendar"></i> {{ $book->created_at->format('M d, Y') }}
                                        </small>
                                    </div>
                                    <span class="badge bg-{{ $book->status === 'available' ? 'success' : 'warning' }}">
                                        {{ ucfirst($book->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-4">
    <!-- Popular Categories -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-grid me-2"></i>
                    Popular Categories
                </h5>
            </div>
            <div class="card-body">
                @if($books_by_category->isEmpty())
                    <p class="text-muted mb-0">No categories data available.</p>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($books_by_category as $category)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="mb-0">{{ $category->name }}</h6>
                                    <small class="text-muted">{{ $category->description ?? 'No description' }}</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ $category->books_count }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Featured News -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-star me-2"></i>
                    Featured News
                </h5>
            </div>
            <div class="card-body">
                @if($featured_news->isEmpty())
                    <div class="text-center py-4">
                        <i class="bi bi-newspaper display-1 text-muted"></i>
                        <p class="text-muted mt-3">No featured news articles.</p>
                        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-2"></i>
                            Create First News
                        </a>
                    </div>
                @else
                    <div class="row g-3">
                        @foreach($featured_news as $news)
                            <div class="col-md-6">
                                <div class="card border">
                                    @if($news->featured_image)
                                        <img src="{{ asset('storage/' . $news->featured_image) }}" 
                                             class="card-img-top" 
                                             alt="News Image"
                                             style="height: 120px; object-fit: cover;">
                                    @endif
                                    <div class="card-body p-3">
                                        <h6 class="card-title">{{ Str::limit($news->title, 50) }}</h6>
                                        <p class="card-text small text-muted">
                                            {{ Str::limit($news->excerpt ?? $news->content, 80) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                {{ $news->published_at ? $news->published_at->format('M d') : $news->created_at->format('M d') }}
                                            </small>
                                            <a href="{{ route('admin.news.show', $news) }}" class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4 mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-lightning me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('admin.books.create') }}" class="btn btn-outline-primary w-100 p-3">
                            <i class="bi bi-book-fill display-6 d-block"></i>
                            <span class="mt-2">Add New Book</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('admin.news.create') }}" class="btn btn-outline-success w-100 p-3">
                            <i class="bi bi-newspaper display-6 d-block"></i>
                            <span class="mt-2">Create News</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-info w-100 p-3">
                            <i class="bi bi-list-ul display-6 d-block"></i>
                            <span class="mt-2">Manage Books</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-warning w-100 p-3">
                            <i class="bi bi-eye display-6 d-block"></i>
                            <span class="mt-2">Preview Site</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto refresh dashboard every 5 minutes
    setTimeout(function() {
        location.reload();
    }, 300000); // 5 minutes
</script>
@endpush