@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile-pages.css') }}">
@endsection

@section('content')

<section class="page-hero page-hero--visi-misi">
    <div class="page-hero-content">
        <ul class="profile-breadcrumb">
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><span class="sep">/</span></li>
            <li><span class="current">Visi & Misi</span></li>
        </ul>
        <h1>Visi & Misi</h1>
        <p>Landasan dan arah pengembangan perpustakaan PPIC</p>
    </div>
</section>

<div class="profile-content-section">

    {{-- ============================================
         EDIT BAGIAN INI SESUAI DATA SEBENARNYA
         ============================================ --}}

    {{-- VISI --}}
    <div class="highlight-box">
        <h3><i class="fas fa-eye" style="margin-right:8px;"></i> Visi</h3>
        <p>
            <!-- TODO: Sesuaikan visi jika perlu -->
            Menjadi Pusat Sumber Informasi Penerbangan yang Unggul dalam Mendukung
            Kebutuhan Akademik dan Profesionalitas Civitas Akademika
            Politeknik Penerbangan Indonesia Curug.
        </p>
    </div>

    {{-- MISI --}}
    <h2><i class="fas fa-bullseye" style="color:#1c7ed6;margin-right:8px;"></i> Misi</h2>

    <ol>
        <li>
            <!-- TODO: Sesuaikan misi jika perlu -->
            Menyediakan koleksi literatur yang relevan dan mutakhir untuk mendukung
            proses belajar-mengajar, penelitian, dan pengabdian masyarakat di lingkungan
            Politeknik Penerbangan Indonesia Curug.
        </li>
        <li>
            Menjadi pusat referensi penyediaan standar dan regulasi penerbangan
            guna memperkuat budaya keselamatan bagi seluruh civitas akademika.
        </li>
        <li>
            Mengembangkan layanan perpustakaan berbasis teknologi informasi yang mandiri
            dan mudah diakses oleh taruna serta dosen.
        </li>
        <li>
            Membangun kolaborasi yang kuat dengan unit kerja di lingkungan
            Politeknik Penerbangan Indonesia Curug serta mitra industri untuk
            pengayaan sumber daya informasi.
        </li>
    </ol>

    {{-- TUJUAN --}}
    <h3>Tujuan</h3>

    <ul>
        <li><!-- TODO: Isi tujuan --> Mendukung pelaksanaan tri dharma perguruan tinggi</li>
        <li>Meningkatkan minat baca dan literasi informasi sivitas akademika</li>
        <li>Menyediakan akses informasi yang mudah, cepat, dan akurat</li>
        <li>Mengembangkan layanan perpustakaan digital dan e-resources</li>
    </ul>

    {{-- NILAI-NILAI --}}
    <h3>Nilai-Nilai</h3>

    <div class="info-card">
        <h4><i class="fas fa-star"></i> Nilai Inti Perpustakaan</h4>
        <p>
            <!-- TODO: Sesuaikan dengan nilai inti perpustakaan -->
            <strong>Profesional</strong> — <strong>Inovatif</strong> —
            <strong>Kolaboratif</strong> — <strong>Melayani</strong>
        </p>
    </div>

</div>

@endsection
