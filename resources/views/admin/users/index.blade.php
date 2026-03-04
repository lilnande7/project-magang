@extends('admin.layout')

@section('title', 'User Management')
@section('page-title', 'User Management')

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
                </div>
            </div>
        </div>
    </div>
</div>

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
@endsection

@push('scripts')
<script>
    const updateBaseUrl = "{{ url('admin/users') }}";
    const manageRoleForm = document.getElementById('manageRoleForm');
    const manageRoleSelect = document.getElementById('manage_roles');
    const selectedUserInfo = document.getElementById('selectedUserInfo');

    document.querySelectorAll('.manage-roles-btn').forEach(button => {
        button.addEventListener('click', () => {
            const userId = button.dataset.userId;
            const userName = button.dataset.userName;
            const roles = button.dataset.userRoles ? button.dataset.userRoles.split(',').filter(Boolean) : [];

            selectedUserInfo.textContent = `Updating roles for ${userName}`;
            manageRoleForm.action = `${updateBaseUrl}/${userId}`;

            Array.from(manageRoleSelect.options).forEach(option => {
                option.selected = roles.includes(option.value);
            });
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
