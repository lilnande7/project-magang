@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile-pages.css') }}">
@endsection

@section('content')

<section class="page-hero page-hero--npp">
    <div class="page-hero-content">
        <ul class="profile-breadcrumb">
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><span class="sep">/</span></li>
            <li><span class="current">Nomor Pokok Perpustakaan</span></li>
        </ul>
        <h1>Nomor Pokok Perpustakaan</h1>
        <p>Identitas resmi perpustakaan PPIC dari Perpusnas RI</p>
    </div>
</section>

<div class="profile-content-section">

    {{-- ============================================
         EDIT BAGIAN INI SESUAI DATA SEBENARNYA
         ============================================ --}}

    <h2>Nomor Pokok Perpustakaan (NPP)</h2>

    <p>
        Nomor Pokok Perpustakaan (NPP) adalah nomor identitas resmi yang diberikan
        oleh Perpustakaan Nasional Republik Indonesia kepada setiap perpustakaan
        yang terdaftar. NPP merupakan bukti bahwa perpustakaan telah terdaftar
        secara resmi dan diakui keberadaannya.
    </p>

    {{-- NPP Badge --}}
    <div style="text-align:center;margin:32px 0;">
        <div class="npp-badge">
            <i class="fas fa-id-badge"></i>
            <!-- TODO: Sesuaikan nomor NPP jika berbeda -->
            3603202C0000001
        </div>
        <p style="color:#888;font-size:.88rem;margin-top:8px;">
            Nomor Pokok Perpustakaan — Perpustakaan PPIC
        </p>
    </div>

    <h3>Informasi NPP</h3>

    <table class="profile-table">
        <thead>
            <tr>
                <th>Keterangan</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Nomor NPP</td>
                <td><strong>3603202C0000001</strong></td>
            </tr>
            <tr>
                <td>Nama Perpustakaan</td>
                <td><!-- TODO: Isi --> Perpustakaan Politeknik Penerbangan Indonesia Curug</td>
            </tr>
            <tr>
                <td>Jenis Perpustakaan</td>
                <td><!-- TODO: Isi --> Perpustakaan Perguruan Tinggi</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td><!-- TODO: Isi --> Jl. Raya PLP Curug, Kec. Legok, Kab. Tangerang, Banten</td>
            </tr>
            <tr>
                <td>Lembaga Induk</td>
                <td>Politeknik Penerbangan Indonesia Curug</td>
            </tr>
            <tr>
                <td>Kementerian</td>
                <td>Kementerian Perhubungan RI</td>
            </tr>
            <tr>
                <td>Diterbitkan oleh</td>
                <td>Perpustakaan Nasional Republik Indonesia</td>
            </tr>
        </tbody>
    </table>

    <div class="info-card">
        <h4><i class="fas fa-info-circle"></i> Tentang NPP</h4>
        <p>
            NPP diterbitkan berdasarkan Undang-Undang Nomor 43 Tahun 2007 tentang
            Perpustakaan dan Peraturan Pemerintah Nomor 24 Tahun 2014 tentang
            Pelaksanaan UU Perpustakaan. Setiap perpustakaan di Indonesia wajib
            memiliki NPP sebagai identitas resmi.
        </p>
    </div>

    {{-- <img src="{{ asset('images/sertifikat-npp.jpg') }}" alt="Sertifikat NPP"> --}}

</div>

@endsection
