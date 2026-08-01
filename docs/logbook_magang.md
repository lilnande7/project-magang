# 📋 LOGBOOK MAGANG MINGGUAN

## Informasi Mahasiswa

| Keterangan            | Detail                                                          |
| --------------------- | --------------------------------------------------------------- |
| **Nama**              | *(Nama Mahasiswa)*                                              |
| **NIM**               | *(NIM Mahasiswa)*                                               |
| **Program Studi**     | *(Program Studi)*                                               |
| **Perguruan Tinggi**  | *(Nama Perguruan Tinggi)*                                       |
| **Tempat Magang**     | Perpustakaan Politeknik Penerbangan Indonesia Curug (PPI Curug) |
| **Pembimbing Magang** | *(Nama Pembimbing)*                                             |
| **Periode Magang**    | 9 Maret 2026 – 30 Juli 2026                                    |
| **Proyek**            | Pengembangan Website Perpustakaan Digital Avialib PPI Curug     |

---

## Minggu 1

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 9 Maret 2026 – 13 Maret 2026                                        |
| **Kegiatan**       | Orientasi & Mempelajari Konsep Dasar                                 |

### Rincian Kegiatan

1. **Orientasi tempat magang** — Perkenalan dengan tim perpustakaan PPI Curug, memahami struktur organisasi perpustakaan, dan memahami alur kerja operasional perpustakaan (sirkulasi, referensi, katalogisasi).
2. **Mempelajari konsep dasar framework Laravel** — Memahami arsitektur MVC (Model-View-Controller), routing system, Blade templating engine, Eloquent ORM, dan migration database pada Laravel 11.
3. **Mempelajari struktur panel admin** — Menganalisis kebutuhan fitur admin panel untuk manajemen perpustakaan digital, termasuk dashboard, CRUD data buku, manajemen pengguna, dan sistem peminjaman.
4. **Studi kebutuhan sistem** — Berdiskusi dengan pembimbing mengenai fitur-fitur yang dibutuhkan pada website perpustakaan, meliputi katalog online (OPAC), peminjaman buku daring, portal berita, dan halaman profil perpustakaan.
5. **Mempelajari konsep RESTful API** — Memahami konsep REST API yang akan digunakan untuk fitur chatbot dan integrasi data katalog.

### Hasil / Output
- Catatan ringkasan arsitektur Laravel MVC
- Daftar kebutuhan fitur website perpustakaan
- Pemahaman dasar Blade template dan Eloquent ORM

---

## Minggu 2

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 16 Maret 2026 – 20 Maret 2026                                       |
| **Kegiatan**       | Setup Project & Environment Development                              |

### Rincian Kegiatan

1. **Inisialisasi project Laravel 11** — Membuat project baru menggunakan Composer (`composer create-project laravel/laravel`), konfigurasi file `.env` untuk koneksi database, mail, dan app key.
2. **Setup Docker environment** — Membuat file `docker-compose.yml` dengan konfigurasi services:
   - **App container** (PHP 8.2 + Laravel)
   - **MySQL database** container
   - **Nginx** web server sebagai reverse proxy
   - **phpMyAdmin** untuk manajemen database
3. **Konfigurasi Nginx** — Membuat konfigurasi Nginx (`nginx/default.conf`) untuk mengarahkan request ke Laravel application.
4. **Konfigurasi PHP** — Menyiapkan custom `php.ini` dengan pengaturan upload file size, memory limit, dan ekstensi yang dibutuhkan.
5. **Instalasi dependencies frontend** — Setup `package.json` dengan Vite sebagai build tool, instalasi Laravel Vite plugin, dan konfigurasi `vite.config.js`.
6. **Testing environment** — Memastikan semua container Docker berjalan dengan baik, database terkoneksi, dan halaman default Laravel dapat diakses melalui browser.

### Hasil / Output
- Project Laravel 11 terinstall dan berjalan
- Docker environment lengkap (docker-compose.yml, Dockerfile)
- Konfigurasi Nginx dan PHP
- Vite build tool terkonfigurasi

---

## Minggu 3

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 23 Maret 2026 – 27 Maret 2026                                       |
| **Kegiatan**       | Perancangan Database & Wireframe UI                                  |

### Rincian Kegiatan

1. **Perancangan skema database** — Merancang Entity Relationship Diagram (ERD) untuk seluruh entitas sistem perpustakaan, meliputi: `users`, `roles`, `permissions`, `books`, `categories`, `borrowings`, `news`, `complaints`, `visitor_logs`, dan `user_activity_logs`.
2. **Membuat migration database** — Implementasi migration Laravel untuk tabel:
   - `users` — Data pengguna (nama, email, password, avatar)
   - `roles` & `permissions` — Sistem role-based access control (super-admin, admin, librarian, user)
   - `role_user` & `permission_role` — Tabel pivot many-to-many
   - `categories` — Kategori buku (nama, slug, deskripsi, status aktif)
   - `books` — Data buku (judul, pengarang, ISBN, penerbit, tahun, status, stok, cover, lokasi rak, dll.)
3. **Membuat wireframe UI** — Mendesain wireframe low-fidelity menggunakan Figma untuk seluruh halaman website:
   - Homepage (hero, about, layanan, katalog preview, berita)
   - Halaman Login & Register
   - Halaman Katalog & Detail Buku
   - Halaman Berita & Detail Berita
   - Halaman Layanan & Hubungi Kami
   - Admin Dashboard, Admin Katalog, Admin Pesan
   - Chatbot Widget (closed & opened state)
