# Panduan Template & CSS Portal Perpustakaan

**Dokumen**: Pemilihan Template Website & Pedoman CSS  
**Tanggal**: 2026-03-05  
**Ditulis oleh**: Tim Frontend Perpustakaan Digital

---

## 1. Ringkasan Template
- **Gaya**: Modern, penuh kontras, menonjolkan latar gelap dengan aksen biru (sesuai identitas PPIC).
- **Struktur utama**: Header top bar, navbar sticky transparan, hero layar penuh, grid konten modular.
- **Teknologi**: Blade template + CSS kustom (public/css/style.css) dengan dukungan Tailwind utility (resources/css/app.css) bila dibutuhkan.

## 2. Pemilihan Komponen
| Komponen | Deskripsi Visual | Catatan CSS |
| --- | --- | --- |
| Top Bar | Baris tipis dengan kontak & ikon sosial | `.top-bar`, `.top-info`, `.top-actions` |
| Navbar | Logo kiri, menu tengah, CTA kanan | `.navbar`, `.navbar-menu`, dropdown multi-level |
| Hero | Layout dua kolom: copy + statistik | `.hero`, `.hero-inner`, `.hero-metrics` |
| Highlight | Kartu layanan dengan ikon | `.feature-grid`, `.feature-card` |
| Galeri | Section eks-layanan (hero, experience, facility) | `.layanan-hero`, `.experience-section`, `.facility-detail-section` |

## 3. Pedoman Layout & Grid
- **Maximum width**: 1200px di desktop, padding 24px untuk konten.
- **Grid**: Menggunakan CSS grid dan flexbox. Contoh `.feature-grid` memakai `grid-template-columns: repeat(3, minmax(0, 1fr))` di desktop.
- **Spacing**: Gap 24–36px antar blok; inner padding 20px untuk kartu.
- **Breakpoint utama**: 1024px (tablet), 768px (mobile). Pada breakpoint ini navbar berubah menjadi panel slide-down.

## 4. Palet Warna & Tipografi
| Token | Nilai | Penggunaan |
| --- | --- | --- |
| `--deep` | `#030712` | Latar belakang utama/header.
| `--accent` | `#1c7ed6` | Aksen link, garis bawah, tombol utama.
| `--neutral-light` | `#e2e8f0` | Teks sekunder di atas latar gelap.
| `--neutral-muted` | `#94a3b8` | Ikon/label kecil.

**Tipografi**:
- Font utama: `Instrument Sans`, fallback `ui-sans-serif` (lihat `resources/css/app.css`).
- Heading menggunakan berat 700, body 400–500.
- Letter-spacing 1px untuk menu agar terbaca di latar gelap.

## 5. Navigasi & Dropdown
- Dropdown level pertama (`.dropdown`) muncul tepat di bawah item menu dengan bayangan halus.
- Sub-dropdown (`.sub-dropdown`) untuk "Layanan" mengembang ke arah kanan: `left: calc(100% + 12px)`.
- Mobile (`max-width: 1024px`): dropdown menjadi stack vertikal; `.sub-dropdown` mendapatkan latar semi transparan.

## 6. Responsivitas
| Breakpoint | Perubahan |
| --- | --- |
| ≤1024px | Navbar toggle aktif, menu jadi kolom, dropdown statis. |
| ≤768px | Hero padding ditambah, grid feature & categories menjadi 2 kolom. |
| ≤480px | Typography dikurangi 10%, tombol full-width. |

## 7. Cuplikan CSS Referensi
```css
.navbar {
    position: fixed;
    top: 0;
    width: 100%;
    display: flex;
    justify-content: center;
    background: linear-gradient(180deg, rgba(3,7,18,0.9), rgba(3,7,18,0));
    transition: background 0.3s ease;
}

.has-sub-dropdown {
    position: relative;
}

.sub-dropdown {
    position: absolute;
    top: 0;
    left: calc(100% + 12px);
    min-width: 200px;
    padding: 12px 0;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 25px 60px rgba(15, 23, 42, 0.18);
    display: none;
}

.has-sub-dropdown:hover > .sub-dropdown,
.has-sub-dropdown:focus-within > .sub-dropdown {
    display: block;
}
```
(Sesuaikan dengan `public/css/style.css` agar tetap konsisten.)

## 8. Checklist Implementasi
1. Gunakan layout Blade `layouts/app.blade.php` sebagai kerangka dasar.
2. Pastikan referensi stylesheet menunjuk ke `public/css/style.css` dan `resources/css/app.css` (Tailwind entry).
3. Terapkan kelas yang terdefinisi di CSS pada tiap partial (navbar, footer, hero, dsb.).
4. Uji dropdown di desktop (hover/focus) dan mobile (tap) memastikan sub-menu muncul horizontal/vertikal sesuai aturan.
5. Jalankan Lighthouse audit untuk mengecek kontras dan performa.

---

Dokumen ini menjadi acuan saat memilih template dan menata CSS agar konsisten dengan identitas visual PPIC. Untuk update, tambahkan contoh komponen baru dan variasi warna pada bagian relevan.
