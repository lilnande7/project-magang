<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class AdminBlackboxTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper untuk membuat user dengan role tertentu.
     */
    private function createAdminUser()
    {
        $user = User::factory()->create();
        
        $role = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
        ]);
        
        $user->assignRole($role);
        $user->refresh();
        
        return $user;
    }

    /**
     * Test guest tidak dapat mengakses dashboard admin.
     */
    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');
        
        // Tergantung konfigurasi auth middleware, bisa redirect ke /login
        // atau HTTP 403 / 401.
        $response->assertRedirect('/login');
    }

    /**
     * Test user biasa tidak dapat mengakses dashboard admin.
     */
    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/admin/dashboard');
        
        // Karena bukan admin, middleware akan mengembalikan 403 Forbidden
        // Atau jika custom middleware, bisa redirect. Umumnya 403.
        $response->assertStatus(403);
    }

    /**
     * Test admin dapat mengakses dashboard admin.
     */
    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/admin/dashboard');
        
        $response->assertStatus(200);
    }

    /**
     * Test admin dapat mengakses halaman manajemen buku.
     */
    public function test_admin_can_access_books_management(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/admin/books');
        
        $response->assertStatus(200);
    }
}
