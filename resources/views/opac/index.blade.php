@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h2 class="mb-4 fw-bold">OPAC - Pencarian Koleksi</h2>

    <div class="card p-4 mb-4">
        <form method="get" action="{{ route('opac') }}" class="row g-3 search-box">
            
            <div class="col-md-4">
                <label class="form-label">Kata Kunci</label>
                <input type="text" name="q" value="{{ request('q') }}" 
                       class="form-control" placeholder="Cari judul atau penulis...">
            </div>

            <div class="col-md-3">
                <label class="form-label">Jurusan</label>
                <select name="jurusan" class="form-select">
                    <option value="">Semua Jurusan</option>
                    <option value="D III TPU">D III Teknik Penerbangan Udara</option>
                    <option value="D III TBU">D III Teknik Bangunan dan Bandar Udara</option>
                    <option value="D III EAU">D III Elektronika Bandar Udara</option>
                    <option value="D III KPU">D III Keselamatan Penerbangan Udara</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Urutan</label>
                <select name="sort" class="form-select">
                    <option value="title_asc">Judul A-Z</option>
                    <option value="title_desc">Judul Z-A</option>
                    <option value="year_desc">Tahun Terbaru</option>
                    <option value="year_asc">Tahun Terlama</option>
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <strong>Hasil Pencarian Koleksi</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="45%">Judul</th>
                            <th width="25%">Penulis</th>
                            <th width="15%">Tahun</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <a href="{{ route('opac.detail', 1) }}" class="fw-bold text-decoration-none">
                                    Dasar-dasar Penerbangan
                                </a>
                            </td>
                            <td>Dr. Ahmad Wahyudi</td>
                            <td>2023</td>
                            <td>
                                <a href="{{ route('opac.detail', 1) }}" class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>
                                <a href="{{ route('opac.detail', 2) }}" class="fw-bold text-decoration-none">
                                    Teknologi Avionik Modern
                                </a>
                            </td>
                            <td>Prof. Budi Santoso</td>
                            <td>2022</td>
                            <td>
                                <a href="{{ route('opac.detail', 2) }}" class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>
                                <a href="{{ route('opac.detail', 3) }}" class="fw-bold text-decoration-none">
                                    Keselamatan Penerbangan
                                </a>
                            </td>
                            <td>Ir. Siti Nurhaliza</td>
                            <td>2021</td>
                            <td>
                                <a href="{{ route('opac.detail', 3) }}" class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3 text-center">
        <p class="text-muted">Menampilkan 3 dari 150 koleksi</p>
    </div>

</div>

@endsection