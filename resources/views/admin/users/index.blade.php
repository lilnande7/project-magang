@extends('admin.layout')

@section('title', 'User Management')
@section('page-title', 'User Management')

<<<<<<< HEAD
@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --ink: #06142b;
        --dusk: #1f3b73;
        --accent: #ff6f3c;
        --mint: #68d9a3;
        --fog: #f5f6fb;
    }

    .user-console {
        font-family: 'Space Grotesk', 'Segoe UI', sans-serif;
        position: relative;
    }

    .user-console::after {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, rgba(104, 217, 163, 0.12), transparent 60%),
                    radial-gradient(circle at 20% 20%, rgba(255, 111, 60, 0.15), transparent 45%);
        z-index: -1;
    }

    .pulse-card {
        border: none;
        border-radius: 1rem;
        color: white;
        background: linear-gradient(135deg, var(--dusk), #4a4dcf);
        box-shadow: 0 18px 35px rgba(21, 32, 86, 0.25);
        overflow: hidden;
        position: relative;
    }

    .pulse-card:nth-child(2) { background: linear-gradient(135deg, #0f9b8e, var(--mint)); color: var(--ink); }
    .pulse-card:nth-child(3) { background: linear-gradient(135deg, #15172b, #3d1d5b); }
    .pulse-card:nth-child(4) { background: linear-gradient(135deg, #ff6f3c, #f8c53a); color: var(--ink); }

    .pulse-card::before {
        content: '';
        position: absolute;
        width: 140%;
        height: 140%;
        background: radial-gradient(circle, rgba(255,255,255,0.25), transparent 55%);
        top: -40%;
        right: -65%;
        transform: rotate(30deg);
    }

    .pulse-card h6 {
        letter-spacing: 1px;
        font-size: 0.85rem;
        text-transform: uppercase;
        opacity: 0.8;
    }

    .pulse-card strong {
        font-size: 2.4rem;
    }

    .card-holo {
        border-radius: 1.1rem;
        border: 1px solid rgba(6, 20, 43, 0.06);
        background: white;
        box-shadow: 0 30px 60px rgba(15, 36, 75, 0.15);
    }

    .filter-chip label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--dusk);
    }

    .filter-chip .form-control,
    .filter-chip .form-select {
        border-radius: 999px;
        background: var(--fog);
        border: none;
        padding: 0.65rem 1.25rem;
    }

    .user-table thead {
        background: var(--fog);
        border-radius: 1rem;
    }

    .user-table th {
        border: none;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--dusk);
    }

    .user-table td {
        vertical-align: middle;
        border-color: #f1f3fa !important;
    }

    .role-pill {
        border-radius: 999px;
        padding: 0.2rem 0.75rem;
        font-size: 0.78rem;
        font-weight: 600;
        background: rgba(31, 59, 115, 0.08);
        color: var(--dusk);
    }

    .spark-list .list-group-item {
        border: none;
        border-bottom: 1px solid rgba(6, 20, 43, 0.08);
        padding: 0.9rem 0;
    }

    .sparklist-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--fog);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: var(--dusk);
    }

    .distribution-bar {
        width: 100%;
        height: 8px;
        border-radius: 999px;
        background: var(--fog);
        overflow: hidden;
    }

    .distribution-bar span {
        display: block;
        height: 100%;
        background: linear-gradient(90deg, var(--dusk), var(--accent));
    }
</style>
@endpush

@section('content')
<div class="user-console">
    @if (session('status'))
        <div class="alert alert-success shadow-sm border-0 rounded-pill px-4 py-3 mb-4">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger shadow-sm border-0 rounded-pill px-4 py-3 mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="pulse-card p-4">
                <h6>Total Users</h6>
                <strong>{{ number_format($stats['totalUsers']) }}</strong>
                <p class="mb-0 opacity-75">Across every role</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="pulse-card p-4">
                <h6>Verified Emails</h6>
                <strong>{{ number_format($stats['verifiedUsers']) }}</strong>
                <p class="mb-0 opacity-75">Trusted contacts</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="pulse-card p-4">
                <h6>Admin Access</h6>
                <strong>{{ number_format($stats['adminUsers']) }}</strong>
                <p class="mb-0 opacity-75">Super/Admin roles</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="pulse-card p-4">
                <h6>Active Borrowers</h6>
                <strong>{{ number_format($stats['activeBorrowers']) }}</strong>
                <p class="mb-0 opacity-75">Currently borrowing</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card card-holo mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3 filter-chip align-items-end">
                        <div class="col-md-4">
                            <label for="search">Search</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Name or email">
                        </div>
                        <div class="col-md-4">
                            <label for="role">Role</label>
                            <select id="role" name="role" class="form-select">
                                <option value="">All roles</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->slug }}" {{ request('role') === $role->slug ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="sort">Sort</label>
                            <select id="sort" name="sort" class="form-select">
                                <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Newest first</option>
                                <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest first</option>
                                <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Name A → Z</option>
                                <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>Name Z → A</option>
                            </select>
                        </div>
                        <div class="col-md-1 text-end">
                            <button type="submit" class="btn btn-dark rounded-pill px-3 py-2">
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card-holo">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="mb-1" style="color: var(--ink);">Directory</h5>
                            <small class="text-muted">{{ $users->total() }} user{{ $users->total() === 1 ? '' : 's' }} tracked</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-dark-subtle text-dark">{{ $users->currentPage() }} / {{ $users->lastPage() }}</span>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-dark rounded-pill px-3">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Anggota
                            </a>
                        </div>
                    </div>

                    @if($users->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-people display-4 text-muted"></i>
                            <h5 class="mt-3">No users match your filters</h5>
                            <p class="text-muted mb-0">Reset filters to see the full directory.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table user-table align-middle">
                                <thead>
                                    <tr>
                                        <th width="35">#</th>
                                        <th>User</th>
                                        <th>Roles</th>
                                        <th>Borrowings</th>
                                        <th>Joined</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $users->firstItem() + $loop->index }}</td>
                                            <td>
                                                <div class="fw-semibold">{{ $user->name }}</div>
                                                <small class="text-muted">{{ $user->email }}</small>
                                                @if($user->email_verified_at)
                                                    <span class="badge bg-success-subtle text-success ms-2">Verified</span>
                                                @endif
                                            </td>
                                            <td>
                                                @forelse($user->roles as $role)
                                                    <span class="role-pill me-1 mb-1 d-inline-block">{{ $role->name }}</span>
                                                @empty
                                                    <span class="text-muted">No role</span>
                                                @endforelse
                                            </td>
                                            <td>
                                                <span class="fw-semibold">{{ $user->borrowings_count }}</span>
                                                <small class="text-muted d-block">lifetime</small>
                                            </td>
                                            <td>
                                                <div>{{ $user->created_at?->format('d M Y') }}</div>
                                                <small class="text-muted">{{ $user->created_at?->diffForHumans() }}</small>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-dark rounded-pill">
                                                    Kelola
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $users->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-holo mb-4">
                <div class="card-body">
                    <h5 class="mb-3" style="color: var(--ink);">Latest Signups</h5>
                    <ul class="list-group list-group-flush spark-list">
                        @forelse($latestUsers as $fresh)
                            <li class="list-group-item px-0">
                                <div class="d-flex align-items-center">
                                    <div class="sparklist-avatar me-3">
                                        {{ strtoupper(\Illuminate\Support\Str::substr($fresh->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $fresh->name }}</div>
                                        <small class="text-muted">{{ $fresh->created_at?->diffForHumans() }}</small>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <small class="text-muted">{{ $fresh->roles->pluck('name')->join(', ') ?: 'Member' }}</small>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item px-0 text-center text-muted">No recent registrations</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="card card-holo">
                <div class="card-body">
                    <h5 class="mb-3" style="color: var(--ink);">Roles Breakdown</h5>
                    @foreach($roleDistribution as $role)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-semibold">{{ $role->name }}</span>
                                <small class="text-muted">{{ $role->users_count }} user{{ $role->users_count === 1 ? '' : 's' }}</small>
                            </div>
                            <div class="distribution-bar">
                                <span style="width: {{ $stats['totalUsers'] ? round(($role->users_count / max($stats['totalUsers'], 1)) * 100, 1) : 0 }}%;"></span>
                            </div>
                        </div>
                    @endforeach
                    @if($roleDistribution->isEmpty())
                        <p class="text-muted">No roles configured yet.</p>
                    @endif
=======
@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="bi bi-people-fill display-5 mb-2"></i>
                <h4 class="mb-0">{{ $userStats['total_users'] }}</h4>
                <small>Total Users</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stats-card-success text-white">
            <div class="card-body text-center">
                <i class="bi bi-shield-lock display-5 mb-2"></i>
                <h4 class="mb-0">{{ $userStats['total_admins'] }}</h4>
                <small>Admins & Super Admins</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stats-card-info text-white">
            <div class="card-body text-center">
                <i class="bi bi-journal-bookmark display-5 mb-2"></i>
                <h4 class="mb-0">{{ $userStats['total_librarians'] }}</h4>
                <small>Librarians</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Create New Account</h5>
                <span class="badge bg-primary">Admin Only</span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" minlength="8" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="roles" class="form-label">Assign Roles</label>
                        <select id="roles" name="roles[]" class="form-select" multiple required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @selected(collect(old('roles', []))->contains($role->id))>
                                    {{ $role->name }} ({{ $role->slug }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold Ctrl / Cmd to select multiple roles.</small>
                    </div>
                    <div class="mt-4 d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-person-plus me-2"></i>
                            Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Role Overview</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Pilih role sesuai kebutuhan akses sistem. Super admin memiliki akses penuh, sedangkan member hanya dapat melihat konten dasar.</p>
                <div class="row g-3">
                    @foreach($roles as $role)
                        <div class="col-sm-6">
                            <div class="border rounded-3 p-3 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">{{ $role->name }}</h6>
                                    <span class="badge bg-secondary text-uppercase">{{ $role->slug }}</span>
                                </div>
                                <p class="mb-0 text-muted small">{{ $role->description ?? 'No description' }}</p>
                            </div>
                        </div>
                    @endforeach
>>>>>>> main
                </div>
            </div>
        </div>
    </div>
</div>
<<<<<<< HEAD
@endsection
=======

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">User Directory</h5>
        <div>
            <span class="badge bg-light text-dark">{{ $users->count() }} records</span>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="usersTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Joined</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $user->name }}</div>
                                <small class="text-muted">ID: #{{ $user->id }}</small>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @forelse($user->roles as $role)
                                    <span class="badge bg-primary me-1 mb-1">{{ $role->name }}</span>
                                @empty
                                    <span class="badge bg-light text-dark">No roles</span>
                                @endforelse
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-end">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-primary manage-roles-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#manageRoleModal"
                                    data-user-id="{{ $user->id }}"
                                    data-user-name="{{ $user->name }}"
                                    data-user-roles="{{ $user->roles->pluck('id')->implode(',') }}"
                                >
                                    <i class="bi bi-sliders"></i>
                                    Manage Roles
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-secondary change-password-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#changePasswordModal"
                                    data-user-id="{{ $user->id }}"
                                    data-user-name="{{ $user->name }}"
                                >
                                    <i class="bi bi-key"></i>
                                    Ganti Password
                                </button>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this user?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Manage Role Modal -->
<div class="modal fade" id="manageRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manageRoleModalLabel">Manage Roles</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="manageRoleForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p class="text-muted" id="selectedUserInfo"></p>
                    <label for="manage_roles" class="form-label">Select Roles</label>
                    <select id="manage_roles" name="roles[]" class="form-select" multiple required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }} ({{ $role->slug }})</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Ensure at least one super admin remains assigned.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ganti Password Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="changePasswordForm" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p class="text-muted" id="passwordUserInfo"></p>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Sebelumnya</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        <small class="text-muted">Untuk alasan keamanan, masukkan password lama pengguna sebelum menetapkan yang baru.</small>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="new_password" name="password" minlength="8" required>
                    </div>
                    <div>
                        <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="password_confirmation" minlength="8" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const userBaseUrl = "{{ url('admin/users') }}";
    const manageRoleForm = document.getElementById('manageRoleForm');
    const manageRoleSelect = document.getElementById('manage_roles');
    const selectedUserInfo = document.getElementById('selectedUserInfo');
    const changePasswordForm = document.getElementById('changePasswordForm');
    const passwordUserInfo = document.getElementById('passwordUserInfo');

    document.querySelectorAll('.manage-roles-btn').forEach(button => {
        button.addEventListener('click', () => {
            const userId = button.dataset.userId;
            const userName = button.dataset.userName;
            const roles = button.dataset.userRoles ? button.dataset.userRoles.split(',').filter(Boolean) : [];

            selectedUserInfo.textContent = `Updating roles for ${userName}`;
            manageRoleForm.action = `${userBaseUrl}/${userId}`;

            Array.from(manageRoleSelect.options).forEach(option => {
                option.selected = roles.includes(option.value);
            });
        });
    });

    document.querySelectorAll('.change-password-btn').forEach(button => {
        button.addEventListener('click', () => {
            const userId = button.dataset.userId;
            const userName = button.dataset.userName;

            if (changePasswordForm) {
                changePasswordForm.reset();
                changePasswordForm.action = `${userBaseUrl}/${userId}/password`;
            }

            if (passwordUserInfo) {
                passwordUserInfo.textContent = `Menetapkan password baru untuk ${userName}`;
            }
        });
    });

    $(document).ready(function () {
        $('#usersTable').DataTable({
            pageLength: 10,
            order: [[0, 'asc']]
        });
    });
</script>
@endpush
>>>>>>> main
