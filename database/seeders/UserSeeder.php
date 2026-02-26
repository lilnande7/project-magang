<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@ppic.com',
            'password' => Hash::make('password123'),
        ]);

        // Assign super-admin role
        $superAdminRole = Role::where('slug', 'super-admin')->first();
        if ($superAdminRole) {
            $superAdmin->roles()->attach($superAdminRole->id);
        }

        // Create Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@ppic.com',
            'password' => Hash::make('password123'),
        ]);

        // Assign admin role
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $admin->roles()->attach($adminRole->id);
        }

        // Create Librarian
        $librarian = User::create([
            'name' => 'Librarian PPIC',
            'email' => 'librarian@ppic.com',
            'password' => Hash::make('password123'),
        ]);

        // Assign librarian role
        $librarianRole = Role::where('slug', 'librarian')->first();
        if ($librarianRole) {
            $librarian->roles()->attach($librarianRole->id);
        }

        // Create Regular User
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@ppic.com',
            'password' => Hash::make('password123'),
        ]);

        // Assign user role
        $userRole = Role::where('slug', 'user')->first();
        if ($userRole) {
            $user->roles()->attach($userRole->id);
        }

        $this->command->info('Users created successfully!');
        $this->command->info('Super Admin: superadmin@ppic.com / password123');
        $this->command->info('Admin: admin@ppic.com / password123');
        $this->command->info('Librarian: librarian@ppic.com / password123');
        $this->command->info('User: user@ppic.com / password123');
    }
}
