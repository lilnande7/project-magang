<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed library data
        $this->call([
            CategorySeeder::class,
            BookSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            NewsSeeder::class,
        ]);
    }
}
