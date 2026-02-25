@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/layanan.css') }}">
@endsection

@section('content')

<section class="layanan-hero">
    <div class="layanan-hero-overlay"></div>

    <div class="layanan-hero-content">
        <h1>Layanan & Fasilitas Perpustakaan</h1>
        <p class="hero-subtitle">Layanan Pengunjung</p>
    </div>
</section>

<section class="fasilitas-detail-section">

    <div class="detail-heading">
        <span>Detail Fasilitas</span>
    </div>

    <div class="container">

        <!-- ITEM 1 -->
        <div class="fasilitas-detail">
            <div class="detail-image">
                <img src="{{ asset('images/areabaca.jpeg') }}" alt="Science & Technology">
            </div>

            <div class="detail-content">
                <h3>Science & Technology</h3>
                <p>
                    Fasilitas Science & Technology menyediakan koleksi buku,
                    jurnal, dan referensi di bidang sains dan teknologi
                    untuk mendukung kegiatan akademik.
                </p>

                <ul>
                    <li>Koleksi buku dan referensi teknologi</li>
                    <li>Ruang baca nyaman dan tenang</li>
                    <li>Mendukung kegiatan penelitian</li>
                </ul>
            </div>
        </div>

        <!-- ITEM 2 -->
        <div class="fasilitas-detail reverse">
            <div class="detail-image">
                <img src="{{ asset('images/Hotspotarea.jpeg') }}" alt="Internet Area">
            </div>

            <div class="detail-content">
                <h3>Internet Area</h3>
                <p>
                    Internet Area merupakan fasilitas akses internet
                    yang disediakan untuk menunjang kegiatan belajar
                    dan pencarian informasi digital.
                </p>

                <ul>
                    <li>Akses WiFi stabil</li>
                    <li>Mendukung e-journal dan e-resource</li>
                    <li>Dapat digunakan oleh seluruh pengunjung</li>
                </ul>
            </div>
        </div>

        <!-- ITEM 3 -->
        <div class="fasilitas-detail">
            <div class="detail-image">
                <img src="{{ asset('images/areabaca.jpeg') }}" alt="Hotspot Area">
            </div>

            <div class="detail-content">
                <h3>Hotspot Area</h3>
                <p>
                    Hotspot Area disediakan sebagai area khusus
                    bagi pengunjung untuk mengakses jaringan
                    internet secara mandiri.
                </p>

                <ul>
                    <li>Area nyaman dan tenang</li>
                    <li>Dukungan aktivitas akademik</li>
                    <li>Akses mudah dan fleksibel</li>
                </ul>
            </div>
        </div>

    </div>
</section>

@endsection