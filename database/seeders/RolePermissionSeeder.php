<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            // Dashboard
            ['name' => 'View Dashboard', 'slug' => 'dashboard.view', 'group' => 'dashboard'],
            
            // Books Management
            ['name' => 'View Books', 'slug' => 'books.view', 'group' => 'books'],
            ['name' => 'Create Books', 'slug' => 'books.create', 'group' => 'books'],
            ['name' => 'Edit Books', 'slug' => 'books.edit', 'group' => 'books'],
            ['name' => 'Delete Books', 'slug' => 'books.delete', 'group' => 'books'],
            
            // Categories Management
            ['name' => 'View Categories', 'slug' => 'categories.view', 'group' => 'categories'],
            ['name' => 'Create Categories', 'slug' => 'categories.create', 'group' => 'categories'],
            ['name' => 'Edit Categories', 'slug' => 'categories.edit', 'group' => 'categories'],
            ['name' => 'Delete Categories', 'slug' => 'categories.delete', 'group' => 'categories'],
            
            // Borrowing Management
            ['name' => 'View Borrowings', 'slug' => 'borrowings.view', 'group' => 'borrowings'],
            ['name' => 'Create Borrowings', 'slug' => 'borrowings.create', 'group' => 'borrowings'],
            ['name' => 'Edit Borrowings', 'slug' => 'borrowings.edit', 'group' => 'borrowings'],
            ['name' => 'Delete Borrowings', 'slug' => 'borrowings.delete', 'group' => 'borrowings'],
            
            // News Management (Super Admin only)
            ['name' => 'View News', 'slug' => 'news.view', 'group' => 'news'],
            ['name' => 'Create News', 'slug' => 'news.create', 'group' => 'news'],
            ['name' => 'Edit News', 'slug' => 'news.edit', 'group' => 'news'],
            ['name' => 'Delete News', 'slug' => 'news.delete', 'group' => 'news'],
            ['name' => 'Publish News', 'slug' => 'news.publish', 'group' => 'news'],
            
            // Users Management (Super Admin only)
            ['name' => 'View Users', 'slug' => 'users.view', 'group' => 'users'],
            ['name' => 'Create Users', 'slug' => 'users.create', 'group' => 'users'],
            ['name' => 'Edit Users', 'slug' => 'users.edit', 'group' => 'users'],
            ['name' => 'Delete Users', 'slug' => 'users.delete', 'group' => 'users'],
            ['name' => 'Assign Roles', 'slug' => 'users.assign-roles', 'group' => 'users'],
            
            // Reports
            ['name' => 'View Reports', 'slug' => 'reports.view', 'group' => 'reports'],
            ['name' => 'Export Reports', 'slug' => 'reports.export', 'group' => 'reports'],
        ];
        
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        
        // Create Roles
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Full access to all system features including user management and news publishing'
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin', 
                'description' => 'Access to library management features (books, categories, borrowings)'
            ],
            [
                'name' => 'Librarian',
                'slug' => 'librarian',
                'description' => 'Access to daily library operations (borrowings, basic book management)'
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'description' => 'Basic user access for browsing and borrowing books'
            ]
        ];
        
        foreach ($roles as $role) {
            Role::create($role);
        }
        
        // Assign permissions to roles
        $superAdmin = Role::where('slug', 'super-admin')->first();
        $admin = Role::where('slug', 'admin')->first();
        $librarian = Role::where('slug', 'librarian')->first();
        $user = Role::where('slug', 'user')->first();
        
        // Super Admin gets all permissions
        $allPermissions = Permission::all();
        $superAdmin->permissions()->attach($allPermissions->pluck('id'));
        
        // Admin gets library management permissions
        $adminPermissions = Permission::whereIn('group', ['dashboard', 'books', 'categories', 'borrowings', 'reports'])->get();
        $admin->permissions()->attach($adminPermissions->pluck('id'));
        
        // Librarian gets basic operations permissions
        $librarianPermissions = Permission::whereIn('slug', [
            'dashboard.view', 'books.view', 'books.edit', 'categories.view',
            'borrowings.view', 'borrowings.create', 'borrowings.edit'
        ])->get();
        $librarian->permissions()->attach($librarianPermissions->pluck('id'));
        
        // User gets basic view permissions
        $userPermissions = Permission::whereIn('slug', [
            'books.view', 'categories.view'
        ])->get();
        $user->permissions()->attach($userPermissions->pluck('id'));
        
        // Assign super admin role to admin user
        $adminUser = User::where('email', 'admin@ppic.ac.id')->first();
        if ($adminUser) {
            $adminUser->assignRole('super-admin');
        }
        
        // Assign user role to test user
        $testUser = User::where('email', 'test@example.com')->first();
        if ($testUser) {
            $testUser->assignRole('user');
        }
    }
}
