@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/news.css?v=' . time()) }}">
@endsection

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <nav class="breadcrumb-custom">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                </li>
                <li class="breadcrumb-item active">Berita</li>
            </ol>
        </nav>
        <h1 class="page-title">Berita Terkini</h1>
        <p class="page-subtitle">Informasi dan kabar terbaru dari Perpustakaan Politeknik Penerbangan Indonesia</p>
    </div>
</section>

<div class="news-page">
    <div class="container">
        
        <!-- Featured News Section -->
        @if($featuredNews->count() > 0)
        <section class="featured-section">
            <div class="section-header">
                <h2 class="section-title">Berita Utama</h2>
                <p class="section-subtitle">Sorotan berita penting dan terkini</p>
            </div>
            
            <div class="featured-news-grid">
                <!-- Main Featured News -->
                <article class="featured-main">
                    @php $mainNews = $featuredNews->first(); @endphp
                    @if($mainNews->featured_image)
                    <img src="{{ asset('storage/' . $mainNews->featured_image) }}" 
                         alt="{{ $mainNews->title }}" 
                         class="featured-main-image">
                    @else
                    <div class="news-placeholder">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    @endif
                    
                    <div class="featured-main-content">
                        <span class="featured-badge">BERITA UTAMA</span>
                        <h2 class="featured-main-title">
                            <a href="{{ route('news.show', $mainNews->id) }}">{{ $mainNews->title }}</a>
                        </h2>
                        <div class="news-meta">
                            <span><i class="fas fa-calendar-alt"></i> {{ $mainNews->created_at->format('d F Y') }}</span>
                            <span><i class="fas fa-user"></i> Admin</span>
                        </div>
                        <p class="news-excerpt">{{ Str::limit(strip_tags($mainNews->content), 200) }}</p>
                        <a href="{{ route('news.show', $mainNews->id) }}" class="read-more-link">
                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
                
                <!-- Featured Sidebar -->
                <div class="featured-sidebar">
                    @foreach($featuredNews->skip(1)->take(2) as $sidebarNews)
                    <article class="featured-sidebar-item">
                        @if($sidebarNews->featured_image)
                        <img src="{{ asset('storage/' . $sidebarNews->featured_image) }}" 
                             alt="{{ $sidebarNews->title }}" 
                             class="sidebar-image">
                        @else
                        <div class="news-placeholder" style="height: 120px; font-size: 24px;">
                            <i class="fas fa-image"></i>
                        </div>
                        @endif
                        
                        <div class="sidebar-content">
                            <h3 class="sidebar-title">
                                <a href="{{ route('news.show', $sidebarNews->id) }}">{{ Str::limit($sidebarNews->title, 80) }}</a>
                            </h3>
                            <div class="sidebar-date">{{ $sidebarNews->created_at->format('d F Y') }}</div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
        
        <!-- All News Section -->
        <section class="all-news-section">
            <div class="section-header">
                <h2 class="section-title">Semua Berita</h2>
                <p class="section-subtitle">Kumpulan berita dan informasi terlengkap</p>
            </div>
            
            @if($news->count() > 0)
            <div class="news-grid">
                @foreach($news as $article)
                <article class="news-card">
                    @if($article->featured_image)
                    <img src="{{ asset('storage/' . $article->featured_image) }}" 
                         alt="{{ $article->title }}" 
                         class="news-image">
                    @else
                    <div class="news-placeholder">
                        <i class="fas fa-image"></i>
                    </div>
                    @endif
                    
                    <div class="news-content">
                        <h3 class="news-title">
                            <a href="{{ route('news.show', $article->id) }}">{{ $article->title }}</a>
                        </h3>
                        <p class="news-excerpt-short">{{ Str::limit(strip_tags($article->content), 120) }}</p>
                        <div class="news-footer">
                            <span class="news-date">{{ $article->created_at->format('d M Y') }}</span>
                            <a href="{{ route('news.show', $article->id) }}" class="news-read-more">Baca Selengkapnya</a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $news->links() }}
            </div>
            @else
            <div class="no-news">
                <div class="no-news-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <h3>Belum Ada Berita</h3>
                <p>Berita akan segera hadir di sini. Silakan kembali lagi nanti!</p>
            </div>
            @endif
        </section>
        
    </div>
</div>
@endsection