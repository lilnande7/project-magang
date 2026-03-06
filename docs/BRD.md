# Business Requirements Document (BRD)

**Project**: Portal Perpustakaan Politeknik Penerbangan Indonesia Curug  
**Version**: 1.0  
**Date**: 2026-03-05  
**Prepared by**: Tim Pengembangan Perpustakaan Digital

---

## 1. Executive Summary
Perpustakaan PPIC membutuhkan portal digital terpadu yang menyajikan informasi layanan, koleksi unggulan, berita, agenda, serta akses cepat ke OPAC dan sumber daya elektronik. Sistem saat ini telah memigrasikan halaman layanan menjadi galeri interaktif, memperbaiki navigasi, dan menyiapkan fondasi admin untuk kurasi konten. BRD ini menjelaskan kebutuhan bisnis, ruang lingkup, dan metrik keberhasilan guna memastikan roadmap fitur selaras dengan tujuan institusi.

## 2. Business Objectives & Success Metrics
| Tujuan | Indikator Keberhasilan |
| --- | --- |
| Meningkatkan keterlibatan sivitas dengan layanan perpustakaan | +30% kunjungan halaman galeri & berita dalam 3 bulan setelah peluncuran. |
| Menyediakan akses cepat ke sumber digital (OPAC, Avialib, Turnitin, Jurnal) | Rasio klik tautan eksternal ≥ 20% dari total pengunjung unik. |
| Mempermudah tim pustakawan mengelola konten | Waktu publikasi berita baru < 10 menit melalui dashboard admin. |
| Menyiapkan pondasi layanan peminjaman daring | Skema role & permission siap (teruji) sebelum Q4 2026. |

## 3. Background & Problem Statement
- Informasi layanan perpustakaan sebelumnya tersebar dalam beberapa halaman statis dan tidak konsisten.
- Tautan layanan digital kurang terlihat sehingga literasi digital sivitas rendah.
- Tim pustakawan kesulitan memperbarui konten karena tidak ada CMS sederhana.
- Rencana transformasi digital PPIC menuntut dashboard tunggal yang dapat berkembang menjadi layanan peminjaman daring.

## 4. Stakeholders
| Peran | Tanggung Jawab |
| --- | --- |
| Kepala Perpustakaan | Sponsor utama, penetapan prioritas dan anggaran. |
| Tim Pustakawan | Pemilik konten, pengelola buku & berita. |
| Tim TI Kampus | Menjaga infrastruktur, keamanan, dan integrasi. |
| Taruna & Sivitas | Pengguna akhir portal publik. |
| Mitra Eksternal (Avialib, Turnitin, Penerbit) | Penyedia layanan digital yang ditautkan dari portal. |

## 5. Scope Definition
### In Scope
- Portal publik dengan navigasi baru dan konten galeri hasil migrasi layanan.
- Integrasi tautan ke OPAC, Avialib, Turnitin, Jurnal ilmiah.
- Halaman profil, berita, kontak, agenda/pengumuman.
- Modul autentikasi dan dashboard admin (Books & News CRUD).
- Dokumentasi SRS, BRD, dan logbook perkembangan.

### Out of Scope (fase ini)
- API real-time untuk OPAC atau peminjaman daring.
- Integrasi SSO kampus.
- Pembayaran denda atau fitur finansial.
- Aplikasi mobile native.

## 6. User Personas & Journeys
| Persona | Motivasi Utama | Journey Ringkas |
| --- | --- | --- |
| Taruna Tahun Pertama | Mencari info layanan & koleksi | Kunjungi beranda → baca highlight → klik galeri → akses OPAC. |
| Dosen/Peneliti | Membutuhkan referensi & Turnitin | Buka menu Layanan Kami → pilih Turnitin → gunakan akun institusi. |
| Pustakawan Admin | Memperbarui berita | Login → akses dashboard admin → buat berita baru → publikasikan. |
| Tamu Eksternal | Mencari kontak dan kerjasama | Navigasi ke Hubungi Kami/Kerjasama → isi form/ikuti instruksi. |

