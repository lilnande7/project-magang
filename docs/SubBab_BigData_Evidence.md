# LAPORAN SUB-BAB TAMBAHAN: IMPLEMENTASI BIG DATA
## Lampiran BAB IV — Hasil Pembahasan

> **Catatan integrasi**: Sub-bab berikut merupakan tambahan pada BAB II (Landasan Teori) dan BAB IV (Hasil Pembahasan) laporan magang yang sudah ada. Sisipkan sub-bab landasan teori setelah sub-bab 2.11, dan sub-bab pembahasan setelah sub-bab 4.13.

---

## TAMBAHAN BAB II — LANDASAN TEORI

### 2.12 Big Data

Big Data merupakan konsep yang merujuk pada kumpulan data dalam skala besar, beragam jenis, dan dihasilkan dengan kecepatan tinggi sehingga tidak dapat dikelola secara efektif menggunakan metode pemrosesan data konvensional. Definisi Big Data paling umum dirumuskan melalui kerangka **5V**, yaitu:

1. **Volume** — mengacu pada ukuran atau jumlah data yang sangat besar. Dalam konteks perpustakaan, volume data mencakup ribuan record koleksi, transaksi peminjaman, dan log aktivitas pengguna yang terus bertambah setiap harinya.

2. **Velocity** — mengacu pada kecepatan data dihasilkan dan diproses. Data log pengunjung website, aktivitas pengguna, dan request peminjaman merupakan contoh data yang dihasilkan secara terus-menerus (real-time) tanpa jeda.

3. **Variety** — mengacu pada keberagaman format dan jenis data. Data dapat berbentuk terstruktur (tabel relasional database), semi-terstruktur (JSON, CSV), maupun tidak terstruktur (teks bebas, deskripsi buku).

4. **Veracity** — mengacu pada tingkat akurasi dan kepercayaan data. Data yang bersumber dari sistem SLiMS yang sudah divalidasi oleh pustakawan memiliki tingkat veracity yang tinggi dibandingkan data yang diinput secara manual tanpa validasi.

5. **Value** — mengacu pada manfaat yang dapat diperoleh dari pengolahan data. Analitik yang dihasilkan dari data perpustakaan dapat membantu pengambilan keputusan, seperti menentukan buku mana yang perlu ditambah stoknya, atau mengidentifikasi tren minat baca.

Menurut Zikopoulos & Eaton (2011), Big Data tidak hanya tentang ukuran data, tetapi juga tentang kemampuan sistem dalam menggali nilai (*value*) dari data tersebut melalui analisis dan visualisasi yang tepat.

---

### 2.13 Data Analytics dan Visualisasi

Data Analytics adalah proses memeriksa, membersihkan, mentransformasi, dan memodelkan data untuk menemukan informasi yang berguna, menarik kesimpulan, dan mendukung pengambilan keputusan. Terdapat empat tingkatan analitik data:

| Tingkat | Jenis | Pertanyaan yang Dijawab |
|---------|-------|------------------------|
| 1 | **Descriptive Analytics** | Apa yang terjadi? |
| 2 | **Diagnostic Analytics** | Mengapa hal itu terjadi? |
| 3 | **Predictive Analytics** | Apa yang akan terjadi? |
| 4 | **Prescriptive Analytics** | Apa yang harus dilakukan? |

Pada proyek ini, implementasi berada pada tingkat *Descriptive Analytics* melalui dashboard dan halaman statistik yang menampilkan ringkasan kondisi terkini, serta sebagian *Diagnostic Analytics* melalui visualisasi tren yang memperlihatkan pola perubahan dari waktu ke waktu.

Visualisasi data merupakan representasi grafis dari informasi dan data. Dengan menggunakan elemen visual seperti grafik garis (*line chart*), diagram batang (*bar chart*), dan diagram lingkaran (*donut chart*), visualisasi membantu pengguna memahami pola, tren, dan anomali dalam data secara lebih intuitif dibandingkan tabel angka biasa.

---

### 2.14 Natural Language Processing (NLP) dalam Information Retrieval

*Natural Language Processing* (NLP) adalah cabang kecerdasan buatan yang memungkinkan komputer memahami, menginterpretasikan, dan menghasilkan bahasa manusia. Dalam konteks *Information Retrieval* (IR), NLP digunakan untuk menemukan dokumen atau data yang paling relevan dari sekumpulan data besar berdasarkan query yang diberikan pengguna dalam bahasa alami.

Teknik-teknik NLP yang umum digunakan dalam IR meliputi:

- **Tokenisasi** — memecah teks menjadi satuan kata atau token.
- **Normalisasi teks** — mengubah semua karakter ke huruf kecil dan menghilangkan karakter khusus.
- **Stopword filtering** — menghapus kata-kata umum yang tidak bermakna dalam pencarian (misalnya: "yang", "dan", "di", "untuk").
- **Token matching dan scoring** — menghitung skor relevansi antara query dan dokumen berdasarkan kecocokan token.

Pada proyek ini, teknik-teknik tersebut diimplementasikan pada fitur chatbot asisten perpustakaan untuk mencari koleksi dari dataset berukuran besar secara efisien.

---

### 2.15 ETL (Extract, Transform, Load)

ETL adalah proses fundamental dalam rekayasa data (*data engineering*) yang terdiri dari tiga tahap:

1. **Extract** — mengambil data mentah dari sumber asalnya, misalnya file CSV ekspor dari sistem SLiMS.
2. **Transform** — membersihkan, menormalisasi, dan mengubah format data agar sesuai dengan skema tujuan.
3. **Load** — memuat data yang telah ditransformasi ke dalam sistem tujuan, misalnya tabel database relasional.

Proses ETL sangat penting dalam ekosistem Big Data karena data dari berbagai sumber seringkali tidak konsisten format, encoding, maupun strukturnya. Pada proyek ini, proses ETL terjadi ketika data koleksi dari file CSV ekspor SLiMS dibaca, dinormalisasi, dan diproses oleh sistem chatbot perpustakaan.

---

## TAMBAHAN BAB IV — HASIL PEMBAHASAN

### 4.14 Penerapan Konsep Big Data pada Sistem Perpustakaan PPIC

Dalam pengembangan website perpustakaan ini, konsep Big Data tidak hanya bersifat teoritis, melainkan tercermin secara konkret melalui berbagai komponen sistem yang dibangun. Penerapan tersebut dapat dipetakan ke dalam kerangka 5V Big Data sebagai berikut:

**a. Volume — Dataset Koleksi Senayan**

Sistem perpustakaan PPIC mengelola data koleksi yang bersumber dari SLiMS 9 (*Senayan Library Management System*), yang diekspor dalam dua file CSV:

| File | Jumlah Record | Ukuran | Jumlah Atribut |
|------|--------------|--------|----------------|
| `senayan_biblio_export.csv` | 5.524 record | 2,1 MB | 18 atribut |
| `senayan_item_export.csv` | 8.809 record | 2,1 MB | 19 atribut |
| **Total Keseluruhan** | **14.333 record** | **±4,2 MB** | — |

Kedua file tersebut berisi data bibliografi lengkap mulai dari judul, pengarang, ISBN, penerbit, tahun terbit, klasifikasi, nomor panggil, lokasi rak, hingga status ketersediaan eksemplar. Data sebanyak ini tidak dapat diproses secara manual, sehingga membutuhkan pendekatan pemrosesan data otomatis yang merupakan salah satu karakteristik inti Big Data.

**b. Velocity — Data Log yang Terus Bertambah**

Sistem mengumpulkan tiga kategori data secara berkelanjutan setiap kali website diakses atau ada aksi pengguna:

- **`visitor_logs`** — mencatat setiap kunjungan ke website secara otomatis, termasuk atribut `visited_on`, `session_id`, `user_id`, `path`, `ip`, `user_agent`, dan `referer`. Data ini dihasilkan setiap ada pengguna yang mengakses halaman manapun di website.
- **`user_activity_logs`** — mencatat setiap tindakan admin/librarian pada sistem, seperti persetujuan peminjaman, pengelolaan buku, dan manajemen pengguna, lengkap dengan atribut JSON `meta` yang fleksibel.
- **`borrowings`** — mencatat setiap transaksi peminjaman dengan alur status lengkap: `pending → active → returned` (atau `rejected`/`overdue`), disertai timestamp di setiap tahapan.

Ketiga sumber data ini menghasilkan data secara kontinu, yang mencerminkan karakteristik **Velocity** dalam Big Data.

**c. Variety — Keberagaman Format Data**

Sistem mengelola data dalam tiga format yang berbeda:

| Jenis | Format | Contoh dalam Sistem |
|-------|--------|---------------------|
| **Structured** | Tabel relasional database | Tabel `books`, `borrowings`, `users`, `categories` |
| **Semi-structured** | CSV (Comma-Separated Values) | File ekspor SLiMS 4,2 MB |
| **Semi-structured** | JSON | Kolom `meta` di tabel `user_activity_logs` |

Keberagaman format ini mencerminkan karakteristik **Variety** dalam Big Data, dan merupakan salah satu alasan mengapa pemrosesan data sederhana tidak cukup — dibutuhkan sistem yang mampu menangani berbagai jenis data secara bersamaan.

**d. Veracity — Kualitas dan Validitas Data**

Data yang digunakan dalam sistem bersumber dari SLiMS 9, sistem manajemen perpustakaan resmi yang sudah digunakan dan divalidasi oleh pustakawan Perpustakaan PPIC. Hal ini memastikan tingkat **Veracity** yang memadai, yakni data yang dapat dipercaya dan relevan untuk analisis. Selain itu, sistem menerapkan validasi input pada setiap formulir dan memanfaatkan tipe data yang tepat pada skema database — misalnya tipe `enum` untuk status buku dan tipe `date` untuk tanggal peminjaman.

**e. Value — Nilai dari Analitik Data**

Nilai (*Value*) diwujudkan melalui berbagai fitur analitik yang mengubah data mentah menjadi informasi yang dapat digunakan untuk pengambilan keputusan, antara lain:

- Dashboard admin yang menampilkan KPI perpustakaan secara real-time.
- Halaman statistik yang menampilkan tren peminjaman dan kunjungan selama 12 bulan terakhir.
- Identifikasi buku terpopuler untuk mendukung keputusan pengadaan koleksi.
- Laporan ekspor data ke format XLS untuk kebutuhan administrasi dan akreditasi.

---

### 4.15 Dataset SLiMS sebagai Sumber Data Besar

Dataset ekspor dari SLiMS 9 merupakan komponen Big Data yang paling eksplisit dalam proyek ini. File `senayan_biblio_export.csv` memuat **5.524 record bibliografi** dengan **18 atribut** per record, meliputi:

| Atribut | Keterangan |
|---------|-----------|
| `title` | Judul buku atau dokumen |
| `gmd_name` | Jenis media (Textbook, Journal, dan sebagainya) |
| `edition` | Edisi atau cetakan buku |
| `isbn_issn` | Nomor identifikasi internasional |
| `publisher_name` | Nama penerbit |
| `publish_year` | Tahun terbit |
| `collation` | Informasi fisik (jumlah halaman, ilustrasi) |
| `series_title` | Judul seri jika merupakan bagian dari seri |
| `call_number` | Nomor panggil sesuai klasifikasi DDC |
| `language_name` | Bahasa dokumen |
| `place_name` | Kota atau tempat terbit |
| `classification` | Kode klasifikasi Dewey Decimal Classification |
| `notes` | Catatan tambahan dari pustakawan |
| `image` | Path atau URL gambar sampul buku |
| `sor` | *Statement of Responsibility* (pernyataan tanggung jawab) |
| `authors` | Nama pengarang atau editor |
| `topics` | Topik atau subjek dokumen |
| `item_code` | Kode eksemplar fisik |

Sementara file `senayan_item_export.csv` memuat **8.809 record eksemplar** yang merepresentasikan fisik buku di rak perpustakaan, termasuk informasi lokasi rak, kode eksemplar, status ketersediaan, dan tanggal pengadaan.

Data-data ini dibaca dan diproses oleh sistem chatbot perpustakaan (`API\ChatbotController`) menggunakan kelas `SplFileObject` PHP yang membaca file CSV secara efisien baris demi baris tanpa memuat seluruh file ke memori sekaligus — sebuah teknik yang umum digunakan dalam pemrosesan file berukuran besar pada ekosistem Big Data.

---

### 4.16 Sistem Pencarian Berbasis NLP pada Chatbot Perpustakaan

Salah satu implementasi Big Data yang paling signifikan pada proyek ini adalah sistem pencarian koleksi berbasis NLP yang ditanamkan pada chatbot asisten perpustakaan. Sistem ini bekerja dalam tiga tahapan yang mencerminkan pipeline pengolahan data pada ekosistem Big Data:

**Tahap 1 — Normalisasi Teks (Text Preprocessing)**

Setiap query yang masuk dari pengguna dinormalisasi terlebih dahulu sebelum diproses. Normalisasi meliputi konversi ke huruf kecil, penghapusan karakter non-alfanumerik, dan penyeragaman spasi berlebih. Proses ini memastikan bahwa query "CARI Buku Sistem Operasi!!" dan "cari buku sistem operasi" diperlakukan secara identis oleh mesin pencari.

**Tahap 2 — Stopword Filtering**

Token-token yang tidak bermakna dalam konteks pencarian dihilangkan dari query. Daftar stopword yang digunakan mencakup kata-kata umum dalam Bahasa Indonesia maupun Bahasa Inggris, di antaranya: `buku`, `baca`, `cari`, `tolong`, `ada`, `tentang`, `yang`, `untuk`, `dengan`, `di`, `the`, `a`, `an`, `of`, dan sebagainya. Dengan menghilangkan stopword, mesin pencari dapat berfokus pada token bermakna yang benar-benar merepresentasikan topik yang dicari.

**Tahap 3 — Scoring dan Ranking**

Sistem menghitung skor relevansi untuk setiap record dalam dataset menggunakan algoritma berbasis token matching. Setiap record dicocokkan terhadap query yang sudah dibersihkan dan diberi skor berdasarkan kualitas kecocokan:

| Kondisi Kecocokan | Skor |
|-------------------|------|
| Judul mengandung seluruh query (exact phrase match) | +140 poin |
| Judul mengandung salah satu token pencarian | +35 poin per token |
| Nomor panggil mengandung token pencarian | +18 poin per token |
| Kode eksemplar mengandung token pencarian | +10 poin per token |
| Token query berhasil dicocokkan ke token judul | +16 poin per token |

Record dengan skor tertinggi yang melampaui ambang batas minimum (skor ≥ 30) dikembalikan sebagai hasil pencarian. Jika tidak ada hasil yang memenuhi ambang batas, query diteruskan ke Gemini API — layanan *Large Language Model* (LLM) berbasis cloud — sebagai mekanisme fallback.

Arsitektur dua lapis ini (dataset lokal → Gemini API) merupakan pola *hybrid retrieval* yang umum digunakan dalam sistem Big Data untuk menyeimbangkan antara kecepatan, akurasi, dan biaya komputasi.

---

### 4.17 Dashboard Analitik dan Visualisasi Data untuk Admin

Dashboard admin (`Admin\DashboardController`) merupakan implementasi *Descriptive Analytics* yang mengagregasi data dari berbagai tabel secara real-time. Berikut adalah komponen analitik yang diimplementasikan:

**a. KPI (Key Performance Indicators) Perpustakaan**

Dashboard menampilkan 9 indikator utama yang dihitung langsung dari database menggunakan query agregasi:

| KPI | Keterangan |
|-----|-----------|
| Total Buku | Seluruh koleksi yang terdaftar dalam sistem |
| Buku Tersedia | Koleksi yang siap untuk dipinjam |
| Buku Dipinjam | Koleksi yang sedang dalam peminjaman |
| Total Kategori | Jumlah kategori koleksi yang aktif |
| Total Pengguna | Jumlah anggota yang terdaftar di sistem |
| Peminjaman Aktif | Transaksi peminjaman yang sedang berjalan |
| Peminjaman Terlambat | Peminjaman yang telah melewati batas waktu pengembalian |
| Total Berita | Seluruh artikel berita yang tersimpan |
| Berita Terbit | Artikel berita yang sudah dipublikasikan |

**b. Time-Series Analysis — Tren Peminjaman 7 Hari**

Sistem menghitung jumlah peminjaman per hari selama 7 hari terakhir menggunakan agregasi berbasis tanggal. Data ini divisualisasikan dalam bentuk grafik garis yang memperlihatkan pola aktivitas peminjaman dari hari ke hari, sehingga admin dapat mengidentifikasi hari-hari dengan aktivitas tinggi atau rendah.

**c. Temporal Aggregation — Statistik Pengunjung per Tahun**

Sistem mengagregasi data kunjungan website per bulan dalam satu tahun penuh dengan dukungan multi-driver database (SQLite dan MySQL). Hasil agregasi divisualisasikan dalam grafik garis bulanan yang memperlihatkan tren kunjungan sepanjang tahun, termasuk bulan-bulan puncak dan bulan sepi.

**d. Export Laporan ke XLS dengan Grafik**

Sistem menghasilkan laporan pengunjung tahunan dalam format Microsoft Excel (XLS) beserta grafik yang dirender secara server-side menggunakan PHP GD Library. Grafik yang dihasilkan berupa *line chart* dengan grid, sumbu, label bulan, dan titik data yang divisualisasikan pada kanvas berukuran 1100×420 piksel, kemudian disematkan langsung ke dalam file laporan sebagai gambar berformat Base64 PNG.

---

### 4.18 Halaman Statistik Analitik Publik

Sebagai implementasi lanjutan dari konsep Big Data, proyek ini menambahkan halaman statistik analitik (`/statistik`) yang dapat diakses oleh staf perpustakaan (admin, librarian, dan super-admin). Halaman ini dirancang untuk menampilkan analisis menyeluruh dari seluruh data yang dikumpulkan sistem.

**a. Komponen Data yang Dianalisis**

Halaman statistik mengolah data dari **6 tabel database sekaligus** dalam satu sesi permintaan:

| Tabel | Data yang Diproses |
|-------|-------------------|
| `books` | Total koleksi, status ketersediaan, distribusi per tahun terbit |
| `categories` | Jumlah buku per kategori untuk distribusi koleksi |
| `borrowings` | Tren 12 bulan, top 10 terpopuler, distribusi status, aktivitas 7 hari |
| `users` | Jumlah total anggota terdaftar |
| `visitor_logs` | Total kunjungan, kunjungan hari ini, tren pengunjung 12 bulan |

**b. Visualisasi Interaktif dengan Chart.js**

Halaman statistik menampilkan **6 jenis visualisasi** yang dirender secara interaktif menggunakan library Chart.js:

| Visualisasi | Jenis Chart | Data yang Ditampilkan |
|-------------|-------------|----------------------|
| Tren Peminjaman Buku | Line Chart | Volume peminjaman per bulan, 12 bulan terakhir |
| Tren Pengunjung Website | Line Chart | Jumlah kunjungan per bulan, 12 bulan terakhir |
| Distribusi Koleksi per Kategori | Horizontal Bar Chart | Jumlah buku di setiap kategori |
| Distribusi per Tahun Terbit | Line Chart | Persebaran usia koleksi perpustakaan |
| Status Peminjaman | Donut Chart | Proporsi 5 status: aktif, dikembalikan, terlambat, pending, ditolak |
| Aktivitas Harian | Bar Chart | Volume request peminjaman per hari, 7 hari terakhir |

**c. Summary Cards dengan 8 Indikator Kunci**

Terdapat 8 kartu ringkasan yang menampilkan angka-angka kunci dengan animasi *counter* yang berjalan saat elemen pertama kali terlihat di layar menggunakan *Intersection Observer API*. Kedelapan indikator tersebut mencakup: total koleksi, buku tersedia, total kategori, total transaksi pinjam, total anggota, peminjaman aktif, total pengunjung website, dan pengunjung hari ini.

**d. JSON API Endpoint untuk Interoperabilitas**

Selain tampilan HTML, sistem juga menyediakan endpoint API (`GET /statistik/api-data`) yang mengembalikan data tren dalam format JSON. Endpoint ini memungkinkan integrasi dengan sistem lain atau penggunaan di masa mendatang untuk keperluan *real-time data refresh*, dan merupakan implementasi konsep *Data as a Service* (DaaS) dalam ekosistem Big Data.

**e. Keamanan Akses Berbasis Peran (RBAC)**

Halaman statistik dilindungi oleh dua lapis middleware yang memastikan hanya pengguna yang berwenang yang dapat mengakses data analitik perpustakaan:

- **Lapisan pertama** — middleware `auth`: memastikan pengguna sudah melakukan autentikasi (login).
- **Lapisan kedua** — middleware `role:super-admin|admin|librarian`: memastikan pengguna memiliki salah satu dari tiga peran yang diizinkan.

Mekanisme ini mencerminkan prinsip *data governance* dan *access control* yang merupakan bagian penting dari pengelolaan Big Data secara bertanggung jawab.

---

### 4.19 Multi-Layer Data Collection sebagai Infrastruktur Big Data

Sistem ini menerapkan mekanisme pengumpulan data multi-lapisan yang merupakan fondasi dari ekosistem Big Data. Setiap interaksi pengguna dengan sistem menghasilkan minimal satu layer data yang disimpan untuk keperluan analitik.

**Layer 1 — Web Traffic Analytics (`visitor_logs`)**

Setiap request HTTP ke website secara otomatis dicatat oleh middleware `TrackVisitor` dengan atribut yang lengkap:

| Atribut | Tipe Data | Keterangan |
|---------|-----------|-----------|
| `visited_on` | date | Tanggal kunjungan |
| `session_id` | string | Identifikasi sesi browser |
| `user_id` | bigint (nullable) | ID pengguna jika sudah login |
| `path` | string | URL halaman yang dikunjungi |
| `ip` | string | Alamat IP pengunjung |
| `user_agent` | string | Informasi browser dan perangkat |
| `referer` | string | Asal pengunjung (halaman sebelumnya) |

Data ini merupakan data *behavioral* yang kaya dan dapat digunakan untuk analisis pola penggunaan, segmentasi pengguna, dan optimasi pengalaman pengguna di masa mendatang.

**Layer 2 — Administrative Audit Trail (`user_activity_logs`)**

Setiap tindakan administratif yang dilakukan oleh admin atau librarian dicatat lengkap. Field `meta` bertipe JSON memungkinkan penyimpanan informasi kontekstual yang fleksibel dan beragam per jenis aksi, sehingga data log tidak kaku pada satu skema yang sama.

**Layer 3 — Transactional Data (`borrowings`)**

Setiap transaksi peminjaman mencatat **timeline lengkap** dengan timestamp di setiap tahapan proses: `requested_at`, `borrowed_at`, `due_date`, `returned_at`, dan `approved_at`. Data granular ini memungkinkan analisis latensi proses (berapa lama rata-rata persetujuan peminjaman), identifikasi pola keterlambatan pengembalian, dan penghitungan denda secara otomatis berdasarkan jumlah hari keterlambatan.

Kombinasi ketiga layer data ini membentuk fondasi *data lake* sederhana yang mencerminkan karakteristik **Velocity** (data terus bertambah secara kontinu) dan **Variety** (setiap layer memiliki skema dan jenis data yang berbeda) dalam kerangka Big Data.

---

### 4.20 Pemetaan Implementasi terhadap Capaian Pembelajaran Mata Kuliah Big Data

Berdasarkan uraian implementasi pada sub-bab 4.14 hingga 4.19, berikut adalah pemetaan antara komponen sistem yang dikembangkan dengan capaian pembelajaran yang relevan dalam mata kuliah Big Data:

| No. | Capaian Pembelajaran | Implementasi dalam Proyek | Bukti/Referensi |
|-----|---------------------|--------------------------|-----------------|
| 1 | Memahami dan menjelaskan konsep serta karakteristik Big Data (5V) | Sistem mengelola data dengan karakteristik Volume (14.333 record CSV), Velocity (3 log real-time), Variety (CSV + JSON + relasional), Veracity (data SLiMS tervalidasi), dan Value (analitik keputusan) | Sub-bab 4.14, folder `training/` |
| 2 | Merancang pipeline pengumpulan dan penyimpanan data | Multi-layer data collection: `visitor_logs`, `user_activity_logs`, `borrowings` — 3 pipeline berbeda dengan skema yang berbeda, dikumpulkan secara otomatis | Sub-bab 4.19, `TrackVisitor.php` |
| 3 | Melakukan pemrosesan data berskala besar | Chatbot memproses 8.809 record CSV secara efisien menggunakan `SplFileObject` dengan teknik streaming (baris demi baris) dan token-based IR scoring | Sub-bab 4.16, `ChatbotController.php` |
| 4 | Menerapkan teknik analitik data (Descriptive Analytics) | Dashboard admin: time-series 7 hari, temporal aggregation 12 bulan; Halaman statistik: top-N analysis, distribusi kategori, distribusi temporal | Sub-bab 4.17–4.18, `DashboardController.php`, `StatistikController.php` |
| 5 | Mengintegrasikan layanan AI/ML dalam ekosistem data | Chatbot mengintegrasikan Gemini API (LLM cloud) sebagai fallback dengan arsitektur hybrid retrieval: dataset lokal diutamakan, LLM sebagai cadangan | Sub-bab 4.16, `ChatbotController.php` |
| 6 | Memvisualisasikan data secara interaktif | 6 jenis chart interaktif menggunakan Chart.js; export grafik ke PNG menggunakan PHP GD Library; export laporan ke XLS | Sub-bab 4.17–4.18, halaman `/statistik` |
| 7 | Memahami infrastruktur dan skalabilitas sistem data | Containerisasi Docker; dukungan multi-driver database (SQLite/MySQL); JSON API endpoint (`/statistik/api-data`) untuk interoperabilitas | `docker-compose.yml`, `StatistikController.php` |
| 8 | Menerapkan keamanan dan tata kelola data (Data Governance) | Role-Based Access Control (RBAC) pada halaman analitik dengan middleware dua lapis; data hanya dapat diakses oleh peran yang berwenang | Sub-bab 4.18, `routes/web.php`, `CheckRole.php` |

Melalui implementasi nyata dalam lingkungan produksi perpustakaan, proyek magang ini telah mendemonstrasikan penerapan konsep Big Data secara holistik — mulai dari pengumpulan data, penyimpanan, pemrosesan, analisis, hingga visualisasi — dalam konteks sistem informasi perpustakaan yang sesungguhnya.

---

> **Catatan untuk versi laporan final:**
> Tambahkan tangkapan layar (*screenshot*) dari:
> 1. Tampilan halaman `/statistik` dengan semua chart yang terisi data nyata
> 2. Dashboard admin dengan grafik tren peminjaman dan pengunjung
> 3. Percakapan chatbot saat mencari koleksi (demonstrasi NLP)
> 4. Isi file CSV Senayan (beberapa baris pertama, tampilkan header kolom)
> 5. Cuplikan kode bagian scoring algorithm di `ChatbotController.php`
>
> Screenshot tersebut dapat diletakkan sebagai **Gambar 4.X** di dalam sub-bab yang bersesuaian.
