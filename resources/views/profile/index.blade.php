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
                    Menjadi pusat informasi dan literasi yang unggul,
                    modern, dan mendukung kegiatan akademik civitas PPIC.
                </p>
            </div>
        </div>

        <!-- MISI -->
        <div class="misi-box">
            <h2 class="section-title">Misi</h2>
            <ul class="misi-list">
                <li>Menyediakan koleksi informasi yang relevan dan berkualitas.</li>
                <li>Mendukung kegiatan pendidikan, penelitian, dan pengabdian.</li>
                <li>Mengembangkan layanan perpustakaan berbasis digital.</li>
                <li>Meningkatkan kompetensi literasi civitas akademika.</li>
                <li>Menjalin kerjasama dengan berbagai pihak dalam pengembangan perpustakaan.</li>
            </ul>
        </div>

    </div>
</section>

@endsection