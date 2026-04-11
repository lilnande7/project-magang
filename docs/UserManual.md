# User Manual Book — Portal Perpustakaan PPIC

**Project**: Portal Perpustakaan Politeknik Penerbangan Indonesia Curug (PPIC)  
**Versi Dokumen**: 1.0  
**Tanggal**: 10 April 2026  

## 1. Tujuan Dokumen
Dokumen ini membantu pengguna menjalankan fitur-fitur Portal Perpustakaan PPIC secara langkah demi langkah, baik untuk pengunjung umum (publik), anggota terdaftar, maupun admin/pustakawan.

## 2. Peran Pengguna (User Roles)
- **Pengunjung Umum (Publik)**: Mengakses halaman informasi tanpa login.
- **Anggota Terdaftar**: Dapat registrasi, login, dan melihat menu akun.
- **Admin / Pustakawan**: Memiliki role `admin` atau `super-admin` untuk mengakses panel admin dan mengelola konten.

## 3. Persiapan & Akses Sistem
### 3.1 Perangkat yang Disarankan
- Browser modern: Chrome / Firefox / Edge / Safari versi terbaru.
- Koneksi internet stabil.

### 3.2 Akses URL
- Buka website Portal Perpustakaan PPIC melalui URL yang diberikan oleh tim TI.

Catatan:
- Beberapa menu pada navbar dapat bersifat *coming soon* (tergantung implementasi di server). Dokumen ini berfokus pada fitur yang tersedia di sistem saat ini.

## 4. Navigasi Umum (Halaman Publik)
Pada bagian atas halaman, terdapat:
- **Top bar**: informasi telepon, email, jam operasional hingga tombol login.
- **Navbar**: menu utama.

### 4.1 Menu Utama yang Umumnya Tersedia
- **HOME**: kembali ke beranda.
- **PROFILE**: profil perpustakaan.
- **LAYANAN KAMI** (dropdown): akses Berita dan Galeri, serta tautan layanan eksternal.
- **HUBUNGI KAMI**: form kontak.
- **OPAC**: membuka katalog (umumnya membuka tab baru).

## 5. Panduan Pengunjung (Publik)
### 5.1 Membuka Beranda
1. Buka halaman **HOME**.
2. Scroll untuk melihat highlight layanan, berita terbaru, dan ringkasan statistik (jika ditampilkan).
3. Gunakan tombol/tautan “Baca Selengkapnya” bila tersedia untuk menuju halaman Galeri atau Berita.

### 5.2 Membuka Halaman Profil
1. Klik menu **PROFILE**.
2. Baca informasi institusional (visi/misi, ringkasan layanan, dsb).

### 5.3 Membaca Berita
**A. Melihat daftar berita**
1. Buka menu **LAYANAN KAMI**.
2. Klik **Berita**.
3. Pada halaman Berita:
   - Bagian **Berita Utama** menampilkan sorotan berita (jika ada).
   - Bagian **Semua Berita** menampilkan daftar berita dengan pagination.

**B. Membaca detail berita**
1. Klik judul berita atau tombol **Baca Selengkapnya**.
2. Anda akan masuk ke halaman detail berita.

### 5.4 Membuka Galeri
1. Buka menu **LAYANAN KAMI**.
2. Klik **Galeri**.
3. Galeri menampilkan informasi layanan dalam bentuk halaman visual (konten migrasi layanan).

### 5.5 Mengakses Layanan Eksternal (Avialib, Turnitin, Jurnal)
1. Buka menu **LAYANAN KAMI**.
2. Arahkan ke submenu **Layanan**.
3. Klik salah satu tautan:
   - **Avialib** (Play Store)
   - **Turnitin**
   - **Jurnal**
4. Sistem akan membuka tautan (biasanya di tab baru).

### 5.6 Mengakses OPAC
1. Klik menu **OPAC** di navbar.
2. OPAC akan terbuka sebagai halaman eksternal.