4. **Review wireframe** — Presentasi wireframe kepada pembimbing dan mendapatkan feedback untuk perbaikan layout.

### Hasil / Output
- ERD (Entity Relationship Diagram) database
- 12 file migration database
- 12 wireframe UI halaman utama (tersimpan di `docs/wireframes/`)
- Approval desain dari pembimbing

---

## Minggu 4

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 30 Maret 2026 – 3 April 2026                                        |
| **Kegiatan**       | Membuat Layout Utama, Navbar & Footer                                |

### Rincian Kegiatan

1. **Membuat master layout (`layouts/app.blade.php`)** — Membangun layout utama website dengan integrasi:
   - Bootstrap 3 & Bootstrap 5 (hybrid untuk kompatibilitas)
   - Google Fonts (Playfair Display, Space Grotesk, Poppins)
   - FontAwesome 6 & Bootstrap Icons untuk iconography
   - Custom CSS dengan animasi (`animate.css`, `bootsnav.css`)
   - Meta tags SEO dan Open Graph
2. **Membuat komponen Navbar (`partials/navbar.blade.php`)** — Membangun navigasi utama dengan fitur:
   - Top bar informasi (telepon, email, jam operasional, NPP, social media)
   - Logo dan menu navigasi utama (Home, Profile, Layanan Kami, Hubungi Kami, OPAC, Kerjasama)
   - Dropdown menu untuk Profile (Sejarah, Struktur Organisasi, Visi Misi, dll.)
   - Megamenu untuk Layanan Kami (E-Resource, Sarana Informasi, Layanan)
   - Dropdown Kerjasama (link ke perpustakaan mitra penerbangan)
   - Responsive hamburger menu untuk mobile
   - Login button / User greeting untuk authenticated user
3. **Membuat komponen Footer (`partials/footer.blade.php`)** — Footer multi-kolom dengan informasi kontak, quick links, jam operasional, dan social media.
4. **Implementasi Bootsnav** — Konfigurasi plugin navigasi Bootsnav untuk efek sticky navbar, transparent-to-solid on scroll, dan smooth dropdown animation.

### Hasil / Output
- Master layout `app.blade.php` dengan integrasi CSS/JS libraries
- Navbar responsive dengan dropdown & megamenu
- Footer informatif
- Navigasi berfungsi baik di desktop dan mobile

---

## Minggu 5

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 6 April 2026 – 10 April 2026                                        |
| **Kegiatan**       | Pengembangan Halaman Home (Landing Page)                             |

### Rincian Kegiatan

1. **Membuat Hero Section** — Implementasi hero section full-screen dengan fitur:
   - Dynamic background image slideshow (4 gambar rotasi otomatis)
   - Animated pill badge "Perpustakaan Digital Aviasi"
   - Rotating title text animation ("Perpustakaan" → "Knowledge Hub" → "Digital Library" → "Aviation Archive")
   - Subtitle deskriptif dan CTA buttons ("Lihat Profil", "Katalog Online")
   - Real-time operational schedule card
   - Latest news preview card overlay
2. **Membuat Search & Discovery Section** — Implementasi search bar yang terhubung langsung ke sistem OPAC SLiMS (`digilib.ppicurug.ac.id`).
3. **Membuat Featured Services Section** — 3 kartu layanan interaktif: Profil & Tata Tertib, Layanan Referensi (sirkulasi, ruang baca, repositori tugas akhir, Wi-Fi), dan Akses Digital.
4. **Membuat About Section** — Overview perpustakaan PPI Curug dengan foto kartu visual dan timeline highlights fasilitas.
5. **Membuat Top Categories Section** — Grid kategori buku dengan live counting jumlah koleksi dari database.
6. **Membuat News Section** — Spotlight berita harian dengan layout gambar besar + excerpt, dan 3-kolom feed kartu berita terbaru.
7. **Implementasi GSAP animations** — Menambahkan smooth scroll animations dan reveal effects untuk setiap section menggunakan GSAP (GreenSock Animation Platform).

### Hasil / Output
- Halaman Home lengkap dengan 6+ section
- Hero section animatif dengan slideshow & rotating text
- Search bar terintegrasi OPAC
- Animasi scroll GSAP
- Responsive design untuk semua ukuran layar

---

## Minggu 6

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 13 April 2026 – 17 April 2026                                       |
| **Kegiatan**       | Pengembangan Halaman Home (Lanjutan) & Tim Pustakawan                |

### Rincian Kegiatan

1. **Membuat section Tim Pustakawan** — Grid kartu pustakawan dengan fitur:
   - Avatar/inisial nama pustakawan
   - Jabatan dan peran utama
   - Tombol kontak email
   - Badge jadwal shift dan status response
2. **Membuat section Virtual Tour & Social Media** — Integrasi embed:
   - Video YouTube profil perpustakaan (`GFn7Ql5NO9U`)
   - Instagram Reels embed (`@avialib_ppicurug`)
3. **Membuat CTA (Call-to-Action) Section** — Banner ajakan dengan tombol navigasi ke halaman katalog dan hubungi kami.
4. **Implementasi Model & Controller** — Membuat:
   - `HomeController` untuk mengambil data dinamis (kategori, berita terbaru, statistik koleksi)
   - Query Eloquent untuk counting buku per kategori
   - Query berita terbaru yang berstatus `published`
5. **Optimasi performa halaman Home** — Lazy loading gambar, minifikasi CSS/JS, dan optimasi query database dengan eager loading.
6. **Cross-browser testing** — Pengujian tampilan di Chrome, Firefox, Safari, dan Edge. Perbaikan kompatibilitas CSS.

