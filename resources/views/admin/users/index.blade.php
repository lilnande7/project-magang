@extends('admin.layout')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')

@push('styles')
<style>
    .stats-card {
        border-radius: 1rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
        background: linear-gradient(135deg, #eef2ff, #f8fafc);
        padding: 1.5rem;
        height: 100%;
    }

    .stats-card .label {
        font-size: 0.85rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #64748b;
    }

    .stats-card .value {
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
    }

    .role-pill {
        border-radius: 999px;
        padding: 0.2rem 0.75rem;
        font-size: 0.78rem;
        font-weight: 600;
        background: rgba(59, 130, 246, 0.12);
        color: #1d4ed8;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .avatar-sm {
        width: 48px;
        height: 48px;
        border-radius: 999px;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #475569;
        overflow: hidden;
    }

    .badge-soft {
        border-radius: 999px;
        padding: 0.3rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 3rem;
        color: #c7d2fe;
    }
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="label">Total Pengguna</div>
            <div class="value">{{ number_format($stats['totalUsers'] ?? 0) }}</div>
            <small class="text-muted">Semua akun terdaftar</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="label">Terverifikasi</div>
            <div class="value">{{ number_format($stats['verifiedUsers'] ?? 0) }}</div>
            <small class="text-muted">Email sudah diverifikasi</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="label">Admin &amp; Super Admin</div>
            <div class="value">{{ number_format($stats['adminUsers'] ?? 0) }}</div>
            <small class="text-muted">Akses pengelola</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="label">Sedang Meminjam</div>
            <div class="value">{{ number_format($stats['activeBorrowers'] ?? 0) }}</div>
            <small class="text-muted">Memiliki peminjaman aktif</small>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label for="search" class="form-label">Cari Pengguna</label>
                <input type="search" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nama atau email">
            </div>
            <div class="col-md-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role">
                    <option value="">Semua role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->slug }}" {{ request('role') === $role->slug ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="sort" class="form-label">Urutkan</label>
                <select class="form-select" id="sort" name="sort">
                    <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Nama A → Z</option>
                    <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>Nama Z → A</option>
                </select>
            </div>
            <div class="col-md-1 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="bi bi-funnel me-1"></i> Terapkan
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary" title="Reset filter">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h5 class="mb-1">Daftar Pengguna</h5>
                    <small class="text-muted">{{ $users->total() }} data ditemukan</small>
                </div>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Pengguna
                </a>
            </div>
            <div class="card-body p-0">
                @if($users->count())
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Pengguna</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Peminjaman</th>
                                    <th>Dibuat</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    @if($user->avatar_path)
                                                        <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="{{ $user->name }}" class="w-100 h-100" style="object-fit: cover;">
                                                    @else
                                                        <span>{{ strtoupper(mb_substr($user->name, 0, 2, 'UTF-8')) }}</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $user->name }}</div>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @forelse($user->roles as $role)
                                                <span class="role-pill mb-1">{{ $role->name }}</span>
                                            @empty
                                                <span class="text-muted">Tanpa role</span>
                                            @endforelse
                                        </td>
                                        <td>
                                            @if($user->email_verified_at)
                                                <span class="badge bg-success badge-soft">Terverifikasi</span>
                                            @else
                                                <span class="badge bg-warning text-dark badge-soft">Belum verifikasi</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-semibold">{{ $user->borrowings_count ?? 0 }}</span>
                                            <small class="text-muted d-block">riwayat</small>
                                        </td>
                                        <td>{{ optional($user->created_at)->format('d M Y') }}</td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center gap-3 p-3">
                        <small class="text-muted">Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} pengguna</small>
                        {{ $users->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <i class="bi bi-people"></i>
                        <h5 class="mt-3 mb-2">Belum ada data pengguna</h5>
                        <p class="text-muted">Gunakan tombol tambah pengguna untuk membuat akun baru.</p>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Tambah sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Pengguna Terbaru</h6>
            </div>
            <div class="card-body">
                @forelse($latestUsers as $user)
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <div>
                            <div class="fw-semibold">{{ $user->name }}</div>
                            <small class="text-muted">{{ $user->email }}</small>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">{{ optional($user->created_at)->diffForHumans() }}</div>
                            <div>
                                @forelse($user->roles as $role)
                                    <span class="badge bg-light text-dark">{{ $role->name }}</span>
                                @empty
                                    <span class="badge bg-secondary">User</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">Belum ada aktivitas terbaru.</p>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Distribusi Role</h6>
            </div>
            <div class="card-body">
                @forelse($roleDistribution as $role)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span>{{ $role->name }}</span>
                        <span class="fw-semibold">{{ $role->users_count }} pengguna</span>
                    </div>
                @empty
                    <p class="text-muted mb-0">Belum ada role aktif.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
