@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/home.css?v=' . time()) }}">
@endsection

@section('content')

@php
    $headlineNews = $latestNews->first() ?? $featuredNews->first();
    $spotlightId = $headlineNews?->id;
@endphp

{{-- ===== HERO SECTION WITH STACKED CONTENT ===== --}}
<section class="hero" id="heroSection">
    <div class="hero-slideshow">
        <div class="hero-slide active" style="background-image: url('{{ asset('images/perpusumn.jpeg') }}');"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('images/areabaca.jpeg') }}');"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('images/perpuslabbahasa.png') }}');"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('images/library-building.jpg') }}');"></div>
    </div>

    <div class="hero-overlay"></div>

    <div class="hero-inner">
        <div class="hero-left" data-animate="fadeInUp">
            <span class="hero-pill">Perpustakaan Digital Aviasi</span>
            <h1>
                <span class="hero-highlight" id="changing-text">Perpustakaan</span> Politeknik Penerbangan <br>
                Indonesia Curug
            </h1>
            <p class="hero-description" id="subtitle-text">
                Pusat informasi penerbangan dan referensi ilmiah untuk sivitas akademika
                dengan layanan fisik dan digital sepanjang hari.
            </p>

            <div class="hero-buttons">
                <a href="{{ route('profile') }}" class="btn-hero-primary">Lihat Profil</a>
                <a href="https://digilib.ppicurug.ac.id" target="_blank" class="btn-hero-secondary">Katalog Online</a>
            </div>

            {{-- <div class="hero-metrics">
                <div class="metric-card">
                    <span class="metric-label">Koleksi</span>
                    <span class="metric-value">{{ number_format($stats['total_books'] ?? 0) }}</span>
                    <small>Total Buku</small>
                </div>
                <div class="metric-card">
                    <span class="metric-label">Kategori</span>
                    <span class="metric-value">{{ number_format($stats['total_categories'] ?? 0) }}</span>
                    <small>Bidang Bahasan</small>
                </div>
                <div class="metric-card">
                    <span class="metric-label">Anggota</span>
                    <span class="metric-value">{{ number_format($stats['total_members'] ?? 0) }}</span>
                    <small>Aktif Terdaftar</small>
                </div>
            </div>
        </div> --}}

        <div class="hero-right">
            <div class="hero-card hero-hours" data-animate="fadeInUp" data-delay="200">
                <div class="card-label">Jadwal Layanan</div>
                <ul>
                    <li><span>Senin - Jumat</span><span>08.00 - 17.00</span></li>

                </ul>
                <p>Reservasi ruang baca dan layanan referensi daring tersedia melalui helpdesk.</p>
            </div>

            <div class="hero-card hero-news-preview" data-animate="fadeInUp" data-delay="300">
                <div class="card-label">Berita Terkini</div>
                @if($headlineNews)
                    <h3>{{ $headlineNews->title }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($headlineNews->excerpt ?? $headlineNews->content ?? ''), 140, '...') }}</p>
                    <div class="news-preview-meta">
                        <span><i class="far fa-calendar"></i> {{ $headlineNews->created_at->format('d M Y') }}</span>
                        <span><i class="far fa-user"></i> Admin</span>
                    </div>
                    <a href="{{ route('news.show', $headlineNews->id) }}" class="btn-pill">Baca selengkapnya</a>
                @else
                    <p>Informasi terbaru seputar program literasi akan hadir di sini.</p>
                    <a href="{{ route('news.index') }}" class="btn-pill">Lihat Berita</a>
                @endif
            </div>
        </div>
    </div>

    <div class="hero-indicators">
        <span class="indicator active" data-slide="0"></span>
        <span class="indicator" data-slide="1"></span>
        <span class="indicator" data-slide="2"></span>
        <span class="indicator" data-slide="3"></span>
    </div>

    <div class="scroll-indicator">
        <span>Jelajahi halaman</span>
        <a href="#searchSection"><i class="fas fa-chevron-down"></i></a>
    </div>
</section>

