@extends('admin.layout')

@section('title', 'Edit Book')
@section('page-title', 'Edit Book')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Update Book Information</h5>
            <small class="text-muted">Editing: {{ $book->title }}</small>
        </div>
        <a href="{{ route('admin.books.show', $book) }}" class="btn btn-outline-secondary">
            <i class="bi bi-eye"></i> View detail
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.books.partials.form')
            
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.books.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>
                    Update Book
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
