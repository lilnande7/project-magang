{{-- ===== TOP CATEGORIES ===== --}}
<section class="categories-section">
    <div class="section-header" data-animate="fadeInUp">
        <span class="section-label">Koleksi Kami</span>
        <h2>Bidang kajian favorit</h2>
        <p>Kategori dengan tingkat peminjaman tertinggi</p>
    </div>
    <div class="categories-grid">
        @if(isset($topCategories) && count($topCategories) > 0)
            @foreach($topCategories as $index => $category)
            <div class="category-card" data-animate="fadeInUp" data-delay="{{ $index * 120 }}">
                <div class="category-icon"><i class="fas fa-book"></i></div>
                <h4>{{ $category->name }}</h4>
                <span>{{ $category->books_count ?? 0 }} koleksi</span>
            </div>
            @endforeach
        @else
            @php
                $defaultCategories = [
                    ['icon' => 'fa-book', 'name' => 'Buku Umum', 'count' => $stats['total_books'] ?? 0],
                    ['icon' => 'fa-plane-departure', 'name' => 'Teknologi Penerbangan', 'count' => 0],
                    ['icon' => 'fa-graduation-cap', 'name' => 'Tugas Akhir', 'count' => 0],
                    ['icon' => 'fa-chart-line', 'name' => 'Manajemen Bandara', 'count' => 0],
                    ['icon' => 'fa-tablet-alt', 'name' => 'E-Book', 'count' => 0],
                    ['icon' => 'fa-scroll', 'name' => 'Referensi', 'count' => 0],
                ];
            @endphp
            @foreach($defaultCategories as $index => $cat)
            <div class="category-card" data-animate="fadeInUp" data-delay="{{ $index * 120 }}">
                <div class="category-icon"><i class="fas {{ $cat['icon'] }}"></i></div>
                <h4>{{ $cat['name'] }}</h4>
                <span>{{ $cat['count'] }} koleksi</span>
            </div>
            @endforeach
        @endif
    </div>
</section>
