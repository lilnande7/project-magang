<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthBlackboxTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test halaman login dapat diakses.
     */
    public function test_login_page_can_be_accessed(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /**
     * Test halaman register dapat diakses.
     */
    public function test_register_page_can_be_accessed(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    /**
     * Test user dapat login dengan kredensial yang benar.
     */
    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/'); 
    }

    /**
     * Test user tidak dapat login dengan password yang salah.
     */
    public function test_user_cannot_login_with_incorrect_password(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email'); // Biasanya Laravel mengembalikan error ke 'email'
    }

    /**
     * Test proses registrasi user baru.
     */
    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'User Baru',
            'email' => 'baru@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'baru@example.com',
        ]);

        // User biasanya otomatis login setelah register
        $this->assertAuthenticated();
    }
}
