<?= $this->extend('layout/main') ?>



<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/home.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>



<section class="hero">
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <p class="unit-dokumentasi">Unit Perpustakaan</p>
        <h3>
            SELAMAT DATANG DI PERPUSTAKAAN
            <br>POLITEKNIK PENERBANGAN INDONESIA CURUG</br>
        </h3>
        <p class="layanan-sirkulasi">Layanan Sirkulasi & Referensi</p>
    </div>
</section>

<section class="highlight-section">
    <div class="container">
        <div class="card-grid">
            <div class="card">

                <div class="card-body">
                    <span class="badge">Profil Perpustakaan</span>
                    <h3>Sekilas tentang perpustakaan</h3>
                    <p>
                        Perpustakaan Politeknik Penerbangan Indonesia Curug
                        merupakan pusat layanan informasi.
                    </p>
                    <a href="#" class="read-more">SELENGKAPNYA »</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <span class="badge">Layanan Utama</span>
                    <h3>Beberapa Layanan & Fasilitas</h3>
                    <ul>
                        <li>Layanan Sirkulasi</li>
                        <li>Layanan Referensi</li>
                        <li>Layanan Repositori</li>
                        <li>E-Resources</li>
                        <li>Ruang Baca</li>
                        <li>Wifi</li>
                        <li>Loker Tas</li>
                        <li>Ruang Baca</li>
                    </ul>

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <span class="badge">Akses Digital</span>
                    <h3>Manfaat akses digital</h3>
                    <p>
                        Akses katalog koleksi dan repository karya ilmiah
                        secara online.
                    </p>
                    <a href="#" class="read-more">SELENGKAPNYA »</a>
                </div>
            </div>
        </div>

        <!-- <div class="highlight-grid"> -->

        <!-- PROFIL -->
        <!-- <div class="highlight-card about">
                <h3>Profil Perpustakaan</h3>
                <p>
                    Perpustakaan Politeknik Penerbangan Indonesia Curug
                    merupakan pusat layanan informasi dan dokumentasi.
                </p>
                <a href="/tentang" class="btn-link">Selengkapnya</a>
            </div> -->

        <!-- LAYANAN -->
        <!-- <div class="highlight-card layanan">
                <h3>Layanan Utama</h3>
                <ul>
                    <li>Sirkulasi</li>
                    <li>Referensi</li>
                    <li>E-Resources</li>
                    <li>Ruang Baca</li>
                </ul>
            </div> -->

        <!-- AKSES DIGITAL -->
        <!-- <div class="highlight-card digital">
                <h3>Akses Digital</h3>
                <p>
                    Akses katalog koleksi dan repository karya ilmiah
                    secara online.
                </p>
                <a href="https://opac.xxx" target="_blank" class="btn-link">
                    Buka OPAC
                </a>
            </div>

        </div> -->
    </div>
</section>




<section class="about">
    <div class="about-container">

        <div class="about-image">
            <img src="<?= base_url('assets/img/remove.png') ?>" alt="Perpustakaan PPI Curug">
        </div>

        <div class="about-content">
            <h2>Tentang Perpustakaan</h2>
            <p>
                Perpustakaan Politeknik Penerbangan Indonesia Curug
                merupakan pusat layanan informasi dan dokumentasi
                yang mendukung kegiatan pendidikan, penelitian,
                dan pengembangan ilmu pengetahuan.
            </p>
        </div>

    </div>
</section>


<section class="news-section">
    <h2 class="section-title">BERITA TERBARU</h2>

    <div class="news-grid">
        <!-- Card -->
        <div class="news-card">
            <img src="assets/img/tlb.png" alt="Berita 1">
            <h3>Sosialisasi Literasi Hak Cipta PIP Semarang</h3>

            <div class="news-date">
                📅 20 Feb 2025, 15:29:32
            </div>

            <p>
                Unit Perpustakaan dan Penerbitan Politeknik Ilmu Pelayaran
                Semarang mengadakan kegiatan Literasi Hak Cipta...
            </p>

            <a href="#" class="read-more">Read More</a>
        </div>

        <div class="news-card">
            <img src="assets/img/tmb.png" alt="Berita 2">
            <h3>Perpisahan Tim Magang UIN Semarang</h3>

            <div class="news-date">
                📅 20 Feb 2025, 15:27:11
            </div>

            <p>
                Periode 20 Januari 2025 – 11 Februari 2025 Prodi S-1
                Manajemen Pendidikan Islam...
            </p>

            <a href="#" class="read-more">Read More</a>
        </div>

        <div class="news-card">
            <img src="assets/img/tpu.png" alt="Berita 3">
            <h3>Sosialisasi Pemanfaatan Buku Ajar Digital</h3>

            <div class="news-date">
                📅 20 Feb 2025, 15:25:08
            </div>

            <p>
                Perpustakaan PIP Semarang mengadakan kegiatan
                sosialisasi pemanfaatan e-book, e-journal...
            </p>

            <a href="#" class="read-more">Read More</a>
        </div>

        <div class="news-card">
            <img src="assets/img/obu.png" alt="Berita 4">
            <h3>Serah Terima MOU Perpustakaan</h3>

            <div class="news-date">
                📅 20 Feb 2025, 15:23:33
            </div>

            <p>
                Perpustakaan PIP Semarang menerima kunjungan dari
                Perpustakaan Polimarin...
            </p>

            <a href="#" class="read-more">Read More</a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>