# Logbook Pemilihan Template & Tampilan

| Tanggal | Kegiatan Utama | Hasil/Output | Hambatan | Rencana Berikutnya |
| --- | --- | --- | --- | --- |
| 26 Feb 2026 | Benchmark UI perpustakaan modern (tema gelap vs terang, fokus aksesibilitas) | Daftar referensi: perpustakaan MIT, Singapore Poly, dan beberapa portal pendidikan Indonesia; catatan elemen favorit | Tidak semua referensi menyediakan detail CSS | Tentukan arah visual awal (gelap dengan aksen biru) dan mulai wireframe sederhana |
| 27 Feb 2026 | Menentukan struktur layout: top bar, navbar sticky, hero + statistik, grid layanan | Sketsa layout di Figma, outline komponen pada Blade | Keterbatasan waktu untuk detail mobile | Buat daftar kelas CSS dan token warna yang dibutuhkan |
| 28 Feb 2026 | Mendesain navigasi dropdown bertingkat untuk "Layanan Kami" | Interaksi hover/focus horizontal bekerja di desktop | Dropdown menumpuk di mobile | Rancang fallback mobile: posisi statis, background semi-transparan |
| 1 Mar 2026 | Menyesuaikan gaya hero & highlight agar konsisten dengan layout layanan lama | Hero baru dengan dua kolom tetap, highlight 3 kartu siap styling | Perlu memastikan kinerja gambar high-res | Kompres aset gambar & definisikan max-width |
| 2 Mar 2026 | Review warna & tipografi; mau tetap di Instrument Sans + aksen biru | Palet final: deep #030712, accent #1c7ed6, neutral lights | Kebutuhan kontras untuk teks kecil | Uji kontras via Lighthouse dan tweak warna tekstur |
| 3 Mar 2026 | Menulis dokumentasi template dan pedoman CSS | Draft awal TemplateGuide mencakup komponen, grid, breakpoints | Belum ada log khusus proses desain | Susun logbook ini sebagai catatan perjalanan desain |
| 4 Mar 2026 | Validasi implementasi di `public/css/style.css` sesuai panduan | Dropdown horizontal + mobile fallback terverifikasi | Tidak ada | Lengkapi panduan dengan snippet CSS penting |
| 5 Mar 2026 | Finalisasi dokumentasi (SRS, BRD, TemplateGuide) & logbook desain | Dokumen resmi + logbook tersedia untuk tim | - | Review bersama stakeholder dan update bila ada perubahan template |