### 5.7 Mengirim Pesan melalui “Hubungi Kami”
1. Klik menu **HUBUNGI KAMI**.
2. Isi form:
   - **Nama Lengkap**
   - **Email**
   - **Pesan**
3. Klik tombol **Kirim Pesan**.
4. Jika berhasil, akan muncul notifikasi sukses.

Catatan:
- Pesan akan dicatat sebagai **Pengaduan** di panel admin.
- Pengiriman email bisa saja gagal karena konfigurasi server, tetapi data pengaduan tetap tersimpan.

## 6. Panduan Akun (Registrasi, Login, Logout)
### 6.1 Registrasi (Daftar Akun Baru)
1. Klik tombol **Login** pada top bar, lalu pilih **Daftar Sekarang**.
2. Isi form pendaftaran:
   - Nama lengkap
   - Email
   - Password
   - Konfirmasi password
3. Centang persetujuan syarat dan ketentuan (checkbox).
4. Klik **Daftar Sekarang**.

### 6.2 Login
1. Klik tombol **Login** pada top bar.
2. Masukkan **Email Address** dan **Password**.
3. (Opsional) Centang **Ingat saya**.
4. Klik **Masuk**.

### 6.3 Logout
1. Pada navbar, klik dropdown nama pengguna.
2. Klik **Logout**.

## 7. Panduan Admin / Pustakawan
Akses admin tersedia untuk role **admin** dan **super-admin**.

### 7.1 Masuk ke Dashboard Admin
1. Login menggunakan akun admin.
2. Klik dropdown nama pengguna di navbar.
3. Pilih **Dashboard Admin**.
4. Anda akan masuk ke halaman Dashboard.

### 7.2 Dashboard (Ringkasan & Pengunjung Website)
**A. Membaca ringkasan**
1. Pada halaman Dashboard, lihat kartu statistik (mis. total buku, total user, total berita, active loans).

**B. Mengubah tahun grafik pengunjung**
1. Di kartu **Pengunjung Website (Tahun)**, isi input **Tahun**.
2. Klik **Tampilkan**.

**C. Export laporan pengunjung (Excel)**
1. Pada kartu pengunjung, klik **Export Excel**.
2. File `.xls` akan terunduh.

Catatan teknis untuk tim TI:
- Fitur render grafik gambar pada file export membutuhkan ekstensi PHP **GD** aktif. Jika GD tidak tersedia, export tetap berjalan, namun gambar grafik dapat tidak muncul.

### 7.3 Kelola Buku (Books)
Menu: **Books** di sidebar admin.

**A. Melihat & memfilter buku**
1. Buka menu **Books**.
2. Gunakan filter:
   - **Search** (judul/author/ISBN)
   - **Category**
   - **Status** (available/borrowed/maintenance/lost)
3. Klik **Filter**.
4. Klik tombol reset (ikon refresh) untuk menghapus filter.

**B. Menambah buku baru**
1. Klik tombol **Add New Book**.
2. Isi data minimal yang wajib:
   - Title
   - Author
   - Status
   - Stock
3. (Opsional) isi data lain seperti ISBN, Publisher, Year, Pages, Language, Description, Location, Category, Subjects.
4. (Opsional) upload **Cover Image** (JPG/PNG, maksimal 2MB).
5. Klik **Save** (atau tombol simpan sesuai form).

**C. Mengubah data buku**
1. Pada daftar buku, klik tombol **Edit** (ikon pensil).
2. Ubah field yang diperlukan.
3. Klik **Update/Save**.

**D. Melihat detail buku**
1. Pada daftar buku, klik tombol **View** (ikon mata).
2. Detail buku dan relasi peminjaman (jika ada) akan tampil.

**E. Menghapus buku**
1. Klik tombol **Delete** (ikon tempat sampah).
2. Konfirmasi penghapusan.

Catatan:
- Sistem akan menolak penghapusan buku jika masih memiliki peminjaman aktif.

### 7.4 Kelola Berita (News)
Menu: **News** di sidebar admin.

**A. Melihat & memfilter berita**
1. Buka menu **News**.
2. Gunakan filter:
   - Search (title/content)
   - Status (published/draft/archived)
