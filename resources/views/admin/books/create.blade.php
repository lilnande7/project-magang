@extends('admin.layout')

@section('title', 'Add New Book')
@section('page-title', 'Add New Book')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Create Book Record</h5>
            <small class="text-muted">Fill the form below to add a new book into the library catalog.</small>
        </div>
        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to list
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.books.partials.form')
            
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.books.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>
                    Save Book
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