### Hasil / Output
- Halaman Home selesai 100% dengan semua section
- Data dinamis dari database (kategori, berita, statistik)
- Embed YouTube & Instagram
- Performa halaman optimal

---

## Minggu 7

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 20 April 2026 – 24 April 2026                                       |
| **Kegiatan**       | Pengembangan Modul Profil Perpustakaan                               |

### Rincian Kegiatan

1. **Membuat halaman Profil Utama (`profile/index.blade.php`)** — Halaman overview profil perpustakaan dengan kartu Visi & Misi dan ringkasan informasi umum.
2. **Membuat halaman Sejarah (`profile/sejarah.blade.php`)** — Timeline interaktif sejarah perpustakaan PPI Curug dari tahun 1952 (API Curug) hingga era digital dengan SLiMS & e-resources. Termasuk kartu "Tahukah Anda?" untuk trivia.
3. **Membuat halaman Struktur Organisasi (`profile/struktur-organisasi.blade.php`)** — Bagan struktur organisasi, tabel kepemimpinan (Kepala Perpustakaan, Pustakawan, Staff Admin), serta daftar tugas dan fungsi.
4. **Membuat halaman Visi & Misi (`profile/visi-misi.blade.php`)** — Dokumentasi lengkap visi dan misi perpustakaan dengan desain kartu visual.
5. **Membuat halaman Tata Tertib (`profile/tata-tertib.blade.php`)** — Peraturan umum (loker, zona tenang, dress code), tabel aturan peminjaman (maks 3 buku, durasi 7 hari, perpanjangan 1x, denda Rp 1.000/hari), info box sanksi, dan tabel jam operasional.
6. **Membuat halaman Akreditasi (`profile/akreditasi.blade.php`)** — Status akreditasi Perpusnas RI, tabel riwayat akreditasi, daftar standar evaluasi, dan display sertifikat.
7. **Membuat halaman NPP (`profile/npp.blade.php`)** — Badge Nomor Pokok Perpustakaan (`3603202C0000001`), tabel metadata sertifikasi Perpusnas RI.

### Hasil / Output
- 7 halaman profil perpustakaan lengkap
- Timeline interaktif sejarah
- Bagan struktur organisasi
- Tabel aturan peminjaman dan jam operasional
- Halaman akreditasi dan NPP

---

## Minggu 8

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 27 April 2026 – 1 Mei 2026                                          |
| **Kegiatan**       | Sistem Autentikasi & Role-Based Access Control                       |

### Rincian Kegiatan

1. **Membuat Model User & Role** — Implementasi:
   - Model `User` dengan relasi `belongsToMany(Role)` dan `hasMany(Borrowing)`
   - Model `Role` dengan field `name`, `slug` (super-admin, admin, librarian, user), `description`, `is_active`
   - Model `Permission` dengan relasi ke Role
   - Tabel pivot `role_user` dan `permission_role`
2. **Membuat halaman Login (`auth/login.blade.php`)** — Form login dengan desain floating card modern, gradient purple/blue, field email & password, checkbox "Remember Me", validasi feedback, dan link navigasi ke register/home.
3. **Membuat halaman Register (`auth/register.blade.php`)** — Form registrasi dengan field nama, email, password, konfirmasi password, validasi real-time, dan auto-assign role "user" setelah registrasi.
4. **Implementasi AuthController** — Logic login/register/logout menggunakan Laravel Auth:
   - `LoginController` — Validasi kredensial, redirect berdasarkan role
   - `RegisterController` — Registrasi user baru, hash password, assign default role
   - Middleware `auth` dan custom middleware role checking
5. **Implementasi Middleware CheckRole** — Custom middleware untuk mengecek role user sebelum mengakses halaman admin. Hanya role `super-admin`, `admin`, dan `librarian` yang dapat mengakses dashboard admin.
6. **Membuat migration tambahan** — Migration untuk tabel `roles`, `permissions`, `role_user`, `permission_role`, dan seeder untuk role default.

### Hasil / Output
- Sistem autentikasi (login, register, logout) berfungsi
- Role-Based Access Control (RBAC) dengan 4 level role
- Middleware proteksi halaman admin
- Halaman login & register dengan desain modern

---

## Minggu 9

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 4 Mei 2026 – 8 Mei 2026                                             |
| **Kegiatan**       | Pengembangan Admin Layout & Dashboard                                |

### Rincian Kegiatan

1. **Membuat Admin Layout (`admin/layout.blade.php`)** — Template layout admin panel dengan:
   - Top bar dengan judul "Admin Panel" dan user dropdown (nama, avatar, logout)
   - Sidebar navigasi collapsible dengan icon dan menu:
     - Dashboard, Kelola Buku, Peminjaman, Berita, Pengguna, Aduan/Keluhan, Visitor Log
   - Area konten utama responsive
   - Integrasi Bootstrap 5, DataTables, Chart.js 4.4
2. **Membuat Dashboard Admin (`admin/dashboard.blade.php`)** — Halaman dashboard dengan:
   - **KPI Summary Cards**: Total Buku, Total Pengguna, Total Berita, Peminjaman Aktif (data real-time dari database)
   - **Grafik Statistik Pengunjung**: Chart.js line chart data visitor bulanan per tahun, dengan filter tahun dan tombol Export Excel
   - **Panel Aktivitas Terbaru**: Daftar berita terbaru, buku terbaru ditambahkan, kategori populer
   - **Panel Log Aktivitas Akun**: Audit trail dari `user_activity_logs` (admin actions)
   - **Quick Action Grid**: Shortcut tombol ke Tambah Buku, Buat Berita, Kelola Buku, Kelola Pengguna, Preview Site
3. **Implementasi DashboardController** — Logic pengambilan data statistik:
   - Count total buku, pengguna, berita, peminjaman aktif
   - Query visitor logs per bulan dengan grouping
   - Query recent activities dari `user_activity_logs`
4. **Implementasi VisitorLog model & tracking** — Membuat middleware `TrackVisitor` untuk mencatat setiap kunjungan halaman publik (session ID, IP, user agent, path, referer).

### Hasil / Output
- Admin layout dengan sidebar navigasi
- Dashboard admin interaktif dengan KPI cards
- Grafik Chart.js statistik pengunjung
- Sistem visitor tracking otomatis

---

## Minggu 10

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 11 Mei 2026 – 15 Mei 2026                                           |
| **Kegiatan**       | Admin — CRUD Kelola Buku (Books Management)                          |

### Rincian Kegiatan

1. **Membuat Model Book & Category** — Implementasi:
   - Model `Book` dengan field lengkap: title, author, isbn, publisher, year, pages, language, description, location, status (available/borrowed/maintenance/lost), category_id, cover_image, cover_url, subjects, topics, call_number, classification, series_title, collation, gmd_name, place_name, item_code, stock
   - Model `Category` dengan relasi `hasMany(Book)`
   - Relasi `Book belongsTo Category`
2. **Membuat halaman Index Buku (`admin/books/index.blade.php`)** — Tabel data buku menggunakan DataTables dengan kolom: thumbnail cover, judul, pengarang, ISBN, kategori, status (badge warna), stok, dan aksi (lihat/edit/hapus). Dilengkapi filter pencarian dan filter kategori.
3. **Membuat form Tambah/Edit Buku (`admin/books/create.blade.php`, `edit.blade.php`, `partials/form.blade.php`)** — Form reusable partial dengan field: judul, pengarang, ISBN, penerbit, tahun, halaman, bahasa, lokasi rak, status dropdown, kategori select, subjek, stok, dan upload gambar cover.
4. **Membuat halaman Detail Buku (`admin/books/show.blade.php`)** — Tampilan detail lengkap metadata buku dan riwayat peminjaman buku tersebut.
5. **Implementasi BookController** — CRUD lengkap: index (dengan search & filter), create, store (dengan upload gambar), show, edit, update, destroy. Termasuk validasi input dan logging aktivitas.
6. **Implementasi upload & storage gambar** — Konfigurasi Laravel Storage untuk upload cover buku dengan resize dan validasi format file.

### Hasil / Output
- CRUD Buku lengkap (Create, Read, Update, Delete)
- DataTables dengan pencarian dan filter
- Upload gambar cover buku
- Form reusable partial
- Validasi input dan error handling

---

## Minggu 11

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 18 Mei 2026 – 22 Mei 2026                                           |
| **Kegiatan**       | Admin — CRUD Kelola Berita (News Management)                         |

### Rincian Kegiatan

1. **Membuat Model News** — Implementasi model dengan field: title, slug (auto-generate), excerpt, content (HTML), featured_image, status (draft/published/archived), is_featured (toggle untuk spotlight homepage), published_at, author_id, tags, views_count. Relasi `belongsTo(User, 'author_id')`.
2. **Membuat migration tabel `news`** — Migration dengan semua kolom yang diperlukan termasuk `is_featured` boolean dan `views_count` integer.
3. **Membuat halaman Index Berita (`admin/news/index.blade.php`)** — Tabel daftar berita dengan kolom: gambar, judul, kategori/tags, tanggal publish, status badge (draft/published/archived), featured toggle, dan aksi. Dilengkapi filter status dan pencarian.
4. **Membuat form Tambah/Edit Berita (`admin/news/create.blade.php`, `edit.blade.php`)** — Form dengan field: judul, slug (auto-generate dari judul), excerpt, konten HTML (textarea), upload featured image, status dropdown, toggle is_featured, tags input, dan tanggal publish. Tersedia tombol "Publish Now" untuk langsung publish.
5. **Membuat halaman Detail Berita Admin (`admin/news/show.blade.php`)** — Preview berita dengan informasi lengkap: tanggal publish, author, status, jumlah views, dan konten formatted.
6. **Implementasi NewsController (Admin)** — CRUD lengkap: index, create, store, show, edit, update, destroy. Logic auto-generate slug, upload featured image, dan update status.

### Hasil / Output
- CRUD Berita lengkap dengan status management
- Toggle featured news untuk spotlight homepage
- Auto-generate slug dari judul
- Upload featured image
- Preview berita di admin panel

---

## Minggu 12

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 25 Mei 2026 – 29 Mei 2026                                           |
| **Kegiatan**       | Halaman Katalog Publik & Detail Buku                                 |

### Rincian Kegiatan

1. **Membuat halaman Katalog Publik (`catalog/index.blade.php`)** — Halaman pencarian dan browsing buku untuk pengguna umum dengan fitur:
   - **Search bar** multi-field: pencarian berdasarkan judul, pengarang, ISBN, topik, call number, penerbit (parameter `q`)
   - **Multi-filter**: Filter kategori, ketersediaan (tersedia/dipinjam/maintenance), bahasa, dan urutan sort (A-Z Judul, Terbaru, Terlama, A-Z Pengarang)
   - **Grid kartu buku**: Cover image (dengan fallback support jika cover custom atau URL SLiMS remote), nama pengarang, penerbit & tahun, call number, badge status stok, dan tombol "Lihat Detail"
   - **Tombol "Riwayat Peminjaman Saya"** untuk user yang sudah login