3. Klik **Filter**.

**B. Membuat berita baru**
1. Klik **Create News**.
2. Isi:
   - **Title** (judul)
   - (Opsional) **Excerpt** (ringkasan)
   - **Content** (isi)
   - (Opsional) **Featured Image** (JPG/PNG, maksimal 2MB)
   - **Status**: `draft` / `published` / `archived`
   - (Opsional) **Featured** (is_featured)
   - (Opsional) **Tags** (pisahkan dengan koma)
   - (Opsional) **Published At**
3. Klik **Save/Create**.

Aturan publikasi:
- Jika status **published** dan `published_at` kosong, sistem mengisi otomatis dengan waktu saat ini.
- Jika status bukan **published**, `published_at` dikosongkan.

**C. Publish berita**
1. Pada tabel berita, cari berita berstatus `draft` atau `archived`.
2. Klik tombol **Publish** (ikon upload).
3. Konfirmasi.

**D. Edit / Hapus berita**
- Klik tombol **Edit** untuk memperbarui isi.
- Klik tombol **Delete** untuk menghapus.

### 7.5 Manajemen Pengguna (Users)
Menu: **Users** di sidebar admin.

**A. Mencari & memfilter pengguna**
1. Buka menu **Users**.
2. Gunakan filter:
   - Cari nama/email
   - Filter berdasarkan role
   - Urutkan (terbaru/terlama/nama)
3. Klik **Terapkan**.

**B. Menambah pengguna (akun baru)**
1. Klik **Tambah Pengguna**.
2. Isi:
   - Nama
   - Email
   - Password + konfirmasi
   - (Opsional) centang **Email verified**
   - (Opsional) upload **Avatar** (maks 2MB)
   - Pilih **Role** (sesuai kewenangan)
3. Klik **Simpan Anggota**.

Catatan role:
- Jika role tidak dipilih, sistem dapat memberi role default (mis. `user`) bila tersedia.

**C. Edit pengguna**
1. Pada daftar, klik ikon pensil.
2. Ubah data, role, status verifikasi email, atau avatar.
3. Klik **Perbarui Anggota**.

**D. Hapus pengguna**
1. Klik ikon tempat sampah.
2. Konfirmasi.

Batasan:
- Admin tidak dapat menghapus akun sendiri.
- Non-super-admin tidak dapat mengubah akun **Super Admin**.
- Sistem mencegah penghapusan **Super Admin** terakhir.

### 7.6 Pengaduan (Hasil dari Hubungi Kami)
Menu: **Pengaduan** di sidebar admin.

**A. Melihat daftar pengaduan**
1. Buka menu **Pengaduan**.
2. Pilih filter status: **Masuk**, **Diproses**, **Selesai**, atau **Semua**.
3. Klik tombol **Detail** untuk membuka isi pengaduan.

**B. Memperbarui status pengaduan**
1. Pada halaman detail pengaduan, pilih salah satu tombol:
   - **Tandai Masuk**
   - **Tandai Diproses**
   - **Tandai Selesai**
2. Status akan tersimpan dan pengaduan dicatat ditangani oleh admin yang sedang login.

Catatan:
- Saat status menjadi **Diproses** pertama kali, sistem mengisi waktu `processed_at`.
- Saat status menjadi **Selesai** pertama kali, sistem mengisi waktu `completed_at`.

## 8. Troubleshooting (Masalah Umum)
- **Tidak bisa login**: pastikan email & password benar; coba nonaktifkan “Caps Lock”.
- **Gagal upload gambar**: pastikan format JPG/PNG dan ukuran ≤ 2MB.
- **Berita tidak muncul di halaman publik**: pastikan status `published` dan `published_at` tidak di masa depan.
- **Export pengunjung tidak menampilkan gambar grafik**: pastikan ekstensi PHP GD aktif di server.

## 9. Riwayat Perubahan Dokumen
- **v1.0 (10 April 2026)**: Penyusunan awal manual publik & admin.
