@extends('layouts.app')

@section('title', 'Katalog Buku — Perpustakaan PPIC')

@section('css')
<style>
/* ===== KATALOG PAGE ===== */
.catalog-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #1c7ed6 100%);
    padding: 80px 0 60px;
    position: relative;
    overflow: hidden;
}
.catalog-hero::before {
    content: '';
    position: absolute;
    width: 600px; height: 600px;
    border-radius: 50%;
    background: rgba(28,126,214,0.12);
    top: -200px; right: -150px;
    pointer-events: none;
}
.catalog-hero h1 { font-size: 2.4rem; font-weight: 700; color: #fff; margin-bottom: 10px; }
.catalog-hero p  { color: rgba(255,255,255,.7); font-size: 1.1rem; }

/* Search bar */
.search-bar-wrap { max-width: 700px; margin: 28px auto 0; }
.search-bar-wrap .input-group .form-control {
    border-radius: 50px 0 0 50px;
    border: none;
    font-size: 1rem;
    padding: 14px 22px;
    box-shadow: none;
}
.search-bar-wrap .btn-search {
    border-radius: 0 50px 50px 0;
    background: #1c7ed6;
    border: none;
    color: #fff;
    padding: 0 28px;
    font-weight: 600;
}

/* Filter sidebar */
.filter-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e9ecef;
    padding: 20px;
    position: sticky; top: 90px;
}
.filter-card h6 { font-weight: 700; color: #1e3a5f; margin-bottom: 12px; }
.filter-card .form-label { font-size: .85rem; color: #555; font-weight: 600; }
.filter-card .form-select, .filter-card .form-control {
    font-size: .9rem; border-radius: 10px;
}

/* Book card */
.book-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e9ecef;
    overflow: hidden;
    transition: transform .25s, box-shadow .25s;
    height: 100%;
    display: flex; flex-direction: column;
}
.book-card:hover { transform: translateY(-5px); box-shadow: 0 12px 32px rgba(0,0,0,.1); }
.book-card-img {
    width: 100%; height: 200px;
    object-fit: cover;
    background: linear-gradient(135deg, #e8f4fd, #cfe2f3);
}
.book-card-img-placeholder {
    width: 100%; height: 200px;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    background: linear-gradient(135deg, #e8f4fd, #cfe2f3);
    color: #7db8e0;
    font-size: 3rem;
}
.book-card-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
.book-title {
    font-size: .95rem; font-weight: 700; color: #1e3a5f;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden; margin-bottom: 4px;
}
.book-author { font-size: .82rem; color: #666; margin-bottom: 8px; }
.book-meta  { font-size: .78rem; color: #888; }
.badge-available { background: #d1fae5; color: #065f46; }
.badge-borrowed  { background: #fee2e2; color: #991b1b; }
.badge-maintenance { background: #fef3c7; color: #92400e; }
.btn-detail {
    border-radius: 10px;
    background: #1c7ed6;
    color: #fff; border: none;
    padding: 8px 16px; font-size: .88rem;
    font-weight: 600; margin-top: auto;
    transition: background .2s;
    text-decoration: none; display: inline-block; text-align: center;
}
.btn-detail:hover { background: #1565b8; color: #fff; text-decoration: none; }

/* Pagination */
.pagination .page-link { border-radius: 8px !important; margin: 0 2px; }
.pagination .active .page-link { background: #1c7ed6; border-color: #1c7ed6; }

.result-info { font-size: .9rem; color: #555; }
</style>
@endsection

@section('content')
<!-- Hero -->
<div class="catalog-hero">
    <div class="container">
        <div class="text-center">
            <h1><i class="fa fa-book me-2"></i> Katalog Buku Perpustakaan</h1>
            <p>Temukan koleksi buku, jurnal, dan referensi Politeknik Penerbangan Indonesia Curug</p>
        </div>

        <div class="search-bar-wrap">
            <form action="{{ route('catalog.index') }}" method="GET" id="searchForm">
                <div class="input-group shadow">
                    <input type="text" name="q" class="form-control"
                           placeholder="Cari judul, pengarang, ISBN, topik..."
                           value="{{ request('q') }}">
                    <button class="btn btn-search" type="submit">
                        <i class="fa fa-search me-1"></i> Cari
                    </button>
                </div>
                <!-- preserve filters -->
                @foreach(['category','availability','language','sort'] as $f)
                    @if(request($f))<input type="hidden" name="{{ $f }}" value="{{ request($f) }}">@endif
                @endforeach
            </form>
        </div>
    </div>
</div>

<!-- Main -->
<div class="container" style="padding:40px 0 60px;">
    <div class="row">
        <!-- Sidebar Filter -->
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="filter-card">
                <h6><i class="fa fa-filter me-1"></i> Filter Koleksi</h6>
                <form action="{{ route('catalog.index') }}" method="GET" id="filterForm">
                    @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ketersediaan</label>
                        <select name="availability" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Semua</option>
                            <option value="available" {{ request('availability') === 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="borrowed"  {{ request('availability') === 'borrowed'  ? 'selected' : '' }}>Sedang Dipinjam</option>
                            <option value="maintenance" {{ request('availability') === 'maintenance' ? 'selected' : '' }}>Dalam Perawatan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bahasa</label>
                        <select name="language" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Semua Bahasa</option>
                            @foreach($languages as $lang)
                                <option value="{{ $lang }}" {{ request('language') === $lang ? 'selected' : '' }}>{{ $lang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Urutkan</label>
                        <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="title"  {{ request('sort','title') === 'title'  ? 'selected' : '' }}>Judul A-Z</option>
                            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="author" {{ request('sort') === 'author' ? 'selected' : '' }}>Pengarang A-Z</option>
                        </select>
                    </div>

                    @if(request()->hasAny(['q','category','availability','language','sort']))
                        <a href="{{ route('catalog.index') }}" class="btn btn-sm btn-outline-secondary w-100">
                            <i class="fa fa-times me-1"></i> Reset Filter
                        </a>
                    @endif
                </form>

                @auth
                <hr>
                <a href="{{ route('catalog.my-borrowings') }}" class="btn btn-sm w-100"
                   style="background:#1e3a5f;color:#fff;border-radius:10px;">
                    <i class="fa fa-history me-1"></i> Riwayat Peminjaman Saya
                </a>
                @endauth
            </div>
        </div>

        <!-- Book Grid -->
        <div class="col-lg-9 col-md-8">
            <!-- Result info -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="result-info">
                    Menampilkan <strong>{{ $books->firstItem() ?? 0 }}–{{ $books->lastItem() ?? 0 }}</strong>
                    dari <strong>{{ $books->total() }}</strong> koleksi
                    @if(request('q')) untuk "<em>{{ request('q') }}</em>" @endif
                </span>
            </div>

            @if($books->isEmpty())
                <div class="text-center py-5">
                    <i class="fa fa-search" style="font-size:4rem;color:#ccc;"></i>
                    <h5 class="mt-3 text-muted">Koleksi tidak ditemukan</h5>
                    <p class="text-muted">Coba ubah kata kunci atau filter pencarian</p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-primary">Lihat Semua Koleksi</a>
                </div>
            @else
                <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3">
                    @foreach($books as $book)
                    <div class="col">
                        <div class="book-card shadow-sm">
                            @if($book->cover_url)
                                <img src="https://digilib.ppicurug.ac.id/images/docs/{{ $book->cover_url }}"
                                     class="book-card-img"
                                     alt="{{ $book->title }}"
                                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                <div class="book-card-img-placeholder" style="display:none;">
                                    <i class="fa fa-book"></i>
                                </div>
                            @else
                                <div class="book-card-img-placeholder">
                                    <i class="fa fa-book"></i>
                                </div>
                            @endif

                            <div class="book-card-body">
                                <div class="book-title" title="{{ $book->title }}">{{ $book->title }}</div>
                                <div class="book-author"><i class="fa fa-user-o me-1"></i>{{ $book->author }}</div>

                                <div class="book-meta mb-2">
                                    @if($book->publisher) <div>{{ $book->publisher }}{{ $book->year ? ", $book->year" : '' }}</div> @endif
                                    @if($book->call_number) <div><i class="fa fa-tag me-1"></i>{{ $book->call_number }}</div> @endif
                                </div>

                                <div class="mb-2">
                                    @if($book->status === 'available')
                                        <span class="badge badge-available rounded-pill px-2">
                                            <i class="fa fa-check-circle me-1"></i>Tersedia
                                        </span>
                                    @elseif($book->status === 'borrowed')
                                        <span class="badge badge-borrowed rounded-pill px-2">
                                            <i class="fa fa-times-circle me-1"></i>Dipinjam
                                        </span>
                                    @else
                                        <span class="badge badge-maintenance rounded-pill px-2">Perawatan</span>
                                    @endif
                                </div>

                                <a href="{{ route('catalog.show', $book) }}" class="btn-detail w-100">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $books->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