2. **Membuat halaman Detail Buku (`catalog/show.blade.php`)** — Halaman detail dengan:
   - Breadcrumb navigasi
   - **Metadata bibliografi lengkap**: Judul, Pengarang, Kategori, Status & Stok, ISBN/ISSN, Penerbit, Kota terbit, Tahun, Kolasi fisik, Call number, Klasifikasi DDC, Judul seri, Topik/Subjek, Lokasi rak
   - **Kartu request peminjaman interaktif** (detail di minggu berikutnya)
   - **Carousel buku terkait**: Menampilkan hingga 4 buku dari kategori yang sama
3. **Implementasi CatalogController** — Logic untuk:
   - Index dengan multi-parameter search dan filtering
   - Show detail buku dengan relasi eager loading
   - Query buku terkait berdasarkan kategori
4. **Optimasi query** — Implementasi eager loading (`with('category')`) dan pagination untuk performa.

### Hasil / Output
- Halaman katalog publik dengan multi-search & filter
- Halaman detail buku dengan metadata lengkap
- Carousel buku terkait
- Query teroptimasi dengan eager loading

---

## Minggu 13

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 1 Juni 2026 – 5 Juni 2026                                           |
| **Kegiatan**       | Sistem Peminjaman Buku Online                                        |

### Rincian Kegiatan

1. **Membuat Model Borrowing** — Implementasi model dengan field: user_id, book_id, requested_at, borrowed_at, due_date, returned_at, status (pending/active/returned/overdue/rejected), fine_amount, notes, approved_by, approved_at, rejection_reason. Relasi: `belongsTo(User)`, `belongsTo(Book)`, `belongsTo(User, 'approved_by')`.
2. **Membuat migration tabel `borrowings`** — Migration dengan semua kolom termasuk foreign keys ke tabel users dan books.
3. **Implementasi fitur request peminjaman di halaman Detail Buku** — Logic pada `catalog/show.blade.php`:
   - Jika **Guest** (belum login): Tampilkan prompt "Login diperlukan" dengan tombol login
   - Jika **User login**: Cek eligibility (maksimal 3 peminjaman aktif/pending). Jika eligible, tampilkan form request dengan textarea catatan opsional dan tombol submit. Jika sudah ada request pending atau sedang meminjam buku yang sama, tampilkan status alert dengan opsi batalkan request
4. **Membuat halaman Riwayat Peminjaman (`catalog/my-borrowings.blade.php`)** — Dashboard peminjaman user dengan:
   - **Summary status pills**: Pending, Aktif, Overdue, Dikembalikan, Ditolak
   - **Daftar kartu peminjaman**: Thumbnail buku, tanggal request, tanggal pinjam, tanggal jatuh tempo (highlight overdue dalam hitungan hari), tanggal kembali, catatan, alasan penolakan (jika ditolak), jumlah denda dalam Rupiah
   - Fitur batalkan request yang masih pending
5. **Implementasi BorrowingController (User)** — Logic store (request peminjaman), cancel (batalkan pending), dan halaman my-borrowings.

### Hasil / Output
- Sistem request peminjaman buku online
- Validasi eligibility (maks 3 buku)
- Halaman riwayat peminjaman user
- Fitur cancel request pending
- Kalkulasi denda otomatis

---

## Minggu 14

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 8 Juni 2026 – 12 Juni 2026                                          |
| **Kegiatan**       | Admin — Approval Peminjaman & Manajemen Sirkulasi                    |

### Rincian Kegiatan

1. **Membuat halaman Admin Peminjaman (`admin/borrowings/index.blade.php`)** — Halaman manajemen peminjaman dengan:
   - **Filter tabs status & counting**: Pending Requests, Active Loans, Overdue Loans, Returned, Rejected — masing-masing menampilkan jumlah real-time
   - Tabel data peminjaman dengan informasi peminjam, buku, tanggal, status, dan aksi
2. **Membuat halaman Detail Peminjaman (`admin/borrowings/show.blade.php`)** — Detail lengkap transaksi peminjaman dengan aksi admin.
3. **Implementasi Workflow Approval** — Logic approval peminjaman:
   - **Approve** (`POST /admin/peminjaman/{id}/approve`): Admin menentukan durasi peminjaman dalam hari (default 7 hari) dan catatan opsional. Sistem menghitung `due_date`, mengubah status menjadi `active`, memperbarui status buku menjadi `borrowed` jika stok habis, dan mencatat log aktivitas
   - **Reject** (`POST /admin/peminjaman/{id}/reject`): Admin memasukkan alasan penolakan, status diubah menjadi `rejected`, log aktivitas dicatat
   - **Return Book** (`POST /admin/peminjaman/{id}/return`): Admin menandai buku dikembalikan, sistem menghitung denda otomatis (Rp 1.000/hari keterlambatan), set `returned_at`, kembalikan status buku ke `available`, dan catat log
4. **Implementasi AdminBorrowingController** — Controller lengkap dengan method: index, show, approve, reject, return. Termasuk validasi dan activity logging.
5. **Implementasi UserActivityLog** — Model dan migration untuk tabel `user_activity_logs` yang mencatat setiap aksi admin (admin_id, target_user_id, action, description, meta JSON).

### Hasil / Output
- Halaman admin peminjaman dengan filter status
- Workflow approval (approve/reject/return)
- Kalkulasi denda otomatis Rp 1.000/hari
- Activity logging untuk setiap aksi admin
- Manajemen stok buku otomatis

---

