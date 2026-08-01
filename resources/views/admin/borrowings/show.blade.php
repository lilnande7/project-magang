@extends('admin.layout')
@section('title', 'Detail Peminjaman #' . $borrowing->id)
@section('page-title', 'Detail Peminjaman')

@section('content')
<div class="container-fluid p-4">
    <div class="mb-3">
        <a href="{{ route('admin.borrowings.index') }}" class="btn btn-outline-secondary rounded-pill btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row g-4">
        <!-- LEFT: Buku -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
                <div class="card-header border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold text-muted mb-0"><i class="bi bi-book me-2"></i>INFORMASI BUKU</h6>
                </div>
                <div class="card-body px-4">
                    <div class="d-flex gap-3 mb-3">
                        @if($borrowing->book->cover_url)
                            <img src="https://digilib.ppicurug.ac.id/images/docs/{{ $borrowing->book->cover_url }}"
                                 style="width:80px;height:110px;object-fit:cover;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,.15);"
                                 alt="{{ $borrowing->book->title }}"
                                 onerror="this.style.display='none'">
                        @else
                            <div style="width:80px;height:110px;border-radius:8px;background:linear-gradient(135deg,#e8f4fd,#cfe2f3);display:flex;align-items:center;justify-content:center;color:#7db8e0;font-size:2rem;">
                                <i class="bi bi-book"></i>
                            </div>
                        @endif
                        <div>
                            <div style="font-weight:700;font-size:1rem;color:#1e3a5f;">{{ $borrowing->book->title }}</div>
                            <div style="font-size:.85rem;color:#666;margin-top:4px;">{{ $borrowing->book->author }}</div>
                            @if($borrowing->book->category)
                            <span class="badge mt-2" style="background:#e8f4fd;color:#1c7ed6;font-size:.75rem;">
                                {{ $borrowing->book->category->name }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <table class="table table-sm table-borderless" style="font-size:.85rem;">
                        @if($borrowing->book->isbn)
                        <tr><td class="text-muted fw-semibold" style="width:40%;">ISBN</td><td>{{ $borrowing->book->isbn }}</td></tr>
                        @endif
                        @if($borrowing->book->publisher)
                        <tr><td class="text-muted fw-semibold">Penerbit</td><td>{{ $borrowing->book->publisher }}</td></tr>
                        @endif
                        @if($borrowing->book->year)
                        <tr><td class="text-muted fw-semibold">Tahun</td><td>{{ $borrowing->book->year }}</td></tr>
                        @endif
                        @if($borrowing->book->call_number)
                        <tr><td class="text-muted fw-semibold">No. Panggil</td><td class="font-monospace">{{ $borrowing->book->call_number }}</td></tr>
                        @endif
                        @if($borrowing->book->language)
                        <tr><td class="text-muted fw-semibold">Bahasa</td><td>{{ $borrowing->book->language }}</td></tr>
                        @endif
                        <tr>
                            <td class="text-muted fw-semibold">Status Buku</td>
                            <td>
                                @php
                                    $bs = $borrowing->book->status;
                                    $bc = match($bs){ 'available'=>'success','borrowed'=>'danger','maintenance'=>'warning',default=>'secondary' };
                                    $bl = match($bs){ 'available'=>'Tersedia','borrowed'=>'Dipinjam','maintenance'=>'Perawatan',default=>$bs };
                                @endphp
                                <span class="badge bg-{{ $bc }}">{{ $bl }}</span>
                                <small class="text-muted ms-1">(Stok: {{ $borrowing->book->stock }})</small>
                            </td>
                        </tr>
                    </table>
                    <a href="{{ route('admin.books.show', $borrowing->book) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                        <i class="bi bi-arrow-up-right me-1"></i> Lihat Halaman Buku
                    </a>
                </div>
            </div>
        </div>

        <!-- RIGHT: Peminjam + Status + Aksi -->
        <div class="col-lg-7">
            <!-- Peminjam -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
                <div class="card-header border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold text-muted mb-0"><i class="bi bi-person me-2"></i>INFORMASI PEMINJAM</h6>
                </div>
                <div class="card-body px-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width:50px;height:50px;border-radius:50%;background:linear-gradient(135deg,#1c7ed6,#1565b8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.3rem;font-weight:700;">
                            {{ strtoupper(substr($borrowing->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight:700;font-size:1rem;">{{ $borrowing->user->name }}</div>
                            <div style="font-size:.85rem;color:#888;">{{ $borrowing->user->email }}</div>
                        </div>
                    </div>
                    @if($borrowing->notes)
                    <div class="p-3 rounded-3 mb-0" style="background:#f8fafd;border-left:3px solid #1c7ed6;">
                        <div style="font-size:.78rem;font-weight:700;color:#888;margin-bottom:4px;">CATATAN PEMINJAM</div>
                        <div style="font-size:.88rem;color:#333;">{{ $borrowing->notes }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
                <div class="card-header border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold text-muted mb-0">
                        <i class="bi bi-clock-history me-2"></i>STATUS & TIMELINE
                    </h6>
                </div>
                <div class="card-body px-4">
                    @php
                        $statusBadge = match($borrowing->status) {
                            'pending'  => ['class'=>'bg-warning text-dark','icon'=>'bi-clock','label'=>'Menunggu Konfirmasi'],
                            'active'   => ['class'=>'bg-success','icon'=>'bi-check-circle','label'=>'Sedang Dipinjam'],
                            'overdue'  => ['class'=>'bg-danger','icon'=>'bi-exclamation-triangle','label'=>'Terlambat Dikembalikan'],
                            'returned' => ['class'=>'bg-secondary','icon'=>'bi-box-arrow-in-down','label'=>'Sudah Dikembalikan'],
                            'rejected' => ['class'=>'bg-danger','icon'=>'bi-x-circle','label'=>'Ditolak'],
                            default    => ['class'=>'bg-secondary','icon'=>'bi-question','label'=>$borrowing->status],
                        };
                    @endphp
                    <div class="mb-3">
                        <span class="badge {{ $statusBadge['class'] }} rounded-pill px-3 py-2 fs-6">
                            <i class="bi {{ $statusBadge['icon'] }} me-1"></i>{{ $statusBadge['label'] }}
                        </span>
                    </div>

                    <div class="timeline" style="font-size:.88rem;">
                        <div class="d-flex gap-3 mb-2 align-items-center">
                            <i class="bi bi-send text-primary"></i>
                            <span><strong>Permintaan dikirim:</strong>
                                {{ $borrowing->requested_at?->format('d M Y') ?? $borrowing->created_at->format('d M Y, H:i') }}
                            </span>
                        </div>
                        @if($borrowing->approved_at)
                        <div class="d-flex gap-3 mb-2 align-items-center">
                            <i class="bi bi-person-check {{ $borrowing->status === 'rejected' ? 'text-danger' : 'text-success' }}"></i>
                            <span>
                                <strong>{{ $borrowing->status === 'rejected' ? 'Ditolak' : 'Disetujui' }}:</strong>
                                {{ $borrowing->approved_at->format('d M Y, H:i') }}
                                @if($borrowing->approvedBy)
                                    oleh <em>{{ $borrowing->approvedBy->name }}</em>
                                @endif
                            </span>
                        </div>
                        @endif
                        @if($borrowing->borrowed_at)
                        <div class="d-flex gap-3 mb-2 align-items-center">
                            <i class="bi bi-book text-info"></i>
                            <span><strong>Tanggal pinjam:</strong> {{ $borrowing->borrowed_at->format('d M Y') }}</span>
                        </div>
                        <div class="d-flex gap-3 mb-2 align-items-center">
                            <i class="bi bi-calendar-event {{ $borrowing->is_overdue ? 'text-danger' : 'text-warning' }}"></i>
                            <span>
                                <strong>Tenggat:</strong>
                                {{ $borrowing->due_date->format('d M Y') }}
                                @if($borrowing->is_overdue)
                                    <span class="badge bg-danger ms-1">Terlambat {{ $borrowing->days_overdue }} hari</span>
                                @endif
                            </span>
                        </div>
                        @endif
                        @if($borrowing->returned_at)
                        <div class="d-flex gap-3 mb-2 align-items-center">
                            <i class="bi bi-check-circle text-success"></i>
                            <span><strong>Dikembalikan:</strong> {{ $borrowing->returned_at->format('d M Y') }}</span>
                        </div>
                        @endif
                    </div>

                    @if($borrowing->status === 'rejected' && $borrowing->rejection_reason)
                    <div class="alert alert-danger py-2 mt-3" style="border-radius:10px;font-size:.85rem;">
                        <i class="bi bi-x-circle me-1"></i>
                        <strong>Alasan penolakan:</strong> {{ $borrowing->rejection_reason }}
                    </div>
                    @endif

                    @if($borrowing->fine_amount > 0)
                    <div class="alert alert-warning py-2 mt-2" style="border-radius:10px;font-size:.85rem;">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        <strong>Denda:</strong> Rp {{ number_format($borrowing->fine_amount, 0, ',', '.') }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            @if($borrowing->status === 'pending')
            <div class="card border-0 shadow-sm" style="border-radius:16px;border:2px solid #f59e0b !important;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-gear me-2"></i>Tindakan</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <form action="{{ route('admin.borrowings.approve', $borrowing) }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label fw-semibold" style="font-size:.85rem;">Durasi Peminjaman (hari)</label>
                                    <input type="number" name="due_days" class="form-control form-control-sm"
                                           value="14" min="1" max="60" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold" style="font-size:.85rem;">Catatan (opsional)</label>
                                    <textarea name="notes" class="form-control form-control-sm" rows="2"
                                              placeholder="Pesan dari pustakawan..."></textarea>
                                </div>
                                <button class="btn btn-success w-100 rounded-pill fw-bold">
                                    <i class="bi bi-check-lg me-1"></i> Setujui Peminjaman
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('admin.borrowings.reject', $borrowing) }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label fw-semibold" style="font-size:.85rem;">Alasan Penolakan <span class="text-danger">*</span></label>
                                    <textarea name="rejection_reason" class="form-control form-control-sm" rows="4"
                                              placeholder="Jelaskan alasan penolakan..." required maxlength="500"></textarea>
                                </div>
                                <button class="btn btn-danger w-100 rounded-pill fw-bold">
                                    <i class="bi bi-x-lg me-1"></i> Tolak Permintaan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(in_array($borrowing->status, ['active','overdue']))
            <div class="card border-0 shadow-sm" style="border-radius:16px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-box-arrow-in-down me-2"></i>Konfirmasi Pengembalian</h6>
                    @if($borrowing->is_overdue)
                    <div class="alert alert-warning py-2 mb-3" style="border-radius:10px;font-size:.85rem;">
                        Buku terlambat <strong>{{ $borrowing->days_overdue }} hari</strong>.
                        Denda estimasi: <strong>Rp {{ number_format($borrowing->calculateFine(), 0, ',', '.') }}</strong>
                    </div>
                    @endif
                    <form action="{{ route('admin.borrowings.return', $borrowing) }}" method="POST"
                          onsubmit="return confirm('Konfirmasi bahwa buku sudah dikembalikan?')">
                        @csrf
                        <button class="btn btn-outline-secondary rounded-pill fw-bold px-4">
                            <i class="bi bi-check2-circle me-1"></i> Tandai Sudah Dikembalikan
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
