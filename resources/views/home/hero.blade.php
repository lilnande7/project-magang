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
