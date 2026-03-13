@extends('admin.layout')

@section('title', 'Books Management')
@section('page-title', 'Books Management')

@push('styles')
<style>
    .book-cover {
        width: 48px;
        height: 64px;
        object-fit: cover;
        border-radius: 0.35rem;
        border: 1px solid #f0f0f0;
    }
    .status-pill {
        text-transform: capitalize;
    }
    .empty-state-icon {
        font-size: 4rem;
        color: #ced4da;
    }
</style>
@endpush

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
    <div>
        <h4 class="mb-1">Library Collection</h4>
        <p class="text-muted mb-0">Monitor, filter, and curate every book recorded in the system.</p>
    </div>
    <div class="text-md-end">
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>
            Add New Book
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="search" class="form-label">Search</label>
                <input type="text"
                       class="form-control"
                       id="search"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search by title, author, or ISBN">
            </div>
            <div class="col-md-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category">
                    <option value="">All categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (string) request('category') === (string) $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All status</option>
                    <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="borrowed" {{ request('status') === 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                    <option value="maintenance" {{ request('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="lost" {{ request('status') === 'lost' ? 'selected' : '' }}>Lost</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary flex-grow-1">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary" title="Clear filters">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </form>
    </div>
</div>

@if($books->count())
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th width="70">Cover</th>
                            <th>Title & Author</th>
                            <th width="180">Category</th>
                            <th width="120">Stock</th>
                            <th width="130">Status</th>
                            <th width="160">Last Updated</th>
                            <th width="150" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $book)
                            <tr>
                                <td>
                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                             alt="{{ $book->title }} cover" 
                                             class="book-cover">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center bg-light rounded" style="width: 48px; height: 64px;">
                                            <i class="bi bi-book text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ Str::limit($book->title, 60) }}</div>
                                    <small class="text-muted">{{ $book->author }}</small>
                                </td>
                                <td>
                                    {{ optional($book->category)->name ?? 'Uncategorized' }}
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ $book->stock }}</span>
                                    <small class="text-muted d-block">copies</small>
                                </td>
                                <td>
                                    @php
                                        $statusColor = [
                                            'available' => 'success',
                                            'borrowed' => 'warning',
                                            'maintenance' => 'info',
                                            'lost' => 'secondary',
                                        ][$book->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }} status-pill">{{ $book->status }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $book->updated_at ? $book->updated_at->format('M d, Y H:i') : '—' }}</small>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.books.show', $book) }}" class="btn btn-outline-secondary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.books.destroy', $book) }}" method="POST" onsubmit="return confirm('Delete this book?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-3">
                <small class="text-muted">
                    Showing {{ $books->firstItem() }}–{{ $books->lastItem() }} of {{ $books->total() }} books
                </small>
                {{ $books->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body text-center py-5">
            <div class="empty-state-icon mb-3">
                <i class="bi bi-collection"></i>
            </div>
            <h5 class="mb-2">No books found</h5>
            <p class="text-muted mb-4">Try adjusting the filters or create a new record.</p>
            <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i>
                Add first book
            </a>
        </div>
    </div>
@endif
@endsection
