<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
    }
}
