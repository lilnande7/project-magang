@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/news.css?v=' . time()) }}">
@endsection

@section('content')
<section class="news-detail">
    <div class="container">
        <a href="{{ route('home') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Beranda
        </a>
        
        <div class="news-content">
            <div class="news-header">
                @if($news->featured_image)
                <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}" class="news-image">
                @endif
                <div class="news-overlay">
                    <span class="news-category">{{ $news->category }}</span>
                    <h1 class="news-title">{{ $news->title }}</h1>
                    <div class="news-meta">
                        <div>
                            <i class="fas fa-calendar-alt me-2"></i>
                            {{ $news->created_at->format('d F Y') }}
                        </div>
                        <div>
                            <i class="fas fa-clock me-2"></i>
                            {{ $news->created_at->format('H:i') }} WIB
                        </div>
                        @if($news->is_featured)
                        <div>
                            <i class="fas fa-star me-2"></i>
                            Berita Utama
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="news-body">
                <div class="news-content-text">
                    {!! nl2br(e($news->content)) !!}
                </div>
                
                <hr class="my-5">
                
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        <small>Dipublish pada: {{ $news->created_at->format('d F Y, H:i') }} WIB</small>
                    </div>
                    <div class="share-buttons">
                        <span class="me-3">Bagikan:</span>
                        <a href="https://facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           class="btn btn-primary btn-sm me-2" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($news->title) }}" 
                           class="btn btn-info btn-sm me-2" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . request()->url()) }}" 
                           class="btn btn-success btn-sm" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection