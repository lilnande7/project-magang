@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile-pages.css') }}">
@endsection

@section('content')

<section class="page-hero page-hero--sejarah">
    <div class="page-hero-content">
        <ul class="profile-breadcrumb">
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><span class="sep">/</span></li>
            <li><span class="current">Sejarah</span></li>
        </ul>
        <h1>Sejarah Perpustakaan</h1>
        <p>Perjalanan perpustakaan PPIC dari masa ke masa</p>
    </div>
</section>

<div class="profile-content-section">

    {{-- ============================================
         EDIT BAGIAN INI SESUAI DATA SEBENARNYA
         ============================================ --}}

    <h2>Sejarah Berdirinya Perpustakaan PPIC</h2>

    <p>
        Perpustakaan Politeknik Penerbangan Indonesia Curug (PPIC) berdiri bersamaan
        dengan didirikannya Akademi Penerbang Indonesia (API) pada tahun 1952.
        Seiring berkembangnya lembaga pendidikan ini, perpustakaan turut bertransformasi
        untuk memenuhi kebutuhan informasi sivitas akademika.
    </p>

    {{-- Ganti konten di bawah ini dengan data asli --}}

    <h3>Periode Awal (1952 – 1990)</h3>
    <p>
        <!-- TODO: Isi dengan sejarah periode awal perpustakaan -->
        Pada masa awal, perpustakaan masih berupa ruang baca kecil dengan koleksi
        terbatas yang didominasi oleh buku-buku penerbangan dan navigasi udara.
    </p>

    <h3>Periode Pengembangan (1990 – 2010)</h3>
    <p>
        <!-- TODO: Isi dengan sejarah periode pengembangan -->
        Memasuki era modernisasi, perpustakaan mulai mengadopsi sistem katalogisasi
        digital dan memperluas koleksi ke berbagai bidang ilmu pendukung penerbangan.
    </p>

    <h3>Era Digital (2010 – Sekarang)</h3>
    <p>
        <!-- TODO: Isi dengan sejarah era digital -->
        Perpustakaan bertransformasi menjadi pusat sumber informasi digital dengan
        penerapan sistem SLiMS, layanan e-resource, dan portal perpustakaan online.
    </p>

    <div class="info-card">
        <h4><i class="fas fa-info-circle"></i> Tahukah Anda?</h4>
        <p>
            <!-- TODO: Isi dengan fakta menarik tentang perpustakaan -->
            Perpustakaan PPIC saat ini memiliki lebih dari 5.000 koleksi buku, jurnal,
            dan tugas akhir taruna yang dapat diakses melalui sistem OPAC online.
        </p>
    </div>

    {{-- Tambahkan foto sejarah jika tersedia --}}
    {{-- <img src="{{ asset('images/sejarah-perpustakaan.jpg') }}" alt="Foto Sejarah Perpustakaan"> --}}

</div>

@endsection
