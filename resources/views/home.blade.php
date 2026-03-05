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
            <a href="{{ route('gallery') }}" class="btn-outline">Baca Selengkapnya</a>
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
            <h3>Mars </h3>
            <div class="media-embed">
                <iframe src="https://www.youtube.com/embed/XXrnQKeTVSQ" title="Video Profil Perpustakaan" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
        <div class="media-card" data-animate="fadeInUp" data-delay="150">
            <span class="card-label">Instagram Reels</span>
            <h3>Highlight Kegiatan Literasi</h3>
            <div class="media-embed instagram">
                <blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/reel/DQMfPKxEhkD/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:16px;"> <a href="https://www.instagram.com/reel/DQMfPKxEhkD/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank"> <div style=" display: flex; flex-direction: row; align-items: center;"> <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div></div></div><div style="padding: 19% 0;"></div> <div style="display:block; height:50px; margin:0 auto 12px; width:50px;"><svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-511.000000, -20.000000)" fill="#000000"><g><path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path></g></g></g></svg></div><div style="padding-top: 8px;"> <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this post on Instagram</div></div><div style="padding: 12.5% 0;"></div> <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;"><div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div> <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div></div><div style="margin-left: 8px;"> <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div> <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div></div><div style="margin-left: auto;"> <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div> <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div> <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div></div></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div></div></a><p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/reel/DQMfPKxEhkD/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">A post shared by Perpustakaan PPI Curug (@avialib_ppicurug)</a></p></div></blockquote>
<script async src="//www.instagram.com/embed.js"></script>
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
