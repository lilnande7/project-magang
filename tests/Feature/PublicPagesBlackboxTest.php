<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesBlackboxTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test jika halaman utama dapat diakses.
     */
    public function test_home_page_can_be_accessed(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Perpustakaan'); // Assuming "Perpustakaan" appears on home
    }

    /**
     * Test jika halaman berita dapat diakses.
     */
    public function test_news_page_can_be_accessed(): void
    {
        $response = $this->get('/berita');
        $response->assertStatus(200);
    }

    /**
     * Test jika halaman profil dan sub-halamannya dapat diakses.
     */
    public function test_profile_pages_can_be_accessed(): void
    {
        $pages = [
            '/profile',
            '/profile/sejarah',
            '/profile/struktur-organisasi',
            '/profile/visi-misi',
            '/profile/tata-tertib',
            '/profile/akreditasi',
            '/profile/npp',
        ];

        foreach ($pages as $page) {
            $response = $this->get($page);
            $response->assertStatus(200);
        }
    }

    /**
     * Test jika halaman hubungi kami dapat diakses.
     */
    public function test_contact_page_can_be_accessed(): void
    {
        $response = $this->get('/hubungikami');
        $response->assertStatus(200);
    }

    /**
     * Test jika halaman galeri dapat diakses.
     */
    public function test_gallery_page_can_be_accessed(): void
    {
        $response = $this->get('/galeri0');
        $response->assertStatus(200);
    }

    /**
     * Test jika halaman layanan dialihkan (redirect) ke galeri0.
     */
    public function test_layanan_redirects_to_gallery(): void
    {
        $response = $this->get('/layanan');
        $response->assertStatus(301);
        $response->assertRedirect('/galeri0');
    }

    /**
     * Test jika halaman OPAC dapat diakses.
     */
    public function test_opac_page_can_be_accessed(): void
    {
        $response = $this->get('/opac');
        $response->assertStatus(200);
    }
}