## Minggu 15

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 15 Juni 2026 – 19 Juni 2026                                         |
| **Kegiatan**       | Halaman Berita Publik & Detail Artikel                               |

### Rincian Kegiatan

1. **Membuat halaman Berita Publik (`news/index.blade.php`)** — Halaman daftar berita dengan layout:
   - **Featured article layout**: Artikel utama dengan gambar besar dan excerpt, ditampilkan prominent di bagian atas
   - **Sidebar highlighted news**: Daftar berita pilihan di samping artikel utama
   - **Multi-column grid**: Grid berita responsif menampilkan semua artikel yang berstatus `published`
   - **Pagination**: Navigasi halaman untuk berita dalam jumlah banyak
   - **Category filter**: Filter berdasarkan kategori/tags
2. **Membuat halaman Detail Berita (`news/show.blade.php`)** — Halaman artikel lengkap dengan:
   - Tanggal publish, nama penulis, kategori badge
   - Featured image full-width
   - Konten artikel formatted HTML
   - Views counter (increment setiap kali dibaca)
   - Share buttons (Facebook, Twitter, WhatsApp)
   - Section "Berita Terkait" di bawah artikel
3. **Implementasi NewsController (Public)** — Logic untuk:
   - Index: Query berita published, featured, dengan pagination dan filter
   - Show: Tampilkan detail artikel, increment views_count, dan ambil berita terkait
4. **Implementasi SEO** — Penambahan meta tags dinamis per artikel (title, description, og:image) untuk optimasi search engine dan social media sharing.

### Hasil / Output
- Halaman daftar berita dengan featured layout
- Halaman detail artikel dengan share buttons
- Views counter otomatis
- SEO meta tags dinamis
- Berita terkait berdasarkan kategori

---

## Minggu 16

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 22 Juni 2026 – 26 Juni 2026                                         |
| **Kegiatan**       | Halaman Layanan, Hubungi Kami & Galeri                               |

### Rincian Kegiatan

1. **Membuat halaman Layanan / Galeri (`layanan/index.blade.php`)** — Halaman informasi layanan perpustakaan dengan:
   - **Services Overview**: 3 kartu layanan utama — Sirkulasi & Helpdesk, Referensi Digital, Program Literasi
   - **Guided Experience Section**: Alur layanan 3 langkah (Orientation Desk → Discovery Session → Collaborative Follow-up) dengan visual flow
   - **Facility Detail Section**: Kartu detail fasilitas — Zona Riset Teknologi, Digital Learning Hub, dan Collaborative Lounge
2. **Membuat halaman Hubungi Kami (`hubungikami/index.blade.php`)** — Halaman kontak dengan:
   - **Hero section** dengan heading dan deskripsi
   - **Form kontak**: Field nama lengkap, email, dan pesan
   - **Detail lokasi**: Alamat lengkap, jam operasional
   - **Embedded Google Maps**: iframe interaktif menunjukkan lokasi Bandara Budiarto Curug
3. **Implementasi ContactController** — Logic pengiriman form kontak:
   - Mencoba mengirim email via SMTP menggunakan `ContactMail` Mailable
   - **Fallback mechanism**: Jika pengiriman email gagal (offline/SMTP error), secara otomatis menyimpan pesan ke tabel `complaints` di database dengan status `masuk`, sehingga admin tetap dapat membaca pesan melalui dashboard
4. **Membuat Model Complaint** — Model dengan field: name, email, message, status (masuk/diproses/selesai), ip, user_agent, admin_id, processed_at, completed_at.
5. **Membuat ContactMail Mailable** — Email template untuk mengirim notifikasi pesan kontak masuk ke staff perpustakaan.

### Hasil / Output
- Halaman Layanan dengan overview dan alur layanan
- Halaman Hubungi Kami dengan form kontak
- Embedded Google Maps
- Sistem pengiriman email dengan fallback ke database
- Model Complaint untuk tracking pesan

---

## Minggu 17

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 29 Juni 2026 – 3 Juli 2026                                          |
| **Kegiatan**       | Admin — Manajemen Pengguna & Keluhan                                 |

### Rincian Kegiatan

1. **Membuat halaman Admin Users (`admin/users/index.blade.php`)** — Halaman kelola pengguna dengan:
   - **Stats row**: Total Users, Verified Users, Admin Users, Active Borrowers
   - Tabel daftar pengguna dengan kolom: avatar, nama, email, role badge, status verifikasi, dan aksi
   - Pencarian dan filter berdasarkan role
2. **Membuat form Tambah/Edit User (`admin/users/create.blade.php`, `edit.blade.php`, `partials/form-fields.blade.php`)** — Form dengan:
   - Field: Nama, Email, Password, toggle verifikasi email, upload avatar
   - **Multi-role assignment**: Checkboxes untuk assign role (super-admin, admin, librarian, user)
   - **Protection rules**: Tidak bisa menghapus akun sendiri, tidak bisa menghapus Super Admin terakhir, non-super-admin tidak bisa mengedit akun Super Admin
3. **Implementasi UserController (Admin)** — CRUD pengguna lengkap dengan validasi role dan protection rules.
4. **Membuat halaman Admin Keluhan (`admin/complaints/index.blade.php`)** — Halaman manajemen aduan/keluhan dengan:
   - Filter status: Masuk, Diproses, Selesai
   - Tabel pesan masuk dengan info pengirim, subjek, tanggal, status
5. **Membuat halaman Detail Keluhan (`admin/complaints/show.blade.php`)** — Detail pesan lengkap termasuk IP pengirim, User Agent, dan fitur update status penanganan dengan pencatatan timestamp (processed_at, completed_at).
6. **Implementasi ComplaintController (Admin)** — Logic index dengan filter, show detail, update status handling.

