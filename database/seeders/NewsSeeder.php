<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\User;
use Carbon\Carbon;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@ppic.com')->first();
        
        if (!$admin) {
            return;
        }
        
        $newsItems = [
            [
                'title' => 'Perpustakaan Digital PPIC Resmi Diluncurkan',
                'excerpt' => 'Sistem perpustakaan digital terbaru dengan fitur pencarian canggih dan akses 24/7 untuk seluruh civitas akademika.',
                'content' => '<p>Perpustakaan Politeknik Penerbangan Indonesia Curug dengan bangga mengumumkan peluncuran sistem perpustakaan digital yang baru. Sistem ini dirancang khusus untuk memenuhi kebutuhan informasi dan literasi seluruh civitas akademika PPIC.</p>

<h3>Fitur Unggulan:</h3>
<ul>
<li>Pencarian koleksi dengan teknologi AI</li>
<li>Akses 24/7 dari mana saja</li>
<li>Sistem peminjaman online</li>
<li>E-book dan jurnal digital</li>
<li>Notifikasi otomatis untuk perpanjangan</li>
</ul>

<p>Dengan sistem ini, mahasiswa dan dosen dapat mengakses lebih dari 10.000 koleksi buku, jurnal ilmiah, dan referensi digital lainnya. Sistem ini juga terintegrasi dengan database nasional dan internasional untuk memberikan akses yang lebih luas kepada sumber-sumber informasi terkini.</p>

<p>Pelatihan penggunaan sistem akan dilaksanakan setiap hari Selasa dan Kamis pukul 10.00-11.00 WIB di Ruang Perpustakaan Lantai 2.</p>',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::now()->subDays(1),
                'author_id' => $admin->id,
                'tags' => ['perpustakaan', 'digital', 'teknologi', 'layanan']
            ],
            [
                'title' => 'Workshop Literasi Digital untuk Mahasiswa Baru',
                'excerpt' => 'Program pelatihan khusus untuk mahasiswa baru tentang penggunaan sumber informasi digital dan teknik penelusuran yang efektif.',
                'content' => '<p>Dalam rangka meningkatkan kemampuan literasi digital mahasiswa baru, Perpustakaan PPIC mengadakan Workshop Literasi Digital yang akan berlangsung selama 3 hari berturut-turut.</p>

<h3>Jadwal Workshop:</h3>
<ul>
<li><strong>Hari 1:</strong> Pengenalan Sistem Perpustakaan Digital</li>
<li><strong>Hari 2:</strong> Teknik Pencarian dan Evaluasi Informasi</li>
<li><strong>Hari 3:</strong> Penulisan Karya Ilmiah dan Sitasi</li>
</ul>

<p>Workshop ini wajib diikuti oleh seluruh mahasiswa baru angkatan 2026 dan akan menjadi syarat untuk aktivasi akun perpustakaan digital. Peserta akan mendapatkan sertifikat dan panduan penggunaan sistem.</p>

<p>Pendaftaran dibuka mulai <strong>25 Februari 2026</strong> melalui sistem akademik atau langsung di meja informasi perpustakaan.</p>',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::now()->subDays(3),
                'author_id' => $admin->id,
                'tags' => ['workshop', 'literasi', 'mahasiswa', 'pelatihan']
            ],
            [
                'title' => 'Koleksi Baru: Jurnal Internasional Bidang Penerbangan',
                'excerpt' => 'Perpustakaan menambah 500+ jurnal internasional terbaru di bidang penerbangan, avionik, dan teknologi bandara.',
                'content' => '<p>Perpustakaan PPIC terus berkomitmen untuk menyediakan sumber informasi terkini dan berkualitas. Bulan ini, kami menambahkan 500+ jurnal internasional dari penerbit ternama dunia.</p>

<h3>Koleksi Jurnal Baru:</h3>
<ul>
<li>Journal of Aircraft Technology (2020-2026)</li>
<li>International Aviation Management Review</li>
<li>Aerospace Engineering Quarterly</li>
<li>Airport Operations & Technology</li>
<li>Aviation Safety Research Journal</li>
</ul>

<p>Koleksi ini dapat diakses melalui sistem perpustakaan digital dengan menggunakan akun civitas akademika PPIC. Kami juga menyediakan panduan akses dan tutorial penggunaan database jurnal internasional.</p>

<p>Untuk informasi lebih lanjut, silakan hubungi pustakawan referensi di lantai 2 atau melalui email: <strong>reference@ppic.ac.id</strong></p>',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::now()->subDays(5),
                'author_id' => $admin->id,
                'tags' => ['koleksi', 'jurnal', 'internasional', 'penerbangan']
            ],
            [
                'title' => 'Perpanjangan Jam Operasional Perpustakaan',
                'excerpt' => 'Mulai 1 Maret 2026, jam operasional perpustakaan diperpanjang hingga pukul 20.00 untuk mendukung aktivitas akademik mahasiswa.',
                'content' => '<p>Merespons kebutuhan mahasiswa untuk akses perpustakaan yang lebih fleksibel, khususnya pada masa persiapan ujian dan penyelesaian tugas akhir, Perpustakaan PPIC memperpanjang jam operasional.</p>

<h3>Jam Operasional Baru:</h3>
<ul>
<li><strong>Senin - Jumat:</strong> 07.00 - 20.00 WIB</li>
<li><strong>Sabtu:</strong> 08.00 - 16.00 WIB</li>
<li><strong>Minggu:</strong> Tutup (kecuali ada jadwal khusus)</li>
</ul>

<p>Layanan perpustakaan pada jam tambahan (16.00-20.00) meliputi:</p>
<ul>
<li>Akses ruang baca dan koleksi</li>
<li>Layanan komputer dan internet</li>
<li>Ruang diskusi kelompok</li>
<li>Layanan fotokopi (hingga 19.30)</li>
</ul>

<p>Kebijakan ini berlaku efektif mulai <strong>1 Maret 2026</strong>. Mahasiswa diharapkan mematuhi protokol keamanan dan menggunakan fasilitas dengan bijak.</p>',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::now()->subDays(7),
                'author_id' => $admin->id,
                'tags' => ['jam operasional', 'layanan', 'fasilitas', 'mahasiswa']
            ]
        ];
        
        foreach ($newsItems as $news) {
            News::create($news);
        }
    }
}
