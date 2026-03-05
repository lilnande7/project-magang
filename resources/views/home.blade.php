@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/home.css?v=' . time()) }}">
@endsection

@section('content')


@php
    // Prioritise berita yang ditandai admin sebagai featured / spotlight terlebih dahulu
    $headlineNews = $featuredNews->first() ?? $latestNews->first();
    $spotlightId = $headlineNews?->id;

    $instagramPosts = [
        [
            'image' => 'images/perpusumn.jpeg',
            'title' => 'Tur Perpustakaan',
            'description' => 'Suasana kunjungan literasi bersama taruna ATKP.',
            'link' => 'https://www.instagram.com/p/C77r4R5S7sN/',
            'likes' => '1.2K',
            'comments' => 86,
        ],
        [
            'image' => 'images/areabaca.jpeg',
            'title' => 'Zona Baca Baru',
            'description' => 'Area kolaborasi yang kini dibuka untuk umum setiap Jumat.',
            'link' => 'https://www.instagram.com/p/C77r4R5S7sN/',
            'likes' => '980',
            'comments' => 42,
        ],
        [
            'image' => 'images/perpuslabbahasa.png',
            'title' => 'Workshop Literasi',
            'description' => 'Sesi berbagi teknik riset dan sitasi bersama pustakawan.',
            'link' => 'https://www.instagram.com/p/C77r4R5S7sN/',
            'likes' => '1.5K',
            'comments' => 104,
        ],
    ];
@endphp


@include('home.hero')

@include('home.search')

@include('home.feature')

@include('home.about')

@include('home.categories')

@include('home.news')

@include('home.stats')

@include('home.media')

@endsection

@section('scripts')
<script async src="//www.instagram.com/embed.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // ===== HERO BACKGROUND SLIDESHOW =====
    var slides = document.querySelectorAll('.hero-slide');
    var indicators = document.querySelectorAll('.hero-indicators .indicator');
    var currentSlide = 0;
    var slideInterval;
    var slideDuration = 6000;

    function goToSlide(index) {
        slides.forEach(function(slide) {
            slide.classList.remove('active');
        });
        indicators.forEach(function(ind) {
            ind.classList.remove('active');
        });

        currentSlide = index;
        slides[currentSlide].classList.add('active');
        indicators[currentSlide].classList.add('active');
        updateHeroText(currentSlide);
    }

    function nextSlide() {
        var next = (currentSlide + 1) % slides.length;
        goToSlide(next);
    }

    function startSlideshow() {
        slideInterval = setInterval(nextSlide, slideDuration);
    }

    indicators.forEach(function(indicator) {
        indicator.addEventListener('click', function() {
            var slideIndex = parseInt(this.getAttribute('data-slide'));
            clearInterval(slideInterval);
            goToSlide(slideIndex);
            startSlideshow();
        });
    });

    if (slides.length) {
        updateHeroText(0, true);
        startSlideshow();
    } else {
        updateHeroText(0, true);
    }

    // ===== TEXT ROTATION IN HERO =====
    var changingText = document.getElementById('changing-text');
    var subtitleText = document.getElementById('subtitle-text');

    var slideContent = [
        {
            main: 'Perpustakaan',
            sub: 'Pusat layanan informasi dan dokumentasi yang mendukung pendidikan, penelitian, dan inovasi.'
        },
        {
            main: 'Knowledge Hub',
            sub: 'Ruang inspirasi dan kolaborasi bagi taruna, dosen, dan peneliti.'
        },
        {
            main: 'Digital Library',
            sub: 'Koleksi fisik dan digital yang selalu dapat diakses kapan saja.'
        },
        {
            main: 'Aviation Archive',
            sub: 'Koleksi historis penerbangan dan referensi teknis yang terkurasi.'
        }
    ];

    function updateHeroText(index, instant) {
        if (!changingText || !subtitleText) return;

        var content = slideContent[index % slideContent.length];

        if (instant) {
            changingText.textContent = content.main;
            subtitleText.textContent = content.sub;
            return;
        }

        changingText.classList.add('text-switching');
        subtitleText.classList.add('text-switching');

        setTimeout(function() {
            changingText.textContent = content.main;
            subtitleText.textContent = content.sub;
            changingText.classList.remove('text-switching');
            subtitleText.classList.remove('text-switching');
        }, 400);
    }

    // ===== STAT COUNTERS =====
    var statNumbers = document.querySelectorAll('.stat-number');

    var statsObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (!entry.isIntersecting) return;

            var el = entry.target;
            var target = parseInt(el.getAttribute('data-count') || '0', 10);
            var current = 0;
            var increment = Math.max(1, Math.floor(target / 60));

            var counter = setInterval(function() {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(counter);
                }
                el.textContent = current.toLocaleString('id-ID');
            }, 20);

            observer.unobserve(el);
        });
    }, { threshold: 0.4 });

    statNumbers.forEach(function(el) {
        statsObserver.observe(el);
    });
});
</script>



@endsection