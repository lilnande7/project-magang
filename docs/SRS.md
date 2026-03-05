# Software Requirements Specification (SRS)

**Project**: Portal Perpustakaan PPI Curug  
**Version**: 1.0  
**Date**: 2026-03-05  
**Authors**: Tim Pengembangan Perpustakaan Digital

---

## 1. Introduction

### 1.1 Purpose
Dokumen ini mendefinisikan kebutuhan fungsional dan non-fungsional untuk portal perpustakaan Politeknik Penerbangan Indonesia Curug (PPIC). Dokumen menjadi acuan bagi tim pengembang, QA, UI/UX, dan pemangku kepentingan dalam perencanaan fitur, implementasi, serta pengujian.

### 1.2 Scope
Sistem mencakup:
- Portal publik dengan halaman Home, Profil, Berita, Galeri, Agenda, Pengumuman, Hubungi Kami, OPAC, E-Resource, dan Kerja Sama.
- Integrasi tautan layanan eksternal (Avialib, Turnitin, Jurnal ilmiah, OPAC).
- Modul autentikasi (login, registrasi) dan manajemen sesi.
- Dashboard admin untuk mengelola koleksi buku dan berita.
- Fondasi data role & permission guna ekspansi fitur pinjam-meminjam dan personel.

### 1.3 Definitions, Acronyms, Abbreviations
| Istilah | Definisi |
| --- | --- |
| OPAC | Online Public Access Catalog perpustakaan PPIC. |
| SSO | Single Sign-On untuk layanan kampus (tidak tersedia saat ini, direncanakan). |
| CMS | Content Management System (modul admin Laravel). |
| Taruna | Mahasiswa PPIC. |
| Sivitas | Seluruh komunitas kampus (taruna, dosen, staf). |

### 1.4 References
- Struktur kode saat ini di repo `project_magang`.
- Standar Laravel 11.x & Tailwind CSS untuk UI.
- Kebijakan layanan perpustakaan PPIC.

### 1.5 Overview
Bagian selanjutnya menjelaskan gambaran sistem, fitur utama, antarmuka, kebutuhan data, dan kriteria penerimaan.

---

## 2. Overall Description

### 2.1 Product Perspective
- Aplikasi web monolitik Laravel + Blade + Tailwind.
- Backend MySQL/MariaDB (melalui Docker compose).
- Frontend responsif yang di-serve oleh Laravel + Vite asset pipeline.
- Modul admin dengan middleware `auth` dan `role`.

### 2.2 Product Functions
- Menampilkan informasi profil perpustakaan.
- Mengkurasi berita, agenda, dan pengumuman.
- Menyediakan galeri visual (mengambil konten dari halaman Layanan terdahulu).
- Menghubungkan pengguna ke OPAC, e-resource, dan tool eksternal.
- Autentikasi pengguna, registrasi, dan logout.
- Admin CRUD untuk buku dan berita.

### 2.3 User Classes & Characteristics
| Kelas Pengguna | Deskripsi |
| --- | --- |
| Pengunjung Umum | Akses seluruh halaman publik tanpa login, dapat membuka tautan eksternal. |
| Anggota Terdaftar | Memiliki akun, dapat login untuk akses fitur personal (roadmap: peminjaman). |
| Admin / Pustakawan | Role `admin` atau `super-admin`, mengelola konten buku & berita. |
| Pengelola Sistem | Tim TI yang memelihara infrastruktur, keamanan, dan deployment. |

### 2.4 Operating Environment
- Server Linux (Docker) dengan PHP 8.2+, MySQL/MariaDB 10+, Nginx.
- Browser modern (Chrome, Firefox, Edge, Safari) dengan dukungan responsif mobile ≥ iOS/Android 12.

### 2.5 Design & Implementation Constraints
- Framework Laravel, Blade templating, Tailwind CSS.
- Struktur database mengikuti migrasi yang sudah ada.
- Kebijakan keamanan kampus: semua trafik produksi harus melalui HTTPS.
- Integrasi layanan eksternal memakai tautan langsung (tanpa API) untuk fase ini.

