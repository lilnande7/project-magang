@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile-pages.css') }}">
@endsection

@section('content')

<section class="page-hero page-hero--tata-tertib">
    <div class="page-hero-content">
        <ul class="profile-breadcrumb">
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><span class="sep">/</span></li>
            <li><span class="current">Tata Tertib</span></li>
        </ul>
        <h1>Tata Tertib Perpustakaan</h1>
        <p>Peraturan dan ketentuan penggunaan perpustakaan PPIC</p>
    </div>
</section>

<div class="profile-content-section">

    {{-- ============================================
         EDIT BAGIAN INI SESUAI DATA SEBENARNYA
         ============================================ --}}

    <h2>Tata Tertib Pengunjung Perpustakaan PPIC</h2>

    <p>
        Setiap pengunjung perpustakaan wajib mematuhi tata tertib berikut demi
        kenyamanan dan ketertiban bersama:
    </p>

    {{-- ATURAN UMUM --}}
    <h3>A. Aturan Umum</h3>

    <ul class="rule-list">
        <li><!-- TODO: Sesuaikan aturan --> Pengunjung wajib menitipkan tas dan barang bawaan di loker yang telah disediakan.</li>
        <li>Menjaga ketenangan dan ketertiban di dalam ruang perpustakaan.</li>
        <li>Dilarang membawa makanan dan minuman ke dalam ruang baca.</li>
        <li>Dilarang merokok di area perpustakaan.</li>
        <li>Berpakaian rapi dan sopan.</li>
        <li>Dilarang menggunakan fasilitas perpustakaan untuk kepentingan yang tidak berkaitan dengan akademik.</li>
        <li>Menjaga kebersihan dan keutuhan koleksi perpustakaan.</li>
        <li>Mematikan atau mengubah mode telepon genggam ke mode senyap.</li>
    </ul>

    {{-- ATURAN PEMINJAMAN --}}
    <h3>B. Ketentuan Peminjaman</h3>

    <table class="profile-table">
        <thead>
            <tr>
                <th>Ketentuan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Jumlah Buku Maksimal</td>
                <td><!-- TODO: Isi --> 3 (tiga) buku per peminjaman</td>
            </tr>
            <tr>
                <td>Durasi Peminjaman</td>
                <td><!-- TODO: Isi --> 7 (tujuh) hari kalender</td>
            </tr>
            <tr>
                <td>Perpanjangan</td>
                <td><!-- TODO: Isi --> Dapat diperpanjang 1x dengan mengunjungi perpustakaan</td>
            </tr>
            <tr>
                <td>Denda Keterlambatan</td>
                <td><!-- TODO: Isi --> Rp 1.000 per hari per buku</td>
            </tr>
            <tr>
                <td>Buku Referensi</td>
                <td><!-- TODO: Isi --> Hanya boleh dibaca di tempat, tidak boleh dipinjam</td>
            </tr>
            <tr>
                <td>Buku Hilang / Rusak</td>
                <td><!-- TODO: Isi --> Wajib mengganti dengan buku yang sama atau membayar sesuai harga buku</td>
            </tr>
        </tbody>
    </table>

    {{-- SANKSI --}}
    <h3>C. Sanksi</h3>

    <div class="info-card" style="border-left-color:#ef4444;">
        <h4><i class="fas fa-exclamation-triangle" style="color:#ef4444;"></i> Pelanggaran & Sanksi</h4>
        <p>
            <!-- TODO: Sesuaikan dengan sanksi resmi -->
            Pelanggaran terhadap tata tertib dapat mengakibatkan pencabutan hak
            keanggotaan perpustakaan dan/atau sanksi administratif lainnya sesuai
            peraturan yang berlaku di Politeknik Penerbangan Indonesia Curug.
        </p>
    </div>

    {{-- JAM OPERASIONAL --}}
    <h3>D. Jam Operasional</h3>

    <table class="profile-table">
        <thead>
            <tr>
                <th>Hari</th>
                <th>Jam Buka</th>
                <th>Jam Tutup</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Senin – Kamis</td>
                <td><!-- TODO: Isi --> 08.00 WIB</td>
                <td><!-- TODO: Isi --> 16.00 WIB</td>
            </tr>
            <tr>
                <td>Jumat</td>
                <td>08.00 WIB</td>
                <td>16.30 WIB</td>
            </tr>
            <tr>
                <td>Sabtu – Minggu</td>
                <td colspan="2" style="text-align:center;color:#888;">Tutup</td>
            </tr>
        </tbody>
    </table>

</div>

@endsection
