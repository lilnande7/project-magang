@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')

<section class="page-hero page-hero--profile">
    <div class="page-hero-content">
        <h1>Profil Perpustakaan</h1>
        <p>Informasi tentang perpustakaan...</p>
    </div>
</section>

<section class="profile-about">
    <div class="profile-about-container">

        <div class="profile-about-text">
            <h2 class="section-title">Sekilas Tentang Perpustakaan</h2>
            <p class="section-desc section-desc--dark">
                Perpustakaan PPIC merupakan unit pendukung akademik yang
                menyediakan berbagai sumber informasi untuk mendukung kegiatan pendidikan, penelitian,
                dan pengabdian kepada masyarakat.
            </p>
            <p class="section-desc section-desc--dark">
                Melalui layanan perpustakaan digital, pengguna dapat
                mengakses koleksi secara cepat, akurat, dan berkelanjutan
                sesuai dengan perkembangan teknologi informasi.
            </p>
        </div>
    </div>
</section>

<section class="visi-misi">
    <div class="visi-misi-container">

        <!-- VISI -->
        <div class="visi-box">
            <div class="visi-overlay"></div>
            <div class="visi-content">
                <h2 class="section-title">Visi</h2>
                <p class="section-desc">
                    Menjadi Pusat Sumber Informasi Penerbangan yang Unggul dalam Mendukung Kebutuhan Akademik dan Profesionalitas Civitas Akademika Politeknik Penerbangan Indonesia Curug.
                </p>
            </div>
        </div>

        <!-- MISI -->
        <div class="misi-box">
            <h2 class="section-title">Misi</h2>
            <ul class="misi-list">
                <li>Menyediakan koleksi literatur yang relevan dan mutakhir untuk mendukung proses belajar-mengajar, penelitian, dan pengabdian masyarakat di lingkungan Politeknik Penerbangan Indonesia Curug.</li>
                <li>Menjadi pusat referensi penyediaan standar dan regulasi penerbangan guna memperkuat budaya keselamatan bagi seluruh civitas akademika.</li>
                <li>Mengembangkan layanan perpustakaan berbasis teknologi informasi yang mandiri dan mudah diakses oleh taruna serta dosen.</li>
                <li>Membangun kolaborasi yang kuat dengan unit kerja di lingkungan Politeknik Penerbangan Indonesia Curug serta mitra industri untuk pengayaan sumber daya informasi.</li>
                
            </ul>
        </div>

    </div>
</section>

@endsection