### 2.6 Assumptions & Dependencies
- Data awal (books, categories, news) tersedia via seeder / import.
- Akses OPAC tetap berada pada domain `digilib.ppicurug.ac.id`.
- Paket autentikasi Laravel Breeze/Fortify digunakan standar.
- Rencana jangka panjang: fitur peminjaman daring dan manajemen peran granular memanfaatkan model Role & Permission yang sudah ada.

---

## 3. System Features & Functional Requirements

### SF-01 Home & Global Navigation
**Deskripsi**: Halaman beranda yang menampilkan hero, statistik, highlight layanan, kategori koleksi, berita terbaru, dan CTA ke OPAC.

**Functional Requirements**
- **FR-1.1** Navigasi utama menampilkan tautan Home, Profil, Layanan Kami (dropdown), Hubungi Kami, OPAC, E-Resource, Kerja Sama.
- **FR-1.2** Dropdown "Layanan Kami" memuat tautan ke Agenda, Berita, Galeri (route `gallery`), sub-dropdown Layanan (Avialib, Turnitin, Jurnal), dan Pengumuman.
- **FR-1.3** Bagian highlight menunjukkan tiga kartu layanan/fitur dengan ikon, ringkasan, dan CTA "Baca Selengkapnya" menuju galeri.
- **FR-1.4** Bagian kategori memuat data top categories bila tersedia; jika tidak, fallback default disediakan.
- **FR-1.5** Bagian berita menampilkan daftar ringkas news terbaru (judul, ringkasan, tautan detail).

### SF-02 Profil & Informasi Institusional
- **FR-2.1** Halaman `/profile` memuat misi, visi, timeline singkat, dan tiga pilar layanan.
- **FR-2.2** Konten dapat diperbarui melalui Blade view atau CMS masa depan.

### SF-03 Berita & Agenda
- **FR-3.1** Route `/berita` menampilkan daftar berita yang diambil dari model `News`.
- **FR-3.2** Route `/news/{id}` menampilkan halaman detail.
- **FR-3.3** Agenda/pengumuman menggunakan konten statis untuk saat ini; roadmap: sumber dari database `posts`.

### SF-04 Galeri
- **FR-4.1** Route `/galeri0` (name `gallery`) menampilkan konten eks-layanan: hero, highlight, experience, facility, CTA.
- **FR-4.2** Route `/layanan` melakukan redirect 301 ke `/galeri0` agar tautan lama valid.
- **FR-4.3** Tombol "Baca Selengkapnya" pada home harus mengarah ke `gallery`.

### SF-05 Hubungi Kami & Layanan Eksternal
- **FR-5.1** Route `/hubungikami` menampilkan detail kontak, jam operasional, dan form/CTA.
- **FR-5.2** Link OPAC membuka domain eksternal pada tab baru dengan atribut keamanan `noopener noreferrer`.
- **FR-5.3** Menu E-Resource & Kerja Sama mengarah ke halaman/tautan informatif sesuai kebutuhan konten statis.

### SF-06 Autentikasi & Role Management
- **FR-6.1** Sistem mendukung registrasi, login, dan logout standar Laravel.
- **FR-6.2** Pengguna yang login menampilkan nama dan dropdown akun (Dashboard, Logout).
- **FR-6.3** Hanya role `super-admin` atau `admin` yang bisa mengakses route `admin/*`.

### SF-07 Admin Content Management
- **FR-7.1** Admin dapat mengelola buku melalui resource controller `Admin\BookController`.
- **FR-7.2** Admin dapat mengelola berita melalui resource controller `Admin\NewsController`, termasuk aksi publish.
- **FR-7.3** Data role, permission, dan relasi user disiapkan untuk kontrol akses granular.

### SF-08 Future Enhancements (Planned)
- **FR-8.1** Modul peminjaman daring memanfaatkan model `Borrowing`.
- **FR-8.2** Integrasi pencarian OPAC langsung (API) saat endpoint tersedia.
- **FR-8.3** Dashboard statistik pemakaian layanan.

