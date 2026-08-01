@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile-pages.css') }}">
@endsection

@section('content')

<section class="page-hero page-hero--struktur">
    <div class="page-hero-content">
        <ul class="profile-breadcrumb">
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><span class="sep">/</span></li>
            <li><span class="current">Struktur Organisasi</span></li>
        </ul>
        <h1>Struktur Organisasi</h1>
        <p>Susunan organisasi perpustakaan PPIC</p>
    </div>
</section>

<div class="profile-content-section">

    {{-- ============================================
         EDIT BAGIAN INI SESUAI DATA SEBENARNYA
         ============================================ --}}

    <h2>Struktur Organisasi Perpustakaan PPIC</h2>

    <p>
        Perpustakaan PPIC berada di bawah naungan Politeknik Penerbangan Indonesia Curug,
        Kementerian Perhubungan Republik Indonesia. Berikut adalah susunan organisasi perpustakaan:
    </p>

    {{-- Placeholder bagan organisasi — ganti dengan gambar asli --}}
    <div class="org-chart-placeholder">
        <i class="fas fa-sitemap"></i>
        <p><strong>Bagan Struktur Organisasi</strong></p>
        <p>Letakkan gambar bagan organisasi di sini</p>
        <p style="font-size:.82rem;margin-top:8px;">Ganti placeholder ini dengan:<br>
        <code>&lt;img src="{!! "{{ asset('images/struktur-organisasi.png') }}" !!}" alt="Struktur Organisasi"&gt;</code></p>
    </div>

    <h3>Pimpinan</h3>

    {{-- Ganti data di bawah ini dengan data asli --}}
    <table class="profile-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Jabatan</th>
                <th>Nama</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Kepala Perpustakaan</td>
                <td><!-- TODO: Isi nama -->[Nama Kepala Perpustakaan]</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Pustakawan</td>
                <td><!-- TODO: Isi nama -->[Nama Pustakawan 1]</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Pustakawan</td>
                <td><!-- TODO: Isi nama -->[Nama Pustakawan 2]</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Staff Administrasi</td>
                <td><!-- TODO: Isi nama -->[Nama Staff]</td>
            </tr>
        </tbody>
    </table>

    <h3>Tugas dan Fungsi</h3>

    <div class="info-card">
        <h4><i class="fas fa-tasks"></i> Tugas Pokok</h4>
        <p>
            <!-- TODO: Isi tugas pokok perpustakaan -->
            Melaksanakan pengelolaan perpustakaan yang meliputi pengadaan, pengolahan,
            pelayanan, dan pelestarian bahan pustaka untuk mendukung kegiatan
            tri dharma perguruan tinggi.
        </p>
    </div>

    <ul>
        <li><!-- TODO: Isi fungsi --> Menghimpun dan mengelola koleksi bahan pustaka</li>
        <li>Memberikan layanan informasi kepada sivitas akademika</li>
        <li>Menyelenggarakan kerjasama antar perpustakaan</li>
        <li>Melaksanakan pemeliharaan dan pelestarian bahan pustaka</li>
        <li>Mengelola sistem informasi perpustakaan</li>
    </ul>

</div>

@endsection
