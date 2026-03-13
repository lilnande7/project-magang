@php
    $book = $book ?? null;
    $statuses = [
        'available' => 'Available',
        'borrowed' => 'Borrowed',
        'maintenance' => 'Maintenance',
        'lost' => 'Lost',
    ];
@endphp

<div class="row g-4">
    <div class="col-lg-6">
        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
        <input type="text" 
               class="form-control"
               id="title"
               name="title"
               value="{{ old('title', optional($book)->title) }}"
               required>
    </div>
    
    <div class="col-lg-6">
        <label for="author" class="form-label">Author <span class="text-danger">*</span></label>
        <input type="text" 
               class="form-control"
               id="author"
               name="author"
               value="{{ old('author', optional($book)->author) }}"
               required>
    </div>
    
    <div class="col-lg-4">
        <label for="isbn" class="form-label">ISBN</label>
        <input type="text" 
               class="form-control"
               id="isbn"
               name="isbn"
               value="{{ old('isbn', optional($book)->isbn) }}">
    </div>
    
    <div class="col-lg-4">
        <label for="publisher" class="form-label">Publisher</label>
        <input type="text" 
               class="form-control"
               id="publisher"
               name="publisher"
               value="{{ old('publisher', optional($book)->publisher) }}">
    </div>
    
    <div class="col-lg-4">
        <label for="year" class="form-label">Publication Year</label>
        <input type="number" 
               class="form-control"
               id="year"
               name="year"
               min="1900"
               max="2030"
               value="{{ old('year', optional($book)->year) }}">
    </div>
    
    <div class="col-lg-4">
        <label for="pages" class="form-label">Total Pages</label>
        <input type="number" 
               class="form-control"
               id="pages"
               name="pages"
               min="1"
               value="{{ old('pages', optional($book)->pages) }}">
    </div>
    
    <div class="col-lg-4">
        <label for="language" class="form-label">Language</label>
        <input type="text" 
               class="form-control"
               id="language"
               name="language"
               value="{{ old('language', optional($book)->language) }}">
    </div>
    
    <div class="col-lg-4">
        <label for="stock" class="form-label">Available Stock <span class="text-danger">*</span></label>
        <input type="number" 
               class="form-control"
               id="stock"
               name="stock"
               min="1"
               value="{{ old('stock', optional($book)->stock ?? 1) }}"
               required>
    </div>
    
    <div class="col-lg-6">
        <label for="category_id" class="form-label">Category</label>
        <select class="form-select" id="category_id" name="category_id">
            <option value="">Select category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" 
                        {{ (string) old('category_id', optional($book)->category_id) === (string) $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    
    <div class="col-lg-6">
        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
        <select class="form-select" id="status" name="status" required>
            @foreach($statuses as $key => $label)
                <option value="{{ $key }}" 
                        {{ old('status', optional($book)->status ?? 'available') === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>
    
    <div class="col-lg-6">
        <label for="location" class="form-label">Shelf Location</label>
        <input type="text" 
               class="form-control"
               id="location"
               name="location"
               value="{{ old('location', optional($book)->location) }}">
    </div>
    
    <div class="col-lg-6">
        <label for="subjects" class="form-label">Subjects / Tags</label>
        <input type="text" 
               class="form-control"
               id="subjects"
               name="subjects"
               value="{{ old('subjects', optional($book)->subjects) }}"
               placeholder="e.g. automation, quality, management">
    </div>
    
    <div class="col-12">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control"
                  id="description"
                  name="description"
                  rows="4"
                  placeholder="Short summary about the book">{{ old('description', optional($book)->description) }}</textarea>
    </div>
    
    <div class="col-lg-6">
        <label for="cover_image" class="form-label">Cover Image</label>
        <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*">
        <small class="text-muted">Accepted formats: JPG or PNG, max 2 MB.</small>
        @if(isset($book) && $book->cover_image)
            <div class="mt-3">
                <p class="text-muted mb-2">Current cover:</p>
                <img src="{{ asset('storage/' . $book->cover_image) }}" 
                     alt="{{ $book->title }} cover" 
                     class="rounded border"
                     style="max-width: 180px; height: auto;">
            </div>
        @endif
    </div>
</div>