---

## 4. External Interface Requirements

### 4.1 User Interface
- Responsif untuk resolusi ≥360px.
- Navigasi sticky dengan transisi transparan → solid saat scroll.
- Dropdown mengarah ke samping kanan di desktop; fallback vertikal di mobile ≤1024px.
- Ikon Font Awesome digunakan untuk visualisasi cepat.

### 4.2 Hardware & Software Interfaces
- Server: Dockerized stack (Nginx, PHP-FPM, MySQL, Redis optional).
- Client: Browser mendukung ES6 & CSS custom properties.

### 4.3 Communications Interfaces
- HTTPS wajib pada produksi.
- Integrasi eksternal via tautan (OPAC, Avialib, Turnitin, Jurnal, digilib, Play Store).

### 4.4 Data Interfaces
- Ekspor/impor data buku dan berita via artisan/seeders.
- Ketersediaan API internal belum ditentukan; modul admin memanfaatkan Laravel resource routes.

---

## 5. Data Requirements

| Entity | Deskripsi Atribut Kunci |
| --- | --- |
| User | `id`, `name`, `email`, `password`, `status`, `remember_token`, timestamps. |
| Role | `id`, `name`, `slug`, timestamps. |
| Permission | `id`, `name`, `slug`. |
| Role_Permissions | Pivot `role_id`, `permission_id`. |
| User_Roles | Pivot `user_id`, `role_id`. |
| Book | `id`, `title`, `author`, `isbn`, `category_id`, `cover_path`, `synopsis`, `status`. |
| Category | `id`, `name`, `description`. |
| Borrowing | `id`, `user_id`, `book_id`, `borrowed_at`, `due_at`, `returned_at`, `status`. |
| News | `id`, `title`, `slug`, `excerpt`, `body`, `thumbnail_path`, `published_at`, `status`. |
| Posts (Agenda/Pengumuman) | `id`, `type`, `title`, `body`, `published_at`. |

- Seluruh tabel mengikuti standar timestamp Laravel.
- Indexing diperlukan pada kolom `slug`, `category_id`, dan relasi pivot.

---

## 6. Non-Functional Requirements

| Kategori | Requirement |
| --- | --- |
| Kinerja | Waktu respon halaman publik < 2 detik pada koneksi kampus; Lighthouse Performance ≥ 80. |
| Skalabilitas | Mendukung 500 pengguna bersamaan dengan caching (Redis) bila diaktifkan. |
| Keamanan | Password terenkripsi Bcrypt/Argon2; proteksi CSRF; role-based access; enforce HTTPS. |
| Ketersediaan | Target uptime 99% selama jam operasional. |
| Usability | Navigasi dapat diakses keyboard, kontras warna sesuai WCAG AA, support bahasa Indonesia. |
| Maintainability | Kode mengikuti PSR-12, dilengkapi dokumentasi route dan komponen Blade. |
| Portabilitas | Dapat dijalankan via Docker Compose pada Linux/macOS/Windows. |

---

## 7. Acceptance Criteria
- Semua route publik dapat diakses tanpa error 4xx/5xx.
- Navigasi dropdown berfungsi di desktop & mobile (hover, fokus, tap).
- Halaman galeri memuat konten lengkap bekas layanan dan CTA bekerja.
- Admin dengan role tepat dapat login dan mengelola entitas buku/berita.
- Redirect `/layanan` → `/galeri0` bekerja dan tercatat di log akses.
- Tautan eksternal (OPAC, Avialib, Turnitin, Jurnal) terbuka di tab baru.
- Lighthouse Accessibility minimal skor 80.

---

## 8. Appendices
- **Appendix A**: Daftar ikon/asset pada folder `public/images` & `public/css/style.css`.
- **Appendix B**: Rencana migrasi data layanan → galeri (selesai 2026-03-05).

_End of Document_
