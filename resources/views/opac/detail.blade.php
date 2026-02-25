@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Koleksi</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="book-cover text-center mb-3">
                                <img src="{{ asset('images/perpusumn.jpeg') }}" 
                                     alt="Cover Buku" 
                                     class="img-fluid border"
                                     style="max-height: 300px;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="30%"><strong>Judul</strong></td>
                                    <td>Dasar-dasar Penerbangan</td>
                                </tr>
                                <tr>
                                    <td><strong>Penulis</strong></td>
                                    <td>Dr. Ahmad Wahyudi</td>
                                </tr>
                                <tr>
                                    <td><strong>Tahun Terbit</strong></td>
                                    <td>2023</td>
                                </tr>
                                <tr>
                                    <td><strong>Penerbit</strong></td>
                                    <td>Penerbit Penerbangan Indonesia</td>
                                </tr>
                                <tr>
                                    <td><strong>ISBN</strong></td>
                                    <td>978-602-123-456-7</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Halaman</strong></td>
                                    <td>320 halaman</td>
                                </tr>
                                <tr>
                                    <td><strong>Bahasa</strong></td>
                                    <td>Indonesia</td>
                                </tr>
                                <tr>
                                    <td><strong>Subjek</strong></td>
                                    <td>Penerbangan, Avionik, Teknologi</td>
                                </tr>
                                <tr>
                                    <td><strong>Lokasi</strong></td>
                                    <td>Rak A-1, Lantai 2</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td><span class="badge bg-success">Tersedia</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="mt-4">
                        <h5>Deskripsi</h5>
                        <p class="text-justify">
                            Buku ini membahas dasar-dasar penerbangan yang mencakup prinsip-prinsip 
                            aerodinamika, sistem navigasi, dan teknologi avionik modern. Disusun secara 
                            sistematis untuk mahasiswa dan praktisi di bidang penerbangan. Dilengkapi 
                            dengan ilustrasi, diagram, dan studi kasus yang relevan dengan perkembangan 
                            industri penerbangan terkini.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Peminjaman</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Status:</strong> Buku tersedia untuk dipinjam
                    </div>
                    
                    <div class="mb-3">
                        <strong>Lama Peminjaman:</strong><br>
                        Mahasiswa: 7 hari<br>
                        Dosen/Staff: 14 hari
                    </div>
                    
                    <div class="mb-3">
                        <strong>Denda Keterlambatan:</strong><br>
                        Rp 1.000 per hari
                    </div>
                    
                    <button class="btn btn-primary w-100 mb-2">Reserve Buku</button>
                    <button class="btn btn-outline-secondary w-100">Tambah ke Bookmark</button>
                    
                    <hr>
                    
                    <div class="text-center">
                        <a href="{{ route('opac') }}" class="btn btn-link">
                            <i class="fas fa-arrow-left"></i> Kembali ke Pencarian
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection