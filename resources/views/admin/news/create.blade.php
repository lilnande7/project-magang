@extends('admin.layout')

@section('title', 'Create News')
@section('page-title', 'Create News')

@section('content')
<form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-file-text me-2"></i>
                        News Content
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title *</label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}" 
                               placeholder="Enter news title..." 
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Excerpt -->
                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Excerpt</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                  id="excerpt" 
                                  name="excerpt" 
                                  rows="3" 
                                  placeholder="Brief description of the news (optional)...">{{ old('excerpt') }}</textarea>
                        <small class="form-text text-muted">Short summary that appears in news listings (max 500 characters)</small>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Content -->
                    <div class="mb-3">
                        <label for="content" class="form-label">Content *</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" 
                                  name="content" 
                                  rows="12" 
                                  placeholder="Write your news content here..." 
                                  required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Tags -->
                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags</label>
                        <input type="text" 
                               class="form-control @error('tags') is-invalid @enderror" 
                               id="tags" 
                               name="tags" 
                               value="{{ old('tags') }}" 
                               placeholder="Enter tags separated by commas (e.g., library, books, announcement)">
                        <small class="form-text text-muted">Separate multiple tags with commas</small>
                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Publish Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-gear me-2"></i>
                        Publish Settings
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Published At -->
                    <div class="mb-3">
                        <label for="published_at" class="form-label">Publish Date</label>
                        <input type="datetime-local" 
                               class="form-control @error('published_at') is-invalid @enderror" 
                               id="published_at" 
                               name="published_at" 
                               value="{{ old('published_at') }}">
                        <small class="form-text text-muted">Leave empty to publish immediately when status is set to Published</small>
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Featured -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input @error('is_featured') is-invalid @enderror" 
                                   type="checkbox" 
                                   id="is_featured" 
                                   name="is_featured" 
                                   value="1" 
                                   {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <i class="bi bi-star me-1"></i>
                                Featured News
                            </label>
                            <small class="form-text text-muted d-block">Featured news appears prominently on the homepage</small>
                        </div>
                        @error('is_featured')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Featured Image -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-image me-2"></i>
                        Featured Image
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <input type="file" 
                               class="form-control @error('featured_image') is-invalid @enderror" 
                               id="featured_image" 
                               name="featured_image" 
                               accept="image/jpeg,image/png,image/jpg">
                        <small class="form-text text-muted">Upload JPG, PNG images. Max size: 2MB</small>
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Image Preview -->
                    <div id="imagePreview" class="d-none">
                        <img id="previewImg" src="#" alt="Image Preview" class="img-fluid rounded">
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="removeImage">
                            <i class="bi bi-trash"></i> Remove Image
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>
                            Create News
                        </button>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Back to News List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Image preview functionality
    $('#featured_image').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImg').attr('src', e.target.result);
                $('#imagePreview').removeClass('d-none');
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Remove image preview
    $('#removeImage').click(function() {
        $('#featured_image').val('');
        $('#imagePreview').addClass('d-none');
        $('#previewImg').attr('src', '#');
    });
    
    // Auto-resize content textarea
    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }
    
    $('#content').on('input', function() {
        autoResize(this);
    });
    
    // Character counter for excerpt
    $('#excerpt').on('input', function() {
        const maxLength = 500;
        const currentLength = $(this).val().length;
        const remaining = maxLength - currentLength;
        
        if (!$('#excerpt-counter').length) {
            $(this).after('<small id="excerpt-counter" class="form-text"></small>');
        }
        
        $('#excerpt-counter').text(`${currentLength}/${maxLength} characters`);
        
        if (remaining < 0) {
            $('#excerpt-counter').addClass('text-danger');
        } else {
            $('#excerpt-counter').removeClass('text-danger').addClass('text-muted');
        }
    });
    
    // Status change handler
    $('#status').change(function() {
        const status = $(this).val();
        const publishedAtField = $('#published_at');
        const publishedAtLabel = $('label[for="published_at"]');
        
        if (status === 'published') {
            publishedAtLabel.text('Publish Date *');
            if (!publishedAtField.val()) {
                // Set current datetime as default
                const now = new Date();
                now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                publishedAtField.val(now.toISOString().slice(0, 16));
            }
        } else {
            publishedAtLabel.text('Publish Date');
        }
    });
    
    // Initialize status change
    $('#status').trigger('change');
});
</script>
@endpush