### Hasil / Output
- CRUD Pengguna lengkap dengan multi-role assignment
- Protection rules untuk keamanan akun admin
- Manajemen keluhan/aduan dengan tracking status
- Upload avatar pengguna
- Statistik pengguna

---

## Minggu 18

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 6 Juli 2026 – 10 Juli 2026                                          |
| **Kegiatan**       | Admin — Visitor Analytics & Export Data                               |

### Rincian Kegiatan

1. **Pengembangan fitur Visitor Analytics** — Menyempurnakan sistem tracking pengunjung dengan:
   - Model `VisitorLog` dengan field: visited_on, session_id, user_id, path, ip, user_agent, referer
   - Middleware tracking yang mencatat unique session per hari
   - Dashboard chart yang menampilkan tren pengunjung bulanan
2. **Implementasi Chart.js interaktif di Dashboard** — Grafik line chart statistik pengunjung dengan fitur:
   - Filter berdasarkan tahun (dropdown select)
   - Data bulanan (Januari–Desember) dengan jumlah pengunjung
   - Responsive chart yang menyesuaikan ukuran layar
   - Tooltip informasi detail saat hover
3. **Implementasi Export Excel** — Fitur export data pengunjung ke file Excel:
   - Route `/admin/dashboard/visitors/export`
   - Template export (`admin/exports/visitors-year.blade.php`)
   - Paramater filter tahun yang sama dengan chart
4. **Menyempurnakan Activity Log di Dashboard** — Panel log aktivitas terbaru dari seluruh admin yang menunjukkan siapa melakukan apa dan kapan (create, update, delete, approve, reject, return).
5. **Optimasi query analytics** — Menggunakan query grouping dan aggregation untuk menghitung statistik pengunjung secara efisien tanpa membebani database.

### Hasil / Output
- Visitor analytics dengan chart interaktif
- Export data pengunjung ke Excel
- Activity log admin di dashboard
- Query analytics teroptimasi
- Filter data berdasarkan tahun

---

## Minggu 19

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 13 Juli 2026 – 17 Juli 2026                                         |
| **Kegiatan**       | Integrasi Chatbot AI (Google Gemini API)                             |

### Rincian Kegiatan

1. **Membuat Chatbot Widget UI** — Implementasi floating chat widget di frontend:
   - **Floating Action Button (FAB)**: Tombol bulat "Tanya Avialib" di pojok kanan bawah halaman
   - **Chat Window**: Panel popup yang muncul saat FAB diklik, terdiri dari:
     - Header bar dengan judul "Chat with Us", avatar, dan tombol close
     - Area chat scrollable dengan bubble pesan (bot di kiri, user di kanan)
     - Input area dengan text field "Ketik pesan..." dan tombol send
   - Animasi slide-up smooth saat membuka/menutup chat window
2. **Membuat API endpoint Chatbot** — Implementasi `ChatbotController` di `routes/api.php`:
   - `POST /api/v1/chatbot` — Endpoint untuk menerima query user dan mengembalikan response AI
   - Rate limiting dan validasi input
3. **Integrasi Google Gemini API** — Koneksi ke API Gemini (`gemini-1.5-flash`):
   - Konfigurasi API key di `.env`
   - System prompt khusus perpustakaan (konteks layanan perpustakaan PPI Curug)
   - Handling request/response format JSON
4. **Integrasi Dataset SLiMS** — Memanfaatkan data katalog dari file CSV export Senayan SLiMS (`training/senayan_item_export.csv`):
   - Parsing CSV data buku (judul, call number, lokasi rak, ketersediaan)
   - Fuzzy string token matching untuk mencocokkan query user dengan data buku
   - Response chatbot yang mencakup informasi spesifik buku (judul, call number, rak, status)
5. **Membuat model ChatHistory & ChatLog** — Pencatatan riwayat percakapan chatbot untuk analisis dan improvement.

### Hasil / Output
- Chatbot widget UI dengan animasi smooth
- API endpoint chatbot berfungsi
- Integrasi Google Gemini API (`gemini-1.5-flash`)
- Fuzzy matching dengan dataset SLiMS
- Logging riwayat chat

---

## Minggu 20

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 20 Juli 2026 – 24 Juli 2026                                         |
| **Kegiatan**       | Integrasi OPAC, Kerjasama & Testing                                  |

### Rincian Kegiatan

1. **Integrasi OPAC SLiMS** — Menghubungkan website dengan sistem OPAC Senayan SLiMS:
   - Link navigasi ke `digilib.ppicurug.ac.id` untuk pencarian katalog lengkap
   - Search bar di halaman Home yang redirect ke OPAC search
   - Sinkronisasi data cover buku dari URL remote SLiMS
2. **Implementasi halaman Kerjasama** — Menu dropdown navigasi ke perpustakaan mitra penerbangan:
   - Poltekbang Palembang, Poltekbang Surabaya, API Banyuwangi
   - Poltekbang Makassar, Poltekbang Jayapura, Poltekbang Medan, BP3 Curug
3. **Pengujian fungsional (Functional Testing)** — Testing menyeluruh setiap fitur:
   - Login/Register & role-based access
   - CRUD Buku, Berita, Pengguna
   - Workflow peminjaman (request → approve → return)
   - Kalkulasi denda otomatis
   - Form kontak & fallback email
   - Chatbot AI responses
   - Visitor tracking & analytics