## 7. Business Requirements
| ID | Requirement | Prioritas |
| --- | --- | --- |
| BR-01 | Portal harus menampilkan identitas, layanan, dan koleksi unggulan secara ringkas di halaman utama. | Tinggi |
| BR-02 | Menu “Layanan Kami” wajib memiliki sub dropdown Layanan (Avialib, Turnitin, Jurnal) di dalamnya. | Tinggi |
| BR-03 | Halaman galeri menggantikan layanan lama tanpa kehilangan konten informatif. | Tinggi |
| BR-04 | Semua tautan layanan eksternal membuka tab baru dengan proteksi keamanan standar. | Sedang |
| BR-05 | Admin dapat mengelola data buku dan berita melalui dashboard terproteksi role. | Tinggi |
| BR-06 | Pengguna terautentikasi harus melihat nama akun serta opsi logout di navbar. | Tinggi |
| BR-07 | Sistem menyimpan data role & permission untuk ekspansi modul peminjaman daring. | Sedang |
| BR-08 | Portal responsif dan ramah perangkat mobile. | Tinggi |
| BR-09 | Penyusunan dokumentasi proyek (SRS, BRD, logbook) tersedia untuk audit. | Sedang |

## 8. Non-Functional & Compliance Requirements
- **Keamanan**: HTTPS, enkripsi password, RBAC.
- **Kinerja**: Response time < 2s, caching siap pakai.
- **Aksesibilitas**: Kontras warna, navigasi keyboard, atribut aria.
- **Kepatuhan**: Mematuhi kebijakan data kampus dan lisensi konten.
- **Branding**: Mengikuti identitas visual PPIC dan pedoman Kementerian Perhubungan.

## 9. Assumptions & Dependencies
- Konten berjalan mengikuti jadwal acara perpustakaan terbaru.
- Infrastruktur Docker Compose sudah disiapkan oleh tim TI.
- Akun admin awal sudah dibuat oleh seeder `UserSeeder`.
- Integrasi eksternal tetap aktif; downtime pihak ketiga di luar tanggung jawab tim.

## 10. Risks & Mitigation
| Risiko | Dampak | Mitigasi |
| --- | --- | --- |
| Konten galeri tidak diperbarui rutin | Informasi usang → penurunan engagement | Jadwalkan review bulanan, tugaskan PIC konten. |
| Kegagalan layanan eksternal (OPAC, Turnitin) | Pengguna tidak bisa mengakses layanan penting | Tampilkan pesan status & tautan kontak helpdesk. |
| Kurangnya pelatihan admin | Kesalahan input/terlambat update | Sediakan panduan CMS & sesi workshop singkat. |
| Beban server meningkat saat acara besar | Respons lambat | Aktifkan caching, siapkan autoscaling sederhana (replica). |

## 11. Timeline & Milestones
| Milestone | Target Tanggal | Status |
| --- | --- | --- |
| Migrasi layanan → galeri | 2026-03-05 | Selesai |
| Finalisasi dokumentasi SRS & BRD | 2026-03-05 | Selesai |
| UAT navigasi baru & halaman galeri | 2026-03-10 | Dalam perencanaan |
| Pelatihan admin dashboard | 2026-03-15 | Direncanakan |
| Perencanaan modul peminjaman daring | Q3 2026 | Roadmap |

## 12. Next Steps & Recommendations
1. Lakukan UAT terstruktur (desktop & mobile) untuk memastikan dropdown lateral berjalan lancar.
2. Susun panduan konten bagi pustakawan, termasuk standar gambar galeri dan format berita.
3. Evaluasi opsi SSO atau integrasi API OPAC untuk fase selanjutnya.
4. Siapkan backlog fitur (borrowing, analytics) berdasarkan umpan balik setelah peluncuran.

_End of Document_
