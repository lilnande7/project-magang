@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')

<section class="hero">
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <p class="unit-dokumentasi">Unit Perpustakaan</p>
        <h3>
            SELAMAT DATANG DI PERPUSTAKAAN
            <br>POLITEKNIK PENERBANGAN INDONESIA CURUG</br>
        </h3>
        <p class="layanan-sirkulasi">Layanan Sirkulasi & Referensi</p>
    </div>
</section>

<section class="highlight-section">
    <div class="container">
        <div class="card-grid">
            <div class="card">
                <div class="card-body">
                    <span class="badge">Profil Perpustakaan</span>
                    <h3>Sekilas tentang perpustakaan</h3>
                    <p>
                        Perpustakaan Politeknik Penerbangan Indonesia Curug
                        merupakan pusat layanan informasi.
                    </p>
                    <a href="{{ route('profile') }}" class="read-more">SELENGKAPNYA »</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <span class="badge">Layanan Utama</span>
                    <h3>Beberapa Layanan & Fasilitas</h3>
                    <ul>
                        <li>Layanan Sirkulasi</li>
                        <li>Layanan Referensi</li>
                        <li>Layanan Repositori</li>
                        <li>E-Resources</li>
                        <li>Ruang Baca</li>
                        <li>Wifi</li>
                        <li>Loker Tas</li>
                        <li>Ruang Baca</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <span class="badge">Akses Digital</span>
                    <h3>Manfaat akses digital</h3>
                    <p>
                        Akses katalog koleksi dan repository karya ilmiah
                        secara online.
                    </p>
                    <a href="#" class="read-more">SELENGKAPNYA »</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about">
    <div class="about-container">
        <div class="about-image">
            <img src="{{ asset('images/remove.png') }}" alt="Perpustakaan PPI Curug">
        </div>

        <div class="about-content">
            <h2>Tentang Perpustakaan</h2>
            <p>
                Perpustakaan Politeknik Penerbangan Indonesia Curug
                merupakan pusat layanan informasi dan dokumentasi
                yang mendukung kegiatan pendidikan, penelitian,
                dan pengembangan ilmu pengetahuan.
            </p>
        </div>
    </div>
</section>

<section class="news-section">
    <!-- Featured News Section -->
    @if($featuredNews->count() > 0)
    <div class="featured-news-section mb-5">
        <h2 class="section-title" style="color: #e74c3c; border-bottom: 3px solid #e74c3c;">BERITA UTAMA</h2>
        <div class="row">
            @foreach($featuredNews as $index => $news)
            <div class="col-md-{{ $index == 0 ? '8' : '4' }} mb-4">
                <div class="featured-news-card {{ $index == 0 ? 'main-featured' : '' }}">
                    @if($news->featured_image)
                    <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}" class="featured-news-image">
                    @else
                    <div class="news-placeholder">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    @endif
                    <div class="featured-news-content">
                        <span class="featured-badge">UTAMA</span>
                        <h3>{{ $news->title }}</h3>
                        <div class="news-date">
                            📅 {{ $news->created_at->format('d M Y, H:i') }}
                        </div>
                        <p>{{ Str::limit(strip_tags($news->content), $index == 0 ? 200 : 100) }}</p>
                        <a href="{{ route('news.show', $news->id) }}" class="read-more">Read More</a>
                    </div>
                </div>
            </div>
            @if($index == 0 && $featuredNews->count() > 1)
            <div class="col-md-4">
                <div class="row">
            @endif
            @endforeach
            @if($featuredNews->count() > 1)
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Regular News Section -->
    <h2 class="section-title">BERITA TERBARU</h2>

    <div class="news-grid">
        @forelse($latestNews as $news)
        <div class="news-card">
            @if($news->featured_image)
            <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}">
            @else
            <div class="news-placeholder">
                <i class="fas fa-image"></i>
            </div>
            @endif
            <h3>{{ $news->title }}</h3>

            <div class="news-date">
                📅 {{ $news->created_at->format('d M Y, H:i:s') }}
            </div>

            <p>{{ Str::limit(strip_tags($news->content), 150) }}</p>

            <a href="{{ route('news.show', $news->id) }}" class="read-more">Read More</a>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <h4 class="text-muted">Belum ada berita terbaru</h4>
            <p class="text-muted">Berita akan segera hadir di sini.</p>
        </div>
        @endforelse
    </div>
</section>

<!-- Statistics Section -->
<section class="stats-section py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <h3 class="display-4 text-primary">{{ $stats['total_books'] }}</h3>
                    <p class="lead">Total Koleksi Buku</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <h3 class="display-4 text-success">{{ $stats['available_books'] }}</h3>
                    <p class="lead">Buku Tersedia</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <h3 class="display-4 text-info">{{ $stats['total_categories'] }}</h3>
                    <p class="lead">Kategori Buku</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection