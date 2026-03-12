<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
<<<<<<< HEAD
use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    protected ?Collection $assignableRolesCache = null;
    protected ?int $defaultRoleId = null;

    public function index(Request $request)
    {
        $query = User::with(['roles'])
            ->withCount('borrowings');

        if ($search = trim((string) $request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role = $request->input('role')) {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('slug', $role);
            });
        }

        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'name_asc' => $query->orderBy('name'),
            'name_desc' => $query->orderByDesc('name'),
            'oldest' => $query->orderBy('created_at'),
            default => $query->orderByDesc('created_at')
        };

        $users = $query->paginate(12)->withQueryString();

        $roles = Role::active()->orderBy('name')->get();

        $stats = [
            'totalUsers' => User::count(),
            'verifiedUsers' => User::whereNotNull('email_verified_at')->count(),
            'adminUsers' => User::whereHas('roles', fn ($q) => $q->whereIn('slug', ['admin', 'super-admin']))->count(),
            'activeBorrowers' => User::whereHas('borrowings', fn ($q) => $q->where('status', 'active'))->count(),
        ];

        $latestUsers = User::with('roles')->latest()->take(5)->get();

        $roleDistribution = Role::withCount('users')->orderByDesc('users_count')->get();

        return view('admin.users.index', compact('users', 'roles', 'stats', 'roleDistribution', 'sort', 'latestUsers'));
    }

    public function create()
    {
        $roles = $this->assignableRoles();

        return view('admin.users.create', [
            'roles' => $roles,
            'defaultRoleId' => $this->defaultRoleId(),
        ]);
    }

    public function store(Request $request)
    {
        $roles = $this->assignableRoles();
        $assignableRoleIds = $roles->pluck('id')->all();

=======
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->orderByDesc('created_at')->get();
        $roles = Role::active()->orderBy('name')->get();

        $userStats = [
            'total_users' => $users->count(),
            'total_admins' => $users->filter(fn ($user) => $user->roles->contains(fn ($role) => in_array($role->slug, ['admin', 'super-admin'])))->count(),
            'total_librarians' => $users->filter(fn ($user) => $user->roles->contains('slug', 'librarian'))->count(),
        ];

        return view('admin.users.index', compact('users', 'roles', 'userStats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
>>>>>>> main
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
<<<<<<< HEAD
            'roles' => ['sometimes', 'array'],
            'roles.*' => ['integer', Rule::in($assignableRoleIds)],
            'email_verified' => ['sometimes', 'boolean'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ];

        if ($request->hasFile('avatar')) {
            $userData['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create($userData);

        if ($request->boolean('email_verified')) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        $this->syncRoles($user, $request->input('roles', []), $assignableRoleIds);

        $user->load('roles');
        $this->logActivity(
            $user,
            'user.created',
            'Menambahkan akun baru.',
            [
                'roles' => $user->roles->pluck('slug')->all(),
            ]
        );

        return redirect()->route('admin.users.index')->with('status', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $this->ensureCanManage($user);

        $user->load('roles');

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $this->assignableRoles(),
            'defaultRoleId' => null,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->ensureCanManage($user);

        $roles = $this->assignableRoles();
        $assignableRoleIds = $roles->pluck('id')->all();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'roles' => ['sometimes', 'array'],
            'roles.*' => ['integer', Rule::in($assignableRoleIds)],
            'email_verified' => ['sometimes', 'boolean'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'remove_avatar' => ['sometimes', 'boolean'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->email_verified_at = $request->boolean('email_verified')
            ? ($user->email_verified_at ?? now())
            : null;

        $pendingMeta = [
            'password_changed' => !empty($validated['password']),
            'email_verified' => $request->boolean('email_verified'),
            'roles_input' => $request->input('roles', []),
        ];

        if ($request->hasFile('avatar')) {
            $this->deleteAvatarIfExists($user);
            $user->avatar_path = $request->file('avatar')->store('avatars', 'public');
            $pendingMeta['avatar_updated'] = true;
        } elseif ($request->boolean('remove_avatar')) {
            $this->deleteAvatarIfExists($user);
            $user->avatar_path = null;
            $pendingMeta['avatar_removed'] = true;
        }

        $dirtyFields = array_keys($user->getDirty());
        $user->save();

        $this->syncRoles($user, $request->input('roles', []), $assignableRoleIds);

        $user->load('roles');
        $this->logActivity(
            $user,
            'user.updated',
            'Memperbarui akun pengguna.',
            array_filter(array_merge($pendingMeta, [
                'fields' => $dirtyFields,
                'roles' => $user->roles->pluck('slug')->all(),
            ]))
        );

        return redirect()->route('admin.users.index')->with('status', 'Perubahan pengguna tersimpan.');
    }

    public function destroy(User $user)
    {
        $this->ensureCanManage($user);

        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $this->deleteAvatarIfExists($user);
        $user->roles()->detach();

        $this->logActivity(
            $user,
            'user.deleted',
            'Menghapus akun pengguna.',
            []
        );

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'Pengguna berhasil dihapus.');
    }

    protected function deleteAvatarIfExists(User $user): void
    {
        if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
            Storage::disk('public')->delete($user->avatar_path);
        }
    }

    protected function logActivity(?User $targetUser, string $action, ?string $description = null, array $meta = []): void
    {
        if (!auth()->check()) {
            return;
        }

        UserActivityLog::create([
            'admin_id' => auth()->id(),
            'target_user_id' => $targetUser?->id,
            'action' => $action,
            'description' => $description,
            'meta' => empty($meta) ? null : $meta,
        ]);
    }

    protected function assignableRoles(): Collection
    {
        if ($this->assignableRolesCache instanceof Collection) {
            return $this->assignableRolesCache;
        }

        return $this->assignableRolesCache = Role::active()
            ->when(!optional(auth()->user())->isSuperAdmin(), function ($query) {
                $query->where('slug', '!=', 'super-admin');
            })
            ->orderBy('name')
            ->get();
    }

    protected function defaultRoleId(): ?int
    {
        if ($this->defaultRoleId !== null) {
            return $this->defaultRoleId;
        }

        $this->defaultRoleId = Role::where('slug', 'user')->value('id');

        return $this->defaultRoleId;
    }

    protected function syncRoles(User $user, array $roleIds = [], array $assignableRoleIds = []): void
    {
        $assignableRoleIds = $assignableRoleIds ?: $this->assignableRoles()->pluck('id')->all();

        $roleIds = collect($roleIds)
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->intersect($assignableRoleIds)
            ->values()
            ->all();

        if (empty($roleIds) && ($defaultRoleId = $this->defaultRoleId())) {
            $roleIds = [$defaultRoleId];
        }

        $user->roles()->sync($roleIds);
    }

    protected function ensureCanManage(User $user): void
    {
        if ($user->isSuperAdmin() && !optional(auth()->user())->isSuperAdmin()) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah Super Admin.');
        }
=======
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);

            $user->roles()->sync($validated['roles']);
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);

        $selectedRoleSlugs = Role::whereIn('id', $validated['roles'])->pluck('slug')->toArray();
        $isRemovingSuperAdminRole = $user->roles->contains('slug', 'super-admin')
            && !in_array('super-admin', $selectedRoleSlugs, true);

        if ($isRemovingSuperAdminRole && $this->superAdminCount() <= 1) {
            return back()->with('error', 'At least one super admin is required.');
        }

        $user->roles()->sync($validated['roles']);

        return back()->with('success', 'Roles updated for ' . $user->name . '.');
    }

    /**
     * Allow super admins to update a user's password after verifying the previous one.
     */
    public function updatePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->with('error', 'Kata sandi sebelumnya tidak sesuai untuk pengguna ini.');
        }

        $user->update([
            'password' => $validated['password'],
        ]);

        return back()->with('success', 'Kata sandi baru berhasil diterapkan untuk ' . $user->name . '.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->roles->contains('slug', 'super-admin') && $this->superAdminCount() <= 1) {
            return back()->with('error', 'Cannot delete the last super admin.');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    private function superAdminCount(): int
    {
        return User::whereHas('roles', fn ($query) => $query->where('slug', 'super-admin'))->count();
>>>>>>> main
    }
}
