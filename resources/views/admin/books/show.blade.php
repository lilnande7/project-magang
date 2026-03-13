@extends('admin.layout')

@section('title', 'Book Detail')
@section('page-title', 'Book Detail')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h4 class="mb-1">{{ $book->title }}</h4>
        <p class="text-muted mb-0">{{ $book->author }}</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <form action="{{ route('admin.books.destroy', $book) }}" method="POST" onsubmit="return confirm('Delete this book?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i> Delete
            </button>
        </form>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-body text-center">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" 
                         alt="{{ $book->title }} cover"
                         class="img-fluid rounded mb-3"
                         style="max-height: 320px; object-fit: cover;">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" style="height: 320px;">
                        <i class="bi bi-book display-3 text-muted"></i>
                    </div>
                @endif
                @php
                    $statusColor = [
                        'available' => 'success',
                        'borrowed' => 'warning',
                        'maintenance' => 'info',
                        'lost' => 'secondary',
                    ][$book->status] ?? 'secondary';
                @endphp
                <span class="badge bg-{{ $statusColor }} text-capitalize px-3 py-2">{{ $book->status }}</span>
                <div class="mt-3">
                    <p class="mb-1"><strong>Stock:</strong> {{ $book->stock }} copies</p>
                    <p class="mb-1"><strong>Category:</strong> {{ optional($book->category)->name ?? 'Uncategorized' }}</p>
                    <p class="mb-0"><strong>Location:</strong> {{ $book->location ?? 'Not set' }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Book Information</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">ISBN</p>
                        <p class="fw-semibold">{{ $book->isbn ?? '—' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Publisher</p>
                        <p class="fw-semibold">{{ $book->publisher ?? '—' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-1">Year</p>
                        <p class="fw-semibold">{{ $book->year ?? '—' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-1">Pages</p>
                        <p class="fw-semibold">{{ $book->pages ?? '—' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-1">Language</p>
                        <p class="fw-semibold">{{ $book->language ?? '—' }}</p>
                    </div>
                    <div class="col-12">
                        <p class="text-muted mb-1">Subjects / Tags</p>
                        @if($book->subjects)
                            @foreach(explode(',', $book->subjects) as $subject)
                                <span class="badge bg-light text-dark me-1 mb-1">{{ trim($subject) }}</span>
                            @endforeach
                        @else
                            <p class="fw-semibold">—</p>
                        @endif
                    </div>
                    <div class="col-12">
                        <p class="text-muted mb-1">Description</p>
                        <p class="fw-semibold">{{ $book->description ?? 'No description provided.' }}</p>
                    </div>
                    <div class="col-12">
                        <p class="text-muted mb-1">Last updated</p>
                        <p class="fw-semibold">{{ $book->updated_at ? $book->updated_at->format('M d, Y H:i') : '—' }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Recent Borrowings</h6>
                <small class="text-muted">Last 5 records</small>
            </div>
            <div class="card-body">
                @php
                    $recentBorrowings = $book->borrowings->sortByDesc('borrowed_at')->take(5);
                @endphp
                @if($recentBorrowings->isEmpty())
                    <p class="text-muted mb-0">No borrowing history for this book yet.</p>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($recentBorrowings as $borrowing)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong>{{ optional($borrowing->user)->name ?? 'Unknown user' }}</strong>
                                        <div class="small text-muted">
                                            Borrowed: {{ optional($borrowing->borrowed_at)->format('M d, Y') ?? '—' }}
                                            @if($borrowing->due_date)
                                                &middot; Due: {{ $borrowing->due_date->format('M d, Y') }}
                                            @endif
                                        </div>
                                    </div>
                                    <span class="badge bg-{{ $borrowing->status === 'returned' ? 'success' : ($borrowing->status === 'active' ? 'warning' : 'secondary') }} text-capitalize">
                                        {{ $borrowing->status }}
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
@endsection
