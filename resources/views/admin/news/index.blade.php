@extends('admin.layout')

@section('title', 'News Management')
@section('page-title', 'News Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-newspaper me-2"></i>
            All News Articles
        </h5>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>
            Create News
        </a>
    </div>
    
    <div class="card-body">
        <!-- Filter and Search -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="search" class="form-label">Search</label>
                <input type="text" 
                       class="form-control" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search by title or content...">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Status</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary me-2">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg"></i> Reset
                </a>
            </div>
        </form>
        
        @if($news->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-newspaper display-1 text-muted"></i>
                <h4 class="text-muted my-3">No News Articles Found</h4>
                <p class="text-muted">Start by creating your first news article.</p>
                <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i>
                    Create First News
                </a>
            </div>
        @else
            <!-- News Table -->
            <div class="table-responsive">
                <table class="table table-hover" id="newsTable">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th width="60">Image</th>
                            <th>Title</th>
                            <th width="120">Author</th>
                            <th width="100">Status</th>
                            <th width="120">Published</th>
                            <th width="80">Featured</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $index => $item)
                            <tr>
                                <td>{{ $news->firstItem() + $index }}</td>
                                <td>
                                    @if($item->featured_image)
                                        <img src="{{ asset('storage/' . $item->featured_image) }}" 
                                             alt="News Image" 
                                             class="rounded" 
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-1">{{ Str::limit($item->title, 50) }}</h6>
                                        @if($item->excerpt)
                                            <small class="text-muted">{{ Str::limit($item->excerpt, 80) }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $item->author->name }}</td>
                                <td>
                                    @if($item->status === 'published')
                                        <span class="badge bg-success">Published</span>
                                    @elseif($item->status === 'draft')
                                        <span class="badge bg-warning">Draft</span>
                                    @else
                                        <span class="badge bg-secondary">Archived</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->published_at)
                                        {{ $item->published_at->format('M d, Y') }}
                                    @else
                                        <span class="text-muted">Not published</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->is_featured)
                                        <i class="bi bi-star-fill text-warning" title="Featured"></i>
                                    @else
                                        <i class="bi bi-star text-muted" title="Not Featured"></i>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.news.show', $item) }}" 
                                           class="btn btn-outline-info" 
                                           title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.news.edit', $item) }}" 
                                           class="btn btn-outline-primary" 
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($item->status !== 'published')
                                            <form action="{{ route('admin.news.publish', $item) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-outline-success" 
                                                        title="Publish"
                                                        onclick="return confirm('Are you sure you want to publish this news?')">
                                                    <i class="bi bi-upload"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.news.destroy', $item) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger" 
                                                    title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this news?')">
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
            
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    Showing {{ $news->firstItem() }} to {{ $news->lastItem() }} of {{ $news->total() }} results
                </div>
                {{ $news->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable for better UX (optional)
    $('#newsTable').DataTable({
        "paging": false,
        "searching": false,
        "info": false,
        "ordering": true,
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            { "orderable": false, "targets": [1, 7] }
        ]
    });
});
</script>
@endpush