{{-- ===== SEARCH & DISCOVERY SECTION ===== --}}
<section class="search-section" id="searchSection">
    <div class="search-grid">
        <div class="search-content" data-animate="fadeInLeft">
            <span class="section-label">Pencarian Koleksi</span>
            <h2>Temukan referensi terbaik dalam hitungan detik</h2>
            <p>Lebih dari {{ number_format($stats['total_books'] ?? 0) }} buku, jurnal, dan repository dapat kamu jelajahi secara daring.</p>
            <ul class="search-highlights">
                <li><i class="fas fa-bolt"></i> Pencarian lintas judul, penulis, dan kata kunci</li>
                <li><i class="fas fa-cloud"></i> Koleksi digital tersedia 24/7</li>
                <li><i class="fas fa-headset"></i> Bantuan pustakawan secara real-time</li>
            </ul>
        </div>
        <div class="search-form-wrapper" data-animate="fadeInRight">
            <form action="https://digilib.ppicurug.ac.id" method="GET" class="search-form" target="_blank">
                <label>Cari katalog</label>
                <div class="search-input-group">
                    <i class="fas fa-search"></i>
                    <input type="text" name="q" placeholder="Masukkan judul, penulis, atau kata kunci...">
                </div>
                <button type="submit" class="btn-search">Mulai Telusuri</button>
            </form>
        </div>
    </div>
</section>

{{-- ===== FEATURED SERVICES ===== --}}
<section class="feature-section">
    <div class="section-header" data-animate="fadeInUp">
        <span class="section-label">Layanan & Pengalaman</span>
        <h2>Layanan utama yang bisa kamu manfaatkan</h2>
        <p>Kombinasi ruang fisik nyaman dan akses digital yang responsif.</p>
    </div>
    <div class="feature-grid">
        <article class="feature-card" data-animate="fadeInUp">
            <div class="feature-icon"><i class="fas fa-university"></i></div>
            <h3>Profil & Regulasi</h3>
            <p>Kenali sejarah, misi, dan standar layanan perpustakaan PPI Curug.</p>
            <a href="{{ route('profile') }}" class="feature-link">Selengkapnya <i class="fas fa-arrow-right"></i></a>
        </article>
        <article class="feature-card" data-animate="fadeInUp" data-delay="150">
            <div class="feature-icon"><i class="fas fa-concierge-bell"></i></div>
            <h3>Layanan Referensi</h3>
            <ul>
                <li>Layanan sirkulasi & reservasi ruang</li>
                <li>Repositori tugas akhir & jurnal</li>
                <li>Wifi berkecepatan tinggi & spot diskusi</li>
            </ul>
        </article>
        <article class="feature-card" data-animate="fadeInUp" data-delay="300">
            <div class="feature-icon"><i class="fas fa-tablet-alt"></i></div>
            <h3>Akses Digital</h3>
            <p>Katalog OPAC, e-book, dan repository dapat dibuka melalui perangkat favoritmu.</p>
            <a href="https://digilib.ppicurug.ac.id" target="_blank" class="feature-link">Akses OPAC <i class="fas fa-external-link-alt"></i></a>
        </article>
    </div>
</section>

{{-- ===== ABOUT SECTION ===== --}}
<section class="about-section">
    <div class="about-grid">
        <div class="about-visual" data-animate="fadeInLeft">
            <div class="photo-card primary">
                <img src="{{ asset('images/remove.png') }}" alt="Perpustakaan PPI Curug">
            </div>
            <div class="photo-card secondary">
                <img src="{{ asset('images/areabaca.jpeg') }}" alt="Area Baca">
            </div>
        </div>
        <div class="about-content" data-animate="fadeInRight">
            <span class="section-label">Tentang Kami</span>
            <h2>Mendorong budaya riset dan literasi penerbangan</h2>
            <p>Perpustakaan Politeknik Penerbangan Indonesia Curug menjadi pusat data, dokumentasi, dan literatur penerbangan dengan pendekatan layanan yang adaptif.</p>
            <div class="about-timeline">
                <div>
                    <span>Fasilitas Modern</span>
                    <p>Ruang kolaborasi, studio multimedia, dan koleksi referensi terbaru.</p>
                </div>
                <div>
                    <span>Layanan Digital</span>
                    <p>OPAC, repository, dan konsultasi referensi dapat diakses secara daring.</p>
                </div>
            </div>
            <a href="{{ route('profile') }}" class="btn-outline">Baca Selengkapnya</a>
        </div>
    </div>
</section>

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

