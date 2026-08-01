@extends('admin.layout')

@section('title', 'Manajemen Peminjaman')
@section('page-title', 'Manajemen Peminjaman')

@section('content')
<div class="container-fluid p-4">

    <!-- Stats cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3 col-xl">
            <a href="{{ route('admin.borrowings.index', ['status'=>'pending']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100" style="border-left:4px solid #f59e0b !important; border-radius:12px;">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted" style="font-size:.78rem;font-weight:600;">MENUNGGU</div>
                                <div style="font-size:1.8rem;font-weight:800;color:#b45309;">{{ $counts['pending'] }}</div>
                            </div>
                            <div style="background:#fff7ed;border-radius:10px;padding:10px;">
                                <i class="bi bi-clock" style="font-size:1.4rem;color:#f59e0b;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3 col-xl">
            <a href="{{ route('admin.borrowings.index', ['status'=>'active']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100" style="border-left:4px solid #10b981 !important; border-radius:12px;">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted" style="font-size:.78rem;font-weight:600;">AKTIF</div>
                                <div style="font-size:1.8rem;font-weight:800;color:#065f46;">{{ $counts['active'] }}</div>
                            </div>
                            <div style="background:#d1fae5;border-radius:10px;padding:10px;">
                                <i class="bi bi-book" style="font-size:1.4rem;color:#10b981;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3 col-xl">
            <a href="{{ route('admin.borrowings.index', ['status'=>'overdue']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100" style="border-left:4px solid #ef4444 !important; border-radius:12px;">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted" style="font-size:.78rem;font-weight:600;">TERLAMBAT</div>
                                <div style="font-size:1.8rem;font-weight:800;color:#991b1b;">{{ $counts['overdue'] }}</div>
                            </div>
                            <div style="background:#fee2e2;border-radius:10px;padding:10px;">
                                <i class="bi bi-exclamation-triangle" style="font-size:1.4rem;color:#ef4444;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3 col-xl">
            <a href="{{ route('admin.borrowings.index', ['status'=>'returned']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100" style="border-left:4px solid #6b7280 !important; border-radius:12px;">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted" style="font-size:.78rem;font-weight:600;">DIKEMBALIKAN</div>
                                <div style="font-size:1.8rem;font-weight:800;color:#374151;">{{ $counts['returned'] }}</div>
                            </div>
                            <div style="background:#f3f4f6;border-radius:10px;padding:10px;">
                                <i class="bi bi-check-circle" style="font-size:1.4rem;color:#6b7280;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3 col-xl">
            <a href="{{ route('admin.borrowings.index', ['status'=>'rejected']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100" style="border-left:4px solid #8b5cf6 !important; border-radius:12px;">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted" style="font-size:.78rem;font-weight:600;">DITOLAK</div>
                                <div style="font-size:1.8rem;font-weight:800;color:#5b21b6;">{{ $counts['rejected'] }}</div>
                            </div>
                            <div style="background:#ede9fe;border-radius:10px;padding:10px;">
                                <i class="bi bi-x-circle" style="font-size:1.4rem;color:#8b5cf6;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
        <div class="card-body p-3">
            <form class="row g-2" method="GET" action="{{ route('admin.borrowings.index') }}">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Cari nama anggota / judul buku..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending"  {{ request('status')==='pending'  ? 'selected' : '' }}>⏳ Menunggu</option>
                        <option value="active"   {{ request('status')==='active'   ? 'selected' : '' }}>✅ Aktif</option>
                        <option value="overdue"  {{ request('status')==='overdue'  ? 'selected' : '' }}>⚠️ Terlambat</option>
                        <option value="returned" {{ request('status')==='returned' ? 'selected' : '' }}>📦 Dikembalikan</option>
                        <option value="rejected" {{ request('status')==='rejected' ? 'selected' : '' }}>❌ Ditolak</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Cari</button>
                    <a href="{{ route('admin.borrowings.index') }}" class="btn btn-outline-secondary rounded-pill ms-1">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Alert jika ada pending -->
    @if($counts['pending'] > 0 && !request('status'))
    <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center mb-4" style="border-radius:12px;">
        <i class="bi bi-bell-fill me-2 fs-5"></i>
        <div>
            <strong>{{ $counts['pending'] }} permintaan peminjaman</strong> sedang menunggu konfirmasi Anda.
            <a href="{{ route('admin.borrowings.index', ['status'=>'pending']) }}" class="alert-link ms-1">Lihat sekarang →</a>
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Table -->
    <div class="card border-0 shadow-sm" style="border-radius:12px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="borrowTable">
                    <thead style="background:#f8fafd;">
                        <tr>
                            <th class="ps-4" style="border-radius:12px 0 0 0;">#</th>
                            <th>Buku</th>
                            <th>Anggota</th>
                            <th>Tgl Permintaan</th>
                            <th>Status</th>
                            <th>Tenggat</th>
                            <th class="pe-4" style="border-radius:0 12px 0 0;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($borrowings as $b)
                        <tr>
                            <td class="ps-4 text-muted" style="font-size:.8rem;">{{ $b->id }}</td>
                            <td>
                                <div style="font-weight:600;font-size:.9rem;max-width:220px;" class="text-truncate"
                                     title="{{ $b->book->title }}">
                                    {{ $b->book->title }}
                                </div>
                                <div style="font-size:.78rem;color:#888;">{{ $b->book->author }}</div>
                            </td>
                            <td>
                                <div style="font-weight:600;font-size:.88rem;">{{ $b->user->name }}</div>
                                <div style="font-size:.78rem;color:#888;">{{ $b->user->email }}</div>
                            </td>
                            <td style="font-size:.85rem;">
                                {{ $b->requested_at?->format('d M Y') ?? $b->created_at->format('d M Y') }}
                            </td>
                            <td>
                                @php
                                    $badgeMap = [
                                        'pending'  => 'bg-warning text-dark',
                                        'active'   => 'bg-success',
                                        'overdue'  => 'bg-danger',
                                        'returned' => 'bg-secondary',
                                        'rejected' => 'bg-danger bg-opacity-50',
                                    ];
                                    $labelMap = [
                                        'pending'  => '⏳ Menunggu',
                                        'active'   => '✅ Aktif',
                                        'overdue'  => '⚠️ Terlambat',
                                        'returned' => '📦 Dikembalikan',
                                        'rejected' => '❌ Ditolak',
                                    ];
                                @endphp
                                <span class="badge rounded-pill {{ $badgeMap[$b->status] ?? 'bg-secondary' }} px-2 py-1">
                                    {{ $labelMap[$b->status] ?? $b->status }}
                                </span>
                            </td>
                            <td style="font-size:.85rem;">
                                @if($b->due_date)
                                    <span class="{{ $b->is_overdue ? 'text-danger fw-bold' : '' }}">
                                        {{ $b->due_date->format('d M Y') }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="pe-4">
                                <a href="{{ route('admin.borrowings.show', $b) }}"
                                   class="btn btn-sm btn-outline-primary rounded-pill me-1">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if($b->status === 'pending')
                                <!-- Quick approve button -->
                                <button class="btn btn-sm btn-success rounded-pill me-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#approveModal{{ $b->id }}">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                                <!-- Quick reject button -->
                                <button class="btn btn-sm btn-outline-danger rounded-pill"
                                        data-bs-toggle="modal"
                                        data-bs-target="#rejectModal{{ $b->id }}">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                                @endif

                                @if(in_array($b->status, ['active','overdue']))
                                <form action="{{ route('admin.borrowings.return', $b) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Tandai buku ini sudah dikembalikan?')">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-secondary rounded-pill">
                                        <i class="bi bi-box-arrow-in-down"></i> Kembalikan
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>

                        {{-- Approve Modal --}}
                        @if($b->status === 'pending')
                        <div class="modal fade" id="approveModal{{ $b->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content" style="border-radius:16px;">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title text-success">
                                            <i class="bi bi-check-circle me-2"></i>Setujui Peminjaman
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.borrowings.approve', $b) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="alert alert-light border mb-3" style="border-radius:10px;">
                                                <strong>{{ $b->book->title }}</strong><br>
                                                <small class="text-muted">Peminjam: {{ $b->user->name }}</small>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Durasi Peminjaman (hari)</label>
                                                <input type="number" name="due_days" class="form-control"
                                                       value="14" min="1" max="60" required>
                                                <div class="form-text">Tenggat = hari ini + durasi yang dipilih</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Catatan (opsional)</label>
                                                <textarea name="notes" class="form-control" rows="2"
                                                          placeholder="Pesan dari pustakawan..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-outline-secondary rounded-pill"
                                                    data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success rounded-pill px-4">
                                                <i class="bi bi-check-lg me-1"></i> Setujui
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Reject Modal --}}
                        <div class="modal fade" id="rejectModal{{ $b->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content" style="border-radius:16px;">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title text-danger">
                                            <i class="bi bi-x-circle me-2"></i>Tolak Permintaan
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.borrowings.reject', $b) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="alert alert-light border mb-3" style="border-radius:10px;">
                                                <strong>{{ $b->book->title }}</strong><br>
                                                <small class="text-muted">Peminjam: {{ $b->user->name }}</small>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Alasan Penolakan <span class="text-danger">*</span></label>
                                                <textarea name="rejection_reason" class="form-control" rows="3"
                                                          placeholder="Contoh: Buku sedang dalam perbaikan, stok habis, dll."
                                                          required maxlength="500"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-outline-secondary rounded-pill"
                                                    data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                                <i class="bi bi-x-lg me-1"></i> Tolak Permintaan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif

                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Tidak ada data peminjaman ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($borrowings->hasPages())
        <div class="card-footer bg-transparent d-flex justify-content-center py-3">
            {{ $borrowings->withQueryString()->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
