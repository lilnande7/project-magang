@extends('admin.layout')

@section('title', 'Pengaduan')
@section('page-title', 'Pengaduan')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <a href="{{ route('admin.complaints.index', ['status' => 'masuk']) }}" class="text-decoration-none">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Masuk</div>
                        <div class="h4 mb-0">{{ $counts['masuk'] ?? 0 }}</div>
                    </div>
                    <span class="badge bg-secondary">Masuk</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.complaints.index', ['status' => 'diproses']) }}" class="text-decoration-none">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Diproses</div>
                        <div class="h4 mb-0">{{ $counts['diproses'] ?? 0 }}</div>
                    </div>
                    <span class="badge bg-info">Diproses</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.complaints.index', ['status' => 'selesai']) }}" class="text-decoration-none">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Selesai</div>
                        <div class="h4 mb-0">{{ $counts['selesai'] ?? 0 }}</div>
                    </div>
                    <span class="badge bg-success">Selesai</span>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-chat-left-text me-2"></i>
            Daftar Pengaduan
        </h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.complaints.index') }}" class="btn btn-sm btn-outline-dark">Semua</a>
            <a href="{{ route('admin.complaints.index', ['status' => 'masuk']) }}" class="btn btn-sm btn-outline-secondary">Masuk</a>
            <a href="{{ route('admin.complaints.index', ['status' => 'diproses']) }}" class="btn btn-sm btn-outline-info">Diproses</a>
            <a href="{{ route('admin.complaints.index', ['status' => 'selesai']) }}" class="btn btn-sm btn-outline-success">Selesai</a>
        </div>
    </div>
    <div class="card-body">
        @if($complaints->isEmpty())
            <p class="text-muted mb-0">Belum ada pengaduan.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Ditangani oleh</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($complaints as $complaint)
                            <tr>
                                <td>{{ $complaint->created_at->format('d M Y H:i') }}</td>
                                <td>{{ $complaint->name }}</td>
                                <td>{{ $complaint->email }}</td>
                                <td>
                                    @php
                                        $badge = match($complaint->status) {
                                            'masuk' => 'secondary',
                                            'diproses' => 'info',
                                            'selesai' => 'success',
                                            default => 'dark'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badge }}">{{ ucfirst($complaint->status) }}</span>
                                </td>
                                <td>{{ $complaint->admin->name ?? '-' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.complaints.show', $complaint) }}" class="btn btn-sm btn-primary">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $complaints->links() }}
        @endif
    </div>
</div>
@endsection