{{-- ===== NEWS SECTION ===== --}}
<section class="news-section" id="news">
    <div class="section-header" data-animate="fadeInUp">
        <span class="section-label">Informasi</span>
        <h2>Berita terbaru & agenda perpustakaan</h2>
        <p>Ikuti program literasi, workshop, dan rilis koleksi terbaru</p>
    </div>

    @if($headlineNews)
    <div class="news-spotlight" data-animate="fadeInUp">
        <div class="spotlight-content">
            <span class="spotlight-label">Sorotan Hari Ini</span>
            <h3>{{ $headlineNews->title }}</h3>
            <p>{{ \Illuminate\Support\Str::limit(strip_tags($headlineNews->excerpt ?? $headlineNews->content ?? ''), 200, '...') }}</p>
            <div class="spotlight-meta">
                <span><i class="far fa-calendar-alt"></i> {{ $headlineNews->created_at->format('d M Y') }}</span>
                <span><i class="fas fa-tag"></i> {{ optional($headlineNews->category)->name ?? 'Berita' }}</span>
            </div>
            <a href="{{ route('news.show', $headlineNews->id) }}" class="btn-outline">Baca Berita</a>
        </div>
        <div class="spotlight-image">
            @if($headlineNews->featured_image)
                <img src="{{ asset('storage/' . $headlineNews->featured_image) }}" alt="{{ $headlineNews->title }}">
            @else
                <div class="spotlight-placeholder"><i class="fas fa-newspaper"></i></div>
            @endif
        </div>
    </div>
    @endif

    @php
        $newsFeed = $featuredNews->concat($latestNews);
    @endphp

    @if($newsFeed->count() > 0)
    <div class="news-grid">
        @foreach($newsFeed as $index => $news)
            @continue($spotlightId && $news->id === $spotlightId)
            <article class="news-card" data-animate="fadeInUp" data-delay="{{ $index * 90 }}">
                <div class="news-thumb">
                    @if($news->featured_image)
                        <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}">
                    @else
                        <div class="news-thumb-placeholder"><i class="fas fa-image"></i></div>
                    @endif
                </div>
                <div class="news-body">
                    <span class="news-date">{{ $news->created_at->format('d M Y') }}</span>
                    <h4><a href="{{ route('news.show', $news->id) }}">{{ $news->title }}</a></h4>
                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($news->excerpt ?? $news->content ?? ''), 120, '...') }}</p>
                    <a href="{{ route('news.show', $news->id) }}" class="news-link">Baca selengkapnya</a>
                </div>
            </article>
        @endforeach
    </div>
    <div class="news-more" data-animate="fadeInUp">
        <a href="{{ route('news.index') }}" class="btn-outline">Lihat semua berita</a>
    </div>
    @else
    <div class="no-news" data-animate="fadeIn">
        <i class="fas fa-newspaper"></i>
        <p>Belum ada berita terbaru untuk ditampilkan.</p>
    </div>
    @endif
</section>

{{-- ===== STATISTICS SECTION ===== --}}
<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-card" data-animate="fadeInUp" data-delay="0">
            <div class="stat-icon"><i class="fas fa-books"></i></div>
            <h3 class="stat-number" data-count="{{ $stats['total_books'] ?? 0 }}">0</h3>
            <p>Total Koleksi Buku</p>
        </div>
        <div class="stat-card" data-animate="fadeInUp" data-delay="150">
            <div class="stat-icon"><i class="fas fa-book-open"></i></div>
            <h3 class="stat-number" data-count="{{ $stats['available_books'] ?? 0 }}">0</h3>
            <p>Buku Tersedia</p>
        </div>
        <div class="stat-card" data-animate="fadeInUp" data-delay="300">
            <div class="stat-icon"><i class="fas fa-tags"></i></div>
            <h3 class="stat-number" data-count="{{ $stats['total_categories'] ?? 0 }}">0</h3>
            <p>Kategori Buku</p>
        </div>
        <div class="stat-card" data-animate="fadeInUp" data-delay="450">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <h3 class="stat-number" data-count="{{ $stats['total_members'] ?? 0 }}">0</h3>
            <p>Anggota Aktif</p>
        </div>
    </div>
</section>

{{-- ===== MEDIA SECTION (YOUTUBE + INSTAGRAM) ===== --}}
<section class="media-section">
    <div class="section-header" data-animate="fadeInUp">
        <span class="section-label">Tur Virtual</span>
        <h2>Rasakan atmosfer perpustakaan dari mana saja</h2>
        <p>Video profil dan pengalaman Instagram terbaru</p>
    </div>
    <div class="media-grid">
        <div class="media-card" data-animate="fadeInUp">
            <span class="card-label">Video Profil</span>
            <h3>Perpustakaan PPI Curug</h3>
            <div class="media-embed">
                <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Video Profil Perpustakaan" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
        <div class="media-card" data-animate="fadeInUp" data-delay="150">
            <span class="card-label">Instagram Reels</span>
            <h3>Highlight Kegiatan Literasi</h3>
            <div class="media-embed instagram">
                <iframe src="https://www.instagram.com/p/C77r4R5S7sN/embed" title="Instagram Reels Perpustakaan" frameborder="0" allowtransparency="true" allow="encrypted-media" scrolling="no"></iframe>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
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
