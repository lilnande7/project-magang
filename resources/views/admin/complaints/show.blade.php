@extends('admin.layout')

@section('title', 'Detail Pengaduan')
@section('page-title', 'Detail Pengaduan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('admin.complaints.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>

    <div class="d-flex gap-2">
        <form method="POST" action="{{ route('admin.complaints.update', $complaint) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="masuk">
            <button type="submit" class="btn btn-outline-secondary btn-sm">Tandai Masuk</button>
        </form>
        <form method="POST" action="{{ route('admin.complaints.update', $complaint) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="diproses">
            <button type="submit" class="btn btn-outline-info btn-sm">Tandai Diproses</button>
        </form>
        <form method="POST" action="{{ route('admin.complaints.update', $complaint) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="selesai">
            <button type="submit" class="btn btn-outline-success btn-sm">Tandai Selesai</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-chat-left-text me-2"></i>
            Pengaduan
        </h5>
        @php
            $badge = match($complaint->status) {
                'masuk' => 'secondary',
                'diproses' => 'info',
                'selesai' => 'success',
                default => 'dark'
            };
        @endphp
        <span class="badge bg-{{ $badge }}">{{ ucfirst($complaint->status) }}</span>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="text-muted small">Nama</div>
                <div class="fw-semibold">{{ $complaint->name }}</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Email</div>
                <div class="fw-semibold">{{ $complaint->email }}</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Dibuat</div>
                <div class="fw-semibold">{{ $complaint->created_at->format('d M Y H:i') }}</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Ditangani oleh</div>
                <div class="fw-semibold">{{ $complaint->admin->name ?? '-' }}</div>
            </div>

            <div class="col-12">
                <div class="text-muted small">Pesan</div>
                <div class="border rounded p-3" style="white-space: pre-wrap;">{{ $complaint->message }}</div>
            </div>

            <div class="col-md-6">
                <div class="text-muted small">IP</div>
                <div class="fw-semibold">{{ $complaint->ip ?? '-' }}</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">User Agent</div>
                <div class="fw-semibold">{{ $complaint->user_agent ?? '-' }}</div>
            </div>

            <div class="col-md-6">
                <div class="text-muted small">Diproses pada</div>
                <div class="fw-semibold">{{ $complaint->processed_at?->format('d M Y H:i') ?? '-' }}</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Selesai pada</div>
                <div class="fw-semibold">{{ $complaint->completed_at?->format('d M Y H:i') ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