4. **Pengujian responsivitas (Responsive Testing)** — Testing tampilan di berbagai ukuran layar:
   - Desktop (1920px, 1366px)
   - Tablet (768px, 1024px)
   - Mobile (375px, 414px)
5. **Bug fixing** — Perbaikan bug yang ditemukan selama testing:
   - Fix validasi form
   - Fix responsive layout issues
   - Fix query performance pada halaman katalog
   - Fix chatbot error handling

### Hasil / Output
- Integrasi OPAC SLiMS berfungsi
- Halaman kerjasama dengan link mitra
- Semua fitur tested dan berfungsi
- Bug fixes dan perbaikan tampilan
- Responsive design terverifikasi

---

## Minggu 21

| Keterangan         | Detail                                                               |
| ------------------ | -------------------------------------------------------------------- |
| **Tanggal**        | 27 Juli 2026 – 30 Juli 2026                                         |
| **Kegiatan**       | Dokumentasi, Finalisasi & Deployment                                 |

### Rincian Kegiatan

1. **Penyusunan dokumentasi teknis** — Membuat dokumentasi lengkap proyek:
   - README.md dengan panduan instalasi dan konfigurasi
   - Dokumentasi API endpoint chatbot
   - Dokumentasi wireframe UI (`docs/wireframes/`)
   - Logbook magang mingguan (`docs/logbook_magang.md`)
2. **Optimasi performa** — Final optimization:
   - Minifikasi CSS dan JavaScript (`npm run build`)
   - Optimasi query database (indexing, eager loading)
   - Optimasi gambar (compression, lazy loading)
   - Caching konfigurasi Laravel (`php artisan config:cache`, `route:cache`, `view:cache`)
3. **Security hardening** — Pengecekan keamanan:
   - Validasi semua input form (XSS, SQL injection prevention)
   - CSRF protection pada semua form
   - Sanitasi output Blade (`{{ }}` vs `{!! !!}`)
   - Rate limiting pada API endpoint
   - Environment variable security (`.env` tidak di-commit ke git)
4. **Deployment preparation** — Persiapan untuk deploy ke server:
   - Konfigurasi Docker production-ready
   - Konfigurasi Nginx untuk production
   - Database migration dan seeding production
5. **Presentasi akhir** — Persiapan presentasi hasil magang kepada pembimbing:
   - Demo seluruh fitur website
   - Penjelasan arsitektur dan teknologi yang digunakan
   - Kendala yang dihadapi dan solusi yang diterapkan
   - Saran pengembangan ke depan

### Hasil / Output
- Dokumentasi teknis lengkap
- Website teroptimasi dan siap deploy
- Keamanan terverifikasi
- Docker production-ready
- Presentasi akhir magang

---

## Ringkasan Pencapaian Magang

| No  | Fitur / Modul                          | Status       |
| --- | -------------------------------------- | ------------ |
| 1   | Setup Project Laravel & Docker         | ✅ Selesai    |
| 2   | Perancangan Database (12 migration)    | ✅ Selesai    |
| 3   | Wireframe UI (12 halaman)              | ✅ Selesai    |
| 4   | Layout Utama (Navbar, Footer)          | ✅ Selesai    |
| 5   | Halaman Home (Landing Page)            | ✅ Selesai    |
| 6   | Modul Profil (7 sub-halaman)           | ✅ Selesai    |
| 7   | Sistem Autentikasi & RBAC              | ✅ Selesai    |
| 8   | Admin Dashboard & Layout               | ✅ Selesai    |
| 9   | Admin CRUD Buku                        | ✅ Selesai    |
| 10  | Admin CRUD Berita                      | ✅ Selesai    |
| 11  | Katalog Publik & Detail Buku           | ✅ Selesai    |
| 12  | Sistem Peminjaman Buku Online          | ✅ Selesai    |
| 13  | Admin Approval Peminjaman              | ✅ Selesai    |
| 14  | Halaman Berita Publik                  | ✅ Selesai    |
| 15  | Halaman Layanan & Hubungi Kami         | ✅ Selesai    |
| 16  | Admin Manajemen Pengguna & Keluhan     | ✅ Selesai    |
| 17  | Visitor Analytics & Export             | ✅ Selesai    |
| 18  | Chatbot AI (Google Gemini API)         | ✅ Selesai    |
| 19  | Integrasi OPAC SLiMS & Kerjasama      | ✅ Selesai    |
| 20  | Testing & Bug Fixing                   | ✅ Selesai    |
| 21  | Dokumentasi & Finalisasi               | ✅ Selesai    |

---

## Teknologi yang Digunakan

| Kategori             | Teknologi                                                    |
| -------------------- | ------------------------------------------------------------ |
| **Backend**          | Laravel 11, PHP 8.2+                                         |
| **Database**         | MySQL                                                        |
| **Frontend**         | Bootstrap 3 & 5, Blade Template, Vanilla CSS                 |
| **JavaScript**       | jQuery, Chart.js 4.4, DataTables, GSAP Animation             |
| **Typography**       | Playfair Display, Space Grotesk, Poppins (Google Fonts)      |
| **Icons**            | FontAwesome 6, Bootstrap Icons                               |
| **Build Tool**       | Vite (Laravel Vite Plugin)                                   |
| **DevOps**           | Docker, Docker Compose, Nginx                                |
| **AI / Chatbot**     | Google Gemini API (gemini-1.5-flash)                         |
| **Library System**   | Senayan SLiMS (OPAC Integration)                             |
| **Version Control**  | Git, GitHub                                                  |

---

*Dokumen ini dibuat sebagai catatan kegiatan harian selama periode magang.*

*Tanggal pembuatan: 30 Juli 2026*
