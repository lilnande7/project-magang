@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile-pages.css') }}">
@endsection

@section('content')

<section class="page-hero page-hero--akreditasi">
    <div class="page-hero-content">
        <ul class="profile-breadcrumb">
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><span class="sep">/</span></li>
            <li><span class="current">Akreditasi</span></li>
        </ul>
        <h1>Akreditasi Perpustakaan</h1>
        <p>Status dan capaian akreditasi perpustakaan PPIC</p>
    </div>
</section>

<div class="profile-content-section">

    {{-- ============================================
         EDIT BAGIAN INI SESUAI DATA SEBENARNYA
         ============================================ --}}

    <h2>Status Akreditasi</h2>

    <div class="highlight-box">
        <h3><i class="fas fa-award" style="margin-right:8px;"></i> Akreditasi Perpustakaan</h3>
        <p>
            <!-- TODO: Isi status akreditasi terkini -->
            Perpustakaan Politeknik Penerbangan Indonesia Curug telah mendapatkan
            akreditasi dari Perpustakaan Nasional Republik Indonesia.
        </p>
        <p style="font-size:1.4rem;font-weight:700;margin-top:12px;">
            <!-- TODO: Isi peringkat akreditasi -->
            Terakreditasi: <span style="color:#fbbf24;">[Isi Peringkat]</span>
        </p>
    </div>

    <h3>Riwayat Akreditasi</h3>

    <table class="profile-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun</th>
                <th>Lembaga Penilai</th>
                <th>Peringkat</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td><!-- TODO: Isi tahun -->[Tahun]</td>
                <td>Perpustakaan Nasional RI</td>
                <td><!-- TODO: Isi peringkat -->[Peringkat]</td>
                <td><!-- TODO: Isi keterangan -->[No. SK Akreditasi]</td>
            </tr>
            {{-- Tambahkan baris lain jika ada riwayat sebelumnya --}}
        </tbody>
    </table>

    <h3>Standar yang Dinilai</h3>

    <p>Akreditasi perpustakaan perguruan tinggi mengacu pada standar berikut:</p>

    <ul>
        <li><strong>Koleksi</strong> — Kecukupan dan relevansi koleksi bahan pustaka</li>
        <li><strong>Sarana & Prasarana</strong> — Fasilitas ruang baca, perangkat TI, dan infrastruktur</li>
        <li><strong>Pelayanan</strong> — Kualitas layanan sirkulasi, referensi, dan digital</li>
        <li><strong>Tenaga Perpustakaan</strong> — Kompetensi dan kualifikasi SDM</li>
        <li><strong>Penyelenggaraan</strong> — Manajemen, anggaran, dan tata kelola</li>
        <li><strong>Kerjasama</strong> — Jejaring dan kolaborasi antar perpustakaan</li>
    </ul>

    {{-- Sertifikat --}}
    <div class="info-card">
        <h4><i class="fas fa-certificate"></i> Sertifikat Akreditasi</h4>
        <p>
            <!-- TODO: Tambahkan gambar sertifikat jika tersedia -->
            Sertifikat akreditasi dapat dilihat di perpustakaan PPIC atau hubungi
            pustakawan untuk informasi lebih lanjut.
        </p>
    </div>

    {{-- <img src="{{ asset('images/sertifikat-akreditasi.jpg') }}" alt="Sertifikat Akreditasi"> --}}

</div>

@endsection
