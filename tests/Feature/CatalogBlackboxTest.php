<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Category;

class CatalogBlackboxTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test halaman katalog utama dapat diakses oleh publik.
     */
    public function test_catalog_page_can_be_accessed(): void
    {
        $response = $this->get('/katalog');
        $response->assertStatus(200);
    }

    /**
     * Test jika pengunjung (guest) diredirect ke halaman login saat mencoba meminjam buku.
     */
    public function test_guest_is_redirected_to_login_when_requesting_borrow(): void
    {
        // Buat dummy book dan category jika factory tersedia,
        // jika factory tidak tersedia di project, ini akan throw error (perlu disesuaikan).
        // Kita menggunakan Book::create jika factory tidak ada, namun kita coba factory dulu.
        try {
            $category = Category::factory()->create();
            $book = Book::factory()->create(['category_id' => $category->id]);
        } catch (\Throwable $e) {
            $category = Category::create(['name' => 'Fiksi', 'slug' => 'fiksi', 'code' => 'FKS']);
            $book = Book::create([
                'title' => 'Buku Test',
                'slug' => 'buku-test',
                'author' => 'Author',
                'publisher' => 'Publisher',
                'year' => '2023',
                'isbn' => '123456789',
                'stock' => 5,
                'category_id' => $category->id,
            ]);
        }

        $response = $this->post("/katalog/{$book->id}/pinjam");
        
        // Guest harus dialihkan ke halaman login
        $response->assertRedirect('/login');
    }

    /**
     * Test pengguna yang sudah login dapat mengakses riwayat peminjamannya.
     */
    public function test_logged_in_user_can_access_my_borrowings(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/peminjaman-saya');
        
        $response->assertStatus(200);
    }
}
