@extends('layouts.app')
@section('title', 'Riwayat Peminjaman Saya — Perpustakaan PPIC')

@section('css')
<style>
.page-hero {
    background: linear-gradient(135deg,#0f172a 0%,#1e3a5f 60%,#1c7ed6 100%);
    padding: 50px 0 40px; color: #fff;
}
.page-hero h1 { font-size: 2rem; font-weight: 700; }
.borrow-card {
    background: #fff; border-radius: 16px; border: 1px solid #e9ecef;
    padding: 20px; margin-bottom: 16px; transition: box-shadow .2s;
}
.borrow-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.08); }
.borrow-cover {
    width: 70px; height: 90px; object-fit: cover; border-radius: 8px;
    background: #e8f4fd; flex-shrink: 0;
}
.borrow-cover-placeholder {
    width: 70px; height: 90px; border-radius: 8px;
    background: linear-gradient(135deg,#e8f4fd,#cfe2f3);
    display: flex; align-items: center; justify-content: center;
    color: #7db8e0; font-size: 1.8rem; flex-shrink: 0;
}
.status-pill {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 4px 12px; border-radius: 50px; font-size: .78rem; font-weight: 700;
}
.s-pending   { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }
.s-active    { background: #d1fae5; color: #065f46; }
.s-overdue   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
.s-returned  { background: #f3f4f6; color: #374151; }
.s-rejected  { background: #fee2e2; color: #7f1d1d; }
.borrow-title { font-weight: 700; color: #1e3a5f; font-size: 1rem; margin-bottom: 2px; }
.borrow-meta  { font-size: .82rem; color: #666; }
.empty-state  { text-align: center; padding: 60px 20px; }
.empty-state i { font-size: 4rem; color: #ccc; margin-bottom: 16px; display: block; }
</style>
@endsection

@section('content')
<div class="page-hero">
    <div class="container">
        <div class="d-flex align-items-center gap-3 mb-2">
            <a href="{{ route('catalog.index') }}" style="color:rgba(255,255,255,.7);">
                <i class="fa fa-arrow-left"></i> Katalog
            </a>
        </div>
        <h1><i class="fa fa-history me-2"></i> Riwayat Peminjaman Saya</h1>
        <p style="color:rgba(255,255,255,.7);">Daftar semua permintaan dan peminjaman buku Anda</p>
    </div>
</div>

<div class="container" style="padding: 40px 0 60px;">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4">
        <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($borrowings->isEmpty())
    <div class="empty-state">
        <i class="fa fa-book"></i>
        <h5 class="text-muted">Belum ada riwayat peminjaman</h5>
        <p class="text-muted">Temukan buku yang ingin Anda pinjam di katalog perpustakaan</p>
        <a href="{{ route('catalog.index') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fa fa-search me-2"></i> Jelajahi Katalog
        </a>
    </div>
    @else

    <!-- Summary pills -->
    @php
        $grouped = $borrowings->groupBy('status');
    @endphp
    <div class="d-flex flex-wrap gap-2 mb-4">
        <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
            Menunggu: {{ $grouped->get('pending', collect())->count() }}
        </span>
        <span class="badge rounded-pill bg-success px-3 py-2">
            Aktif: {{ $grouped->get('active', collect())->count() }}
        </span>
        <span class="badge rounded-pill bg-danger px-3 py-2">
            Terlambat: {{ $grouped->get('overdue', collect())->count() }}
        </span>
        <span class="badge rounded-pill bg-secondary px-3 py-2">
            Dikembalikan: {{ $grouped->get('returned', collect())->count() }}
        </span>
    </div>

    @foreach($borrowings as $borrow)
    <div class="borrow-card">
        <div class="d-flex gap-3 align-items-start">
            <!-- Cover -->
            @if($borrow->book->cover_url)
                <img src="https://digilib.ppicurug.ac.id/images/docs/{{ $borrow->book->cover_url }}"
                     class="borrow-cover"
                     alt="{{ $borrow->book->title }}"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                <div class="borrow-cover-placeholder" style="display:none;"><i class="fa fa-book"></i></div>
            @else
                <div class="borrow-cover-placeholder"><i class="fa fa-book"></i></div>
            @endif

            <!-- Info -->
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div>
                        <div class="borrow-title">{{ $borrow->book->title }}</div>
                        <div class="borrow-meta">oleh {{ $borrow->book->author }}</div>
                        @if($borrow->book->publisher)
                        <div class="borrow-meta">{{ $borrow->book->publisher }}{{ $borrow->book->year ? ' · ' . $borrow->book->year : '' }}</div>
                        @endif
                    </div>
                    @php
                        $sClass = match($borrow->status) {
                            'pending'  => 's-pending',
                            'active'   => 's-active',
                            'overdue'  => 's-overdue',
                            'returned' => 's-returned',
                            'rejected' => 's-rejected',
                            default    => 's-returned',
                        };
                        $sIcon = match($borrow->status) {
                            'pending'  => 'fa-clock-o',
                            'active'   => 'fa-check-circle',
                            'overdue'  => 'fa-exclamation-circle',
                            'returned' => 'fa-check',
                            'rejected' => 'fa-times-circle',
                            default    => 'fa-question',
                        };
                        $sLabel = match($borrow->status) {
                            'pending'  => 'Menunggu Konfirmasi',
                            'active'   => 'Sedang Dipinjam',
                            'overdue'  => 'Terlambat Dikembalikan',
                            'returned' => 'Sudah Dikembalikan',
                            'rejected' => 'Ditolak',
                            default    => $borrow->status,
                        };
                    @endphp
                    <span class="status-pill {{ $sClass }}">
                        <i class="fa {{ $sIcon }}"></i> {{ $sLabel }}
                    </span>
                </div>

                <div class="mt-2 d-flex flex-wrap gap-3" style="font-size:.82rem;color:#555;">
                    <span><i class="fa fa-calendar me-1"></i>
                        Diminta: {{ $borrow->requested_at?->format('d M Y') ?? $borrow->created_at->format('d M Y') }}
                    </span>
                    @if($borrow->borrowed_at)
                    <span><i class="fa fa-sign-out me-1"></i>
                        Dipinjam: {{ $borrow->borrowed_at->format('d M Y') }}
                    </span>
                    @endif
                    @if($borrow->due_date && in_array($borrow->status, ['active','overdue']))
                    <span class="{{ $borrow->is_overdue ? 'text-danger fw-bold' : '' }}">
                        <i class="fa fa-clock-o me-1"></i>
                        Tenggat: {{ $borrow->due_date->format('d M Y') }}
                        @if($borrow->is_overdue)
                            ({{ $borrow->days_overdue }} hari terlambat)
                        @endif
                    </span>
                    @endif
                    @if($borrow->returned_at)
                    <span><i class="fa fa-check me-1"></i>
                        Dikembalikan: {{ $borrow->returned_at->format('d M Y') }}
                    </span>
                    @endif
                </div>

                @if($borrow->notes)
                <div class="mt-1" style="font-size:.82rem;color:#888;">
                    <i class="fa fa-comment-o me-1"></i> {{ $borrow->notes }}
                </div>
                @endif

                @if($borrow->status === 'rejected' && $borrow->rejection_reason)
                <div class="mt-2 p-2 rounded" style="background:#fee2e2;font-size:.82rem;color:#991b1b;">
                    <i class="fa fa-times-circle me-1"></i>
                    <strong>Alasan ditolak:</strong> {{ $borrow->rejection_reason }}
                </div>
                @endif

                @if($borrow->fine_amount > 0)
                <div class="mt-2 p-2 rounded" style="background:#fef3c7;font-size:.82rem;color:#92400e;">
                    <i class="fa fa-exclamation-triangle me-1"></i>
                    <strong>Denda:</strong> Rp {{ number_format($borrow->fine_amount, 0, ',', '.') }}
                </div>
                @endif

                <div class="mt-2 d-flex gap-2">
                    <a href="{{ route('catalog.show', $borrow->book) }}"
                       class="btn btn-sm btn-outline-primary rounded-pill" style="font-size:.8rem;">
                        <i class="fa fa-eye me-1"></i> Lihat Buku
                    </a>
                    @if($borrow->status === 'pending')
                    <form action="{{ route('catalog.cancel', $borrow) }}" method="POST"
                          onsubmit="return confirm('Batalkan permintaan ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger rounded-pill" style="font-size:.8rem;">
                            <i class="fa fa-times me-1"></i> Batalkan
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="d-flex justify-content-center mt-3">
        {{ $borrowings->links() }}
    </div>
    @endif
</div>
@endsection
