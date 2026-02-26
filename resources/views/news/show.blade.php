@extends('layouts.app')

@section('css')
<style>
    .news-detail {
        padding: 80px 0;
        background: #f8f9fa;
    }
    
    .news-content {
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .news-header {
        position: relative;
        height: 400px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .news-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .news-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        padding: 40px;
        color: white;
    }
    
    .news-category {
        background: rgba(231, 76, 60, 0.9);
        color: white;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 15px;
    }
    
    .news-title {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 15px;
    }
    
    .news-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        opacity: 0.9;
    }
    
    .news-body {
        padding: 50px;
    }
    
    .news-content-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #2c3e50;
    }
    
    .news-content-text h1,
    .news-content-text h2,
    .news-content-text h3 {
        color: #2c3e50;
        margin: 30px 0 20px 0;
    }
    
    .news-content-text p {
        margin-bottom: 20px;
    }
    
    .news-content-text img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin: 20px 0;
    }
    
    .back-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: transform 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 30px;
    }
    
    .back-btn:hover {
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }
    
    @media (max-width: 768px) {
        .news-title {
            font-size: 2rem;
        }
        
        .news-body {
            padding: 30px 25px;
        }
        
        .news-overlay {
            padding: 25px;
        }
    }
</style>
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