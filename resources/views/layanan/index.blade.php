@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/layanan.css?v=' . time()) }}">
@endsection

@section('content')

@php
    $serviceHighlights = [
        [
            'icon' => 'fa-concierge-bell',
            'title' => 'Sirkulasi & Helpdesk',
            'description' => 'Peminjaman, pengembalian, reservasi ruang diskusi, dan asistensi tugas akhir.',
            'items' => [
                'Layanan cepat dengan antrean digital',
                'Pengingat jatuh tempo via email',
                'Helpdesk hybrid (luring & daring)'
            ],
        ],
        [
            'icon' => 'fa-tablet-alt',
            'title' => 'Referensi Digital',
            'description' => 'Akses ke OPAC, e-journal, repository, dan pustaka multimedia sepanjang hari.',
            'items' => [
                'Terhubung ke 25+ database aviasi',
                'Mode baca nyaman di perangkat mobile',
                'Pendampingan sitasi & plagiarism check'
            ],
        ],
        [
            'icon' => 'fa-people-group',
            'title' => 'Program Literasi',
            'description' => 'Workshop, tur fasilitas, dan kelas literasi bagi taruna & sivitas akademika.',
            'items' => [
                'Kelas literasi informasi tematik',
                'Kolaborasi komunitas & instansi',
                'Pameran koleksi langka'
            ],
        ],
    ];

    $facilityDetails = [
        [
            'tag' => 'Science & Technology',
            'title' => 'Zona Riset Teknologi',
            'description' => 'Ruang koleksi sains & teknologi dengan suasana tenang untuk mendukung penelitian, lengkap dengan koleksi print maupun digital.',
            'image' => 'images/areabaca.jpeg',
            'highlights' => [
                'Kurasi buku teknis, manual, dan jurnal terbaru',
                'Ruang baca ergonomis dengan pencahayaan hangat',
                'Cluster diskusi kecil untuk tim riset'
            ],
        ],
        [
            'tag' => 'Internet Area',
            'title' => 'Digital Learning Hub',
            'description' => 'Zona akses cepat untuk mengerjakan tugas, menghadiri kelas daring, atau mengunduh e-resource institusi.',
            'image' => 'images/Hotspotarea.jpeg',
            'highlights' => [
                'WiFi simetris dengan network isolasi aman',
                'Station PC dengan headphone dan webcam',
                'Support teknis on-site oleh pustakawan'
            ],
        ],
        [
            'tag' => 'Hotspot Area',
            'title' => 'Collaborative Lounge',
            'description' => 'Area santai untuk brainstorming, klub literasi, dan temu komunitas dengan akses listrik di setiap meja.',
            'image' => 'images/areabaca.jpeg',
            'highlights' => [
                'Sofa modular dan meja tinggi',
                'Panel akustik untuk menjaga privasi',
                'Colokan dan USB hub di setiap sisi'
            ],
        ],
    ];
@endphp

<section class="page-hero page-hero--layanan">
    
    <div class="layanan-hero-inner">

        <!-- LEFT -->
        <div class="page-hero-content">
            

            <h1>Layanan & Fasilitas Terintegrasi</h1>

            <p>
                Kami menghadirkan kombinasi layanan fisik dan digital agar proses riset,
                belajar, dan kolaborasi terasa lebih intuitif untuk seluruh sivitas
                Politeknik Penerbangan Indonesia Curug.
            </p>

        

</section>


<!-- 
<section class="layanan-hero" id="layananHero">
    <div class="layanan-hero-overlay"></div>
    <div class="layanan-hero-inner">
        <div class="layanan-hero-copy" data-animate="fadeInUp">
            <span class="layanan-pill">Layanan Perpustakaan</span>
            <h1>Layanan & Fasilitas Terintegrasi</h1>
            <p>
                Kami menghadirkan kombinasi layanan fisik dan digital agar proses riset,
                belajar, dan kolaborasi terasa lebih intuitif untuk seluruh sivitas
                Politeknik Penerbangan Indonesia Curug.
            </p>
            <div class="hero-action-group">
                <a href="https://digilib.ppicurug.ac.id" target="_blank" class="btn-hero-primary">Telusuri OPAC</a>
                <a href="{{ route('contact') }}" class="btn-hero-secondary">Reservasi Layanan</a>
            </div>
        </div>

        <div class="layanan-hero-meta" data-animate="fadeInUp" data-delay="200">
            <div class="hero-stat-card">
                <span>Jam Operasional</span>
                <strong>08.00 - 17.00</strong>
                <small>Senin - Jumat</small>
            </div>
            <div class="hero-stat-card">
                <span>Area Fisik</span>
                <strong>7 Zona</strong>
                <small>Ruang riset & kolaborasi</small>
            </div>
            <div class="hero-stat-card">
                <span>Digital Access</span>
                <strong>24/7</strong>
                <small>Repository & e-journal</small>
            </div>
        </div>
    </div>
</section> -->

<section class="services-overview">
    <div class="section-header" data-animate="fadeInUp">
        <span class="section-label">Highlight Layanan</span>
        <h2>Layanan utama yang mendukung pengalaman belajar</h2>
        <p>Kami memakai pola desain yang sama seperti beranda: elegan, responsif, dan penuh kontras.</p>
    </div>

    <div class="service-grid">
        @foreach($serviceHighlights as $index => $service)
        <article class="service-card" data-animate="fadeInUp" data-delay="{{ $index * 120 }}">
            <div class="service-icon">
                <i class="fas {{ $service['icon'] }}"></i>
            </div>
            <h3>{{ $service['title'] }}</h3>
            <p>{{ $service['description'] }}</p>
            <ul>
                @foreach($service['items'] as $item)
                <li><i class="fas fa-check"></i> {{ $item }}</li>
                @endforeach
            </ul>
        </article>
        @endforeach
    </div>
</section>

<section class="experience-section">
    <div class="experience-grid">
        <div class="experience-illustration" data-animate="fadeInLeft">
            <img src="{{ asset('images/perpusumn.jpeg') }}" alt="Workflow layanan perpustakaan">
            <div class="experience-badge">
                <span>Guided Service</span>
                <strong>Personal Librarian</strong>
                <small>Temani proses risetmu secara intensif.</small>
            </div>
        </div>
        <div class="experience-content" data-animate="fadeInRight">
            <span class="section-label">Cara Kami Melayani</span>
            <h2>Pengalaman layanan yang konsisten dari pintu masuk hingga akses digital</h2>
            <p>
                Setiap pengunjung mendapatkan panduan terstruktur, mulai dari orientasi fasilitas,
                pengenalan katalog digital, hingga dukungan literasi informasi yang dapat dijadwalkan.
            </p>
            <div class="experience-list">
                <div>
                    <span>1. Orientation Desk</span>
                    <p>Registrasi, penjelasan zona, dan permintaan pendampingan pustakawan.</p>
                </div>
                <div>
                    <span>2. Discovery Session</span>
                    <p>Kurasi sumber referensi, OPAC, hingga akses database mitra avionik.</p>
                </div>
                <div>
                    <span>3. Collaborative Follow-up</span>
                    <p>Monitoring progres riset, peminjaman alat, dan evaluasi kebutuhan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="facility-detail-section">
    <div class="section-header" data-animate="fadeInUp">
        <span class="section-label">Ruang & Fasilitas</span>
        <h2>Setiap area dirancang untuk fokus yang berbeda</h2>
        <p>Pilih zona yang paling sesuai dengan gaya belajar atau agenda kegiatanmu.</p>
    </div>

    <div class="facility-detail-grid">
        @foreach($facilityDetails as $index => $facility)
        <article class="facility-detail-card {{ $index % 2 !== 0 ? 'reverse' : '' }}" data-animate="fadeInUp" data-delay="{{ $index * 120 }}">
            <div class="facility-image">
                <img src="{{ asset($facility['image']) }}" alt="{{ $facility['tag'] }}">
            </div>
            <div class="facility-body">
                <span class="facility-tag">{{ $facility['tag'] }}</span>
                <h3>{{ $facility['title'] }}</h3>
                <p>{{ $facility['description'] }}</p>
                <ul>
                    @foreach($facility['highlights'] as $point)
                    <li><i class="fas fa-circle"></i> {{ $point }}</li>
                    @endforeach
                </ul>
            </div>
        </article>
        @endforeach
    </div>
</section>

<section class="cta-section" data-animate="fadeInUp">
    <div class="cta-card">
        <div>
            <span class="section-label">Butuh bantuan khusus?</span>
            <h2>Tim pustakawan siap menyiapkan sesi privat untukmu.</h2>
            <p>Reservasi ruang baca, konsultasi literasi, atau dukungan event akademik hanya dalam beberapa klik.</p>
        </div>
        <div class="cta-actions">
            <a href="{{ route('contact') }}" class="btn-hero-primary">Hubungi Kami</a>
            <a href="https://digilib.ppicurug.ac.id" target="_blank" class="btn-hero-secondary">Akses Digital</a>
        </div>
    </div>
</section>

@endsection