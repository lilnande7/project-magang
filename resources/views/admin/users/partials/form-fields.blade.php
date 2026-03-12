@php
    $selectedRoleIds = collect(old('roles', isset($user)
        ? $user->roles->pluck('id')->all()
        : (($defaultRoleId ?? null) ? [($defaultRoleId)] : [])))
        ->map(fn ($id) => (int) $id)
        ->all();
@endphp

<div class="card card-holo">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="mb-1" style="color: var(--ink);">Profil Anggota</h5>
                <small class="text-muted">Lengkapi data dasar dan hak akses pengguna.</small>
            </div>
            <span class="badge bg-dark-subtle text-dark">{{ isset($user) ? 'Mode edit' : 'Mode tambah' }}</span>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Avatar</label>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    @if(isset($user) && $user->avatar_path)
                        <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 72px; height: 72px; object-fit: cover;">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 72px; height: 72px; background: rgba(6, 20, 43, 0.08);">
                            <span class="fw-semibold text-muted">{{ strtoupper(substr(old('name', $user->name ?? 'U'), 0, 2)) }}</span>
                        </div>
                    @endif
                    <div class="flex-grow-1">
                        <input type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar" accept="image/png,image/jpeg,image/webp">
                        <small class="text-muted">Format JPG/PNG/WebP, maks 2MB.</small>
                        @error('avatar')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @if(isset($user) && $user->avatar_path)
                    <div class="form-check mt-2">
                        <input type="hidden" name="remove_avatar" value="0">
                        <input class="form-check-input" type="checkbox" name="remove_avatar" id="remove_avatar" value="1" {{ old('remove_avatar') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remove_avatar">Hapus avatar saat ini</label>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">Password {{ isset($user) ? '(opsional)' : '' }}</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" {{ isset($user) ? '' : 'required' }}>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if(isset($user))
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                @endif
            </div>
            <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Konfirmasi Password {{ isset($user) ? '(opsional)' : '' }}</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" {{ isset($user) ? '' : 'required' }}>
            </div>
            <div class="col-md-6">
                <label class="form-label">Status Email</label>
                <div class="form-check form-switch">
                    <input type="hidden" name="email_verified" value="0">
                    <input class="form-check-input" type="checkbox" role="switch" id="email_verified" name="email_verified" value="1" {{ old('email_verified', isset($user) && $user->email_verified_at ? 1 : 0) ? 'checked' : '' }}>
                    <label class="form-check-label" for="email_verified">Tandai sebagai sudah diverifikasi</label>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Role &amp; Hak Akses</label>
                <div class="d-flex flex-wrap gap-3">
                    @forelse($roles as $role)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}" {{ in_array($role->id, $selectedRoleIds, true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada role aktif yang dapat dipilih.</p>
                    @endforelse
                </div>
                @error('roles')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 d-flex justify-content-between align-items-center pt-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill">Batal</a>
                <button type="submit" class="btn btn-dark rounded-pill px-4">{{ $submitLabel ?? 'Simpan' }}</button>
            </div>
        </div>
    </div>
</div>
