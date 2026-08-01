@extends('layouts.app')

@section('title', $book->title . ' — Perpustakaan PPIC')

@section('css')
<style>
/* === DETAIL BUKU === */
.detail-hero {
    background: linear-gradient(135deg,#0f172a 0%,#1e3a5f 60%,#1c7ed6 100%);
    padding: 50px 0 40px;
}
.detail-hero .breadcrumb-item a { color: rgba(255,255,255,.7); }
.detail-hero .breadcrumb-item.active { color: #fff; }
.detail-hero .breadcrumb-separator { color: rgba(255,255,255,.5); }

.book-detail-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 8px 40px rgba(0,0,0,.1);
    overflow: hidden;
}
.book-cover-wrap {
    background: linear-gradient(135deg,#e8f4fd,#cfe2f3);
    display: flex; align-items: center; justify-content: center;
    min-height: 400px; padding: 24px;
}
.book-cover-wrap img {
    max-height: 380px; max-width: 100%;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,.2);
}
.book-cover-placeholder {
    font-size: 6rem; color: #7db8e0; text-align: center;
}
.book-info-wrap { padding: 36px; }
.book-info-wrap h2 {
    font-size: 1.7rem; font-weight: 800; color: #1e3a5f; line-height: 1.3;
    margin-bottom: 6px;
}
.book-author-line { font-size: 1rem; color: #555; margin-bottom: 16px; }
.book-author-line strong { color: #1c7ed6; }

.status-badge-lg {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 6px 16px; border-radius: 50px; font-size: .9rem; font-weight: 700;
    margin-bottom: 20px;
}
.status-available  { background: #d1fae5; color: #065f46; }
.status-borrowed   { background: #fee2e2; color: #991b1b; }
.status-maintenance{ background: #fef3c7; color: #92400e; }

.meta-grid { display: grid; grid-template-columns: auto 1fr; gap: 8px 16px; margin-bottom: 20px; }
.meta-label { font-size: .82rem; font-weight: 600; color: #888; white-space: nowrap; }
.meta-value { font-size: .88rem; color: #333; }

.desc-box {
    background: #f8fafd; border-radius: 12px; padding: 16px 20px;
    border-left: 4px solid #1c7ed6; margin-bottom: 20px;
}
.desc-box h6 { font-weight: 700; color: #1e3a5f; margin-bottom: 8px; }
.desc-box p  { font-size: .9rem; color: #555; margin: 0; line-height: 1.7; }

/* Borrow form */
.borrow-box {
    border: 2px solid #1c7ed6; border-radius: 16px; padding: 24px;
    background: #f0f7ff; margin-top: 8px;
}
.borrow-box h5 { font-weight: 700; color: #1e3a5f; margin-bottom: 16px; }
.btn-borrow {
    background: linear-gradient(135deg,#1c7ed6,#1565b8);
    color: #fff; border: none; border-radius: 50px;
    padding: 12px 32px; font-size: 1rem; font-weight: 700;
    width: 100%; transition: all .25s;
}
.btn-borrow:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(28,126,214,.4); }
.btn-borrow:disabled { opacity: .6; cursor: not-allowed; }

.alert-pending {
    background: #fff7ed; border: 1.5px solid #f59e0b; border-radius: 12px;
    padding: 14px 18px; color: #92400e;
}
.alert-login-prompt {
    background: #eff6ff; border: 1.5px solid #1c7ed6; border-radius: 12px;
    padding: 14px 18px; color: #1e3a5f;
}

/* Related books */
.related-card {
    border-radius: 12px; border: 1px solid #e9ecef; overflow: hidden;
    transition: transform .2s; display: flex; flex-direction: column;
}
.related-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,.08); }
.related-card img {
    width: 100%; height: 150px; object-fit: cover;
    background: #e8f4fd;
}
.related-card-placeholder {
    width: 100%; height: 150px; display: flex;
    align-items: center; justify-content: center;
    background: linear-gradient(135deg,#e8f4fd,#cfe2f3);
    color: #7db8e0; font-size: 2.5rem;
}
.related-card-body { padding: 12px; flex: 1; }
.related-title {
    font-size: .85rem; font-weight: 700; color: #1e3a5f;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden; margin-bottom: 4px;
}
</style>
@endsection

@section('content')
<!-- Hero breadcrumb -->
<div class="detail-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Katalog</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($book->title, 40) }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container" style="padding:40px 0 60px;">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="fa fa-exclamation-triangle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Main Detail -->
    <div class="book-detail-card mb-5">
        <div class="row g-0">
            <!-- Cover -->
            <div class="col-md-4">
                <div class="book-cover-wrap">
                    @if($book->cover_url)
                        <img src="https://digilib.ppicurug.ac.id/images/docs/{{ $book->cover_url }}"
                             alt="{{ $book->title }}"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                        <div class="book-cover-placeholder" style="display:none;">
                            <i class="fa fa-book"></i>
                        </div>
                    @elseif($book->cover_image)
                        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}">
                    @else
                        <div class="book-cover-placeholder">
                            <div>
                                <i class="fa fa-book d-block mb-2"></i>
                                <div style="font-size:.9rem;font-weight:600;">Perpustakaan PPIC</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Info -->
            <div class="col-md-8">
                <div class="book-info-wrap">
                    @if($book->category)
                    <span class="badge mb-2 px-2 py-1" style="background:#e8f4fd;color:#1c7ed6;font-size:.78rem;border-radius:6px;">
                        {{ $book->category->name }}
                    </span>
                    @endif

                    <h2>{{ $book->title }}</h2>
                    <div class="book-author-line">
                        oleh <strong>{{ $book->author }}</strong>
                    </div>

                    <!-- Status -->
                    @php
                        $statusClass = match($book->status) {
                            'available'   => 'status-available',
                            'borrowed'    => 'status-borrowed',
                            'maintenance' => 'status-maintenance',
                            default       => 'status-maintenance',
                        };
                        $statusIcon = match($book->status) {
                            'available'   => 'fa-check-circle',
                            'borrowed'    => 'fa-times-circle',
                            default       => 'fa-exclamation-circle',
                        };
                        $statusText = match($book->status) {
                            'available'   => 'Tersedia untuk Dipinjam',
                            'borrowed'    => 'Sedang Dipinjam',
                            'maintenance' => 'Sedang dalam Perawatan',
                            default       => 'Tidak Tersedia',
                        };
                    @endphp
                    <div class="status-badge-lg {{ $statusClass }}">
                        <i class="fa {{ $statusIcon }}"></i> {{ $statusText }}
                        <span style="font-weight:400;font-size:.8rem;">(Stok: {{ $book->stock }})</span>
                    </div>

                    <!-- Meta grid -->
                    <div class="meta-grid">
                        @if($book->isbn)
                            <span class="meta-label">ISBN / ISSN</span>
                            <span class="meta-value">{{ $book->isbn }}</span>
                        @endif
                        @if($book->publisher)
                            <span class="meta-label">Penerbit</span>
                            <span class="meta-value">{{ $book->publisher }}{{ $book->place_name ? " — $book->place_name" : '' }}</span>
                        @endif
                        @if($book->year)
                            <span class="meta-label">Tahun Terbit</span>
                            <span class="meta-value">{{ $book->year }}</span>
                        @endif
                        @if($book->gmd_name)
                            <span class="meta-label">Jenis</span>
                            <span class="meta-value">{{ $book->gmd_name }}</span>
                        @endif
                        @if($book->collation)
                            <span class="meta-label">Deskripsi Fisik</span>
                            <span class="meta-value">{{ $book->collation }}</span>
                        @endif
                        @if($book->call_number)
                            <span class="meta-label">No. Panggil</span>
                            <span class="meta-value font-monospace">{{ $book->call_number }}</span>
                        @endif
                        @if($book->classification)
                            <span class="meta-label">Klasifikasi</span>
                            <span class="meta-value">{{ $book->classification }}</span>
                        @endif
                        @if($book->language)
                            <span class="meta-label">Bahasa</span>
                            <span class="meta-value">{{ $book->language }}</span>
                        @endif
                        @if($book->series_title)
                            <span class="meta-label">Seri</span>
                            <span class="meta-value">{{ $book->series_title }}</span>
                        @endif
                        @if($book->topics)
                            <span class="meta-label">Topik</span>
                            <span class="meta-value">{{ $book->topics }}</span>
                        @endif
                        @if($book->location)
                            <span class="meta-label">Lokasi Rak</span>
                            <span class="meta-value">{{ $book->location }}</span>
                        @endif
                    </div>

                    @if($book->description)
                    <div class="desc-box">
                        <h6><i class="fa fa-align-left me-1"></i> Deskripsi / Catatan</h6>
                        <p>{{ $book->description }}</p>
                    </div>
                    @endif

                    <!-- BORROW SECTION -->
                    @auth
                        @if($userBorrowing)
                            @if($userBorrowing->status === 'pending')
                            <div class="alert-pending">
                                <i class="fa fa-clock-o me-1"></i>
                                <strong>Permintaan Anda sedang diproses.</strong>
                                Pustakawan akan segera mengonfirmasi peminjaman ini.
                                <form action="{{ route('catalog.cancel', $userBorrowing) }}" method="POST"
                                      class="mt-2" onsubmit="return confirm('Batalkan permintaan peminjaman ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill">
                                        <i class="fa fa-times me-1"></i> Batalkan Permintaan
                                    </button>
                                </form>
                            </div>
                            @else
                            <div class="alert-pending" style="background:#d1fae5;border-color:#34d399;color:#065f46;">
                                <i class="fa fa-check-circle me-1"></i>
                                <strong>Anda sedang meminjam buku ini.</strong>
                                Tenggat pengembalian: <strong>{{ $userBorrowing->due_date?->format('d M Y') ?? '-' }}</strong>
                            </div>
                            @endif
                        @elseif($book->status === 'available' || $book->stock > 0)
                        <div class="borrow-box">
                            <h5><i class="fa fa-book me-2"></i>Ajukan Peminjaman</h5>
                            <form action="{{ route('catalog.borrow', $book) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="font-size:.88rem;">
                                        Catatan / Keperluan (opsional)
                                    </label>
                                    <textarea name="notes" class="form-control" rows="2"
                                              placeholder="Contoh: untuk keperluan tugas akhir..."
                                              maxlength="500"></textarea>
                                </div>
                                <div class="alert alert-info py-2 px-3 mb-3" style="font-size:.83rem;border-radius:10px;">
                                    <i class="fa fa-info-circle me-1"></i>
                                    Permintaan akan diverifikasi pustakawan sebelum disetujui. Maksimal 3 buku aktif/diproses.
                                </div>
                                <button type="submit" class="btn-borrow">
                                    <i class="fa fa-paper-plane me-2"></i> Kirim Permintaan Peminjaman
                                </button>
                            </form>
                        </div>
                        @else
                        <div class="alert-login-prompt">
                            <i class="fa fa-exclamation-circle me-1"></i>
                            Buku ini sedang tidak tersedia. Cek kembali nanti atau cari buku lain di katalog.
                        </div>
                        @endif
                    @else
                        <div class="alert-login-prompt">
                            <i class="fa fa-lock me-2"></i>
                            <strong>Login diperlukan</strong> untuk meminjam buku.
                            <a href="{{ route('login') }}" class="btn btn-sm ms-2"
                               style="background:#1c7ed6;color:#fff;border-radius:20px;">
                                Login Sekarang
                            </a>
                        </div>
                    @endauth

                    <div class="mt-3">
                        <a href="{{ route('catalog.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                            <i class="fa fa-arrow-left me-1"></i> Kembali ke Katalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Books -->
    @if($relatedBooks->isNotEmpty())
    <h5 style="font-weight:700;color:#1e3a5f;" class="mb-3">
        <i class="fa fa-books me-2"></i> Koleksi Terkait
    </h5>
    <div class="row row-cols-2 row-cols-md-4 g-3">
        @foreach($relatedBooks as $rel)
        <div class="col">
            <div class="related-card shadow-sm">
                @if($rel->cover_url)
                    <img src="https://digilib.ppicurug.ac.id/images/docs/{{ $rel->cover_url }}"
                         alt="{{ $rel->title }}"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="related-card-placeholder" style="display:none;"><i class="fa fa-book"></i></div>
                @else
                    <div class="related-card-placeholder"><i class="fa fa-book"></i></div>
                @endif
                <div class="related-card-body">
                    <div class="related-title">{{ $rel->title }}</div>
                    <div style="font-size:.78rem;color:#888;">{{ $rel->author }}</div>
                    <a href="{{ route('catalog.show', $rel) }}" class="btn btn-sm mt-2"
                       style="background:#1c7ed6;color:#fff;border-radius:8px;font-size:.78rem;">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection
