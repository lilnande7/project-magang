# 📸 BUKTI IMPLEMENTASI LOGBOOK MAGANG

> Dokumen ini berisi potongan kode, referensi file, dan panduan screenshot sebagai bukti implementasi untuk setiap minggu kegiatan magang.

---

## Minggu 1 — Orientasi & Konsep Dasar (9–13 Maret 2026)

### Bukti: Catatan Studi Arsitektur Laravel MVC

> **Screenshot yang perlu diambil:**
> - Foto/screenshot catatan konsep MVC
> - Screenshot halaman dokumentasi Laravel yang dipelajari
> - Foto situasi orientasi di perpustakaan (jika ada)

```
📁 Struktur MVC Laravel yang dipelajari:

app/
├── Http/
│   └── Controllers/    ← Controller (logika bisnis)
├── Models/             ← Model (interaksi database)
resources/
└── views/              ← View (tampilan Blade)
routes/
└── web.php             ← Routing
database/
└── migrations/         ← Skema database
```

---

## Minggu 2 — Setup Project & Docker (16–20 Maret 2026)

### Bukti 2.1: File `docker-compose.yml`
📄 **File:** `docker-compose.yml`

```yaml
services:
  magang:
    build: ./php
    image: magang:latest
    container_name: magang
    hostname: "magang"
    volumes:
      - ./:/var/www/html
      - ./php/www.conf:/usr/local/etc/php-fpm.d/www.conf
    working_dir: /var/www/html
    depends_on:
      - db

  db:
    image: mariadb:10.11
    container_name: db
    restart: unless-stopped
    tty: true
    ports:
      - "23306:3306"
    volumes:
      - db_data:/var/lib/mysql
      - ./db/conf.d:/etc/mysql/conf.d:ro
    environment:
      MYSQL_DATABASE: laravel
      MYSQL_USER: djambred
      MYSQL_PASSWORD: p455w0rd1!.
      MYSQL_ROOT_PASSWORD: p455w0rd
      TZ: Asia/Jakarta

  magang_nginx:
    build: ./nginx
    image: magang_nginx:latest
    container_name: magang_nginx
    hostname: "magang_nginx"
    ports:
      - "80:80"
    volumes:
      - ./:/var/www/html
      - ./nginx/default.conf:/etc/nginx/conf.d/default.conf
    depends_on:
      - magang

volumes:
  db_data:
```

### Bukti 2.2: File `vite.config.js`
📄 **File:** `vite.config.js`

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
```

> **Screenshot yang perlu diambil:**
> - Terminal: `docker-compose up -d` berhasil
> - Terminal: `docker ps` menampilkan 3 container running
> - Browser: Halaman default Laravel berhasil diakses di `http://localhost`

---

## Minggu 3 — Database & Wireframe (23–27 Maret 2026)

### Bukti 3.1: Migration Tabel `books`
📄 **File:** `database/migrations/2026_02_24_074732_create_books_table.php`

```php
Schema::create('books', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('author');
    $table->string('isbn')->nullable();
    $table->string('publisher')->nullable();
    $table->year('year')->nullable();
    $table->integer('pages')->nullable();
    $table->string('language')->default('Indonesia');
    $table->text('description')->nullable();
    $table->string('location')->nullable();
    $table->enum('status', ['available', 'borrowed', 'maintenance', 'lost'])->default('available');
    $table->unsignedBigInteger('category_id')->nullable();
    $table->string('cover_image')->nullable();
    $table->text('subjects')->nullable();
    $table->integer('stock')->default(1);
    $table->timestamps();

    $table->index(['title', 'author']);
    $table->index('status');
});
```

### Bukti 3.2: Migration Tabel `borrowings`
📄 **File:** `database/migrations/2026_02_24_074815_create_borrowings_table.php`

```php
Schema::create('borrowings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('book_id')->constrained()->onDelete('cascade');
    $table->date('borrowed_at');
    $table->date('due_date');
    $table->date('returned_at')->nullable();
    $table->enum('status', ['active', 'returned', 'overdue'])->default('active');
    $table->decimal('fine_amount', 10, 2)->default(0);
    $table->text('notes')->nullable();
    $table->timestamps();

    $table->index(['user_id', 'status']);
    $table->index(['book_id', 'status']);
    $table->index('due_date');
});
```

### Bukti 3.3: Migration Tabel `roles` & `user_roles`
📄 **File:** `database/migrations/2026_02_24_075741_create_roles_table.php`

```php
Schema::create('roles', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    $table->index('slug');
});
```

📄 **File:** `database/migrations/2026_02_24_075755_create_user_roles_table.php`

```php
Schema::create('user_roles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('role_id')->constrained()->onDelete('cascade');
    $table->timestamp('assigned_at')->useCurrent();
    $table->timestamps();
    $table->unique(['user_id', 'role_id']);
});
```

### Bukti 3.4: Migration Tabel `news`
📄 **File:** `database/migrations/2026_02_24_075931_create_news_table.php`

```php
Schema::create('news', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('excerpt')->nullable();
    $table->longText('content');
    $table->string('featured_image')->nullable();
    $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
    $table->boolean('is_featured')->default(false);
    $table->timestamp('published_at')->nullable();
    $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
    $table->json('tags')->nullable();
    $table->integer('views_count')->default(0);
    $table->timestamps();

    $table->index(['status', 'published_at']);
    $table->index(['is_featured', 'published_at']);
});
```

### Bukti 3.5: Wireframe UI
📄 **Folder:** `docs/wireframes/`

> **Screenshot yang perlu diambil:**
> - Screenshot seluruh file wireframe di folder `docs/wireframes/`
> - Tampilkan wireframe berikut: Homepage, Login/Register, Katalog, Admin Dashboard

```
docs/wireframes/
├── 01_homepage.jpg
├── 02_login_register.jpg
├── 03_katalog.jpg
├── 04_katalog_detail.jpg
├── 05_layanan.jpg
├── 06_berita.jpg
├── 07_berita_detail.jpg
├── 08_hubungi_kami.jpg
├── 09_chatbot.jpg
├── 10_admin_dashboard.jpg
├── 11_admin_katalog.jpg
└── 12_admin_pesan.jpg
```

> **Screenshot:** Terminal `php artisan migrate` berhasil running

---

## Minggu 4 — Layout, Navbar & Footer (30 Maret – 3 April 2026)

### Bukti 4.1: Struktur Layout Utama
📄 **File:** `resources/views/layouts/app.blade.php` *(head section)*

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan PPI Curug')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Space+Grotesk:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootsnav CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootsnav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
```

### Bukti 4.2: Navbar dengan Megamenu
📄 **File:** `resources/views/partials/navbar.blade.php` *(potongan)*

```html
<!-- Top Bar -->
<div class="top-bar" id="top-bar">
    <div class="container">
        <div class="top-bar-left">
            <span><i class="fas fa-phone-alt"></i> (021) 5982204</span>
            <span><i class="fas fa-envelope"></i> ppi@ppicurug.ac.id</span>
            <span><i class="fas fa-clock"></i> Sen - Jum 08:00 - 17:00</span>
        </div>
        <div class="top-bar-right">
            <span class="npp-badge">NPP: 3603202C0000001</span>
            <a href="https://instagram.com/avialib_ppicurug"><i class="fab fa-instagram"></i></a>
            @auth
                <span>Halo, {{ Auth::user()->name }}</span>
            @else
                <a href="{{ route('login') }}" class="btn-login">Login</a>
            @endauth
        </div>
    </div>
</div>

<!-- Main Navigation -->
<nav class="navbar navbar-default bootsnav navbar-fixed">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('home') }}">HOME</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">PROFILE</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('profile.sejarah') }}">Sejarah</a></li>
                        <li><a href="{{ route('profile.struktur-organisasi') }}">Struktur Organisasi</a></li>
                        <li><a href="{{ route('profile.visi-misi') }}">Visi & Misi</a></li>
                        <!-- ... -->
                    </ul>
                </li>
                <li class="dropdown megamenu-fw">
                    <a href="#" class="dropdown-toggle">LAYANAN KAMI</a>
                    <!-- Megamenu content -->
                </li>
            </ul>
        </div>
    </div>
</nav>
```

> **Screenshot yang perlu diambil:**
> - Browser: Tampilan navbar desktop (full width)
> - Browser: Dropdown menu Profile terbuka
> - Browser: Tampilan footer
> - Browser: Tampilan mobile (hamburger menu)

---

## Minggu 5 & 6 — Halaman Home (6–17 April 2026)

### Bukti 5.1: Hero Section dengan Rotating Text
📄 **File:** `resources/views/home.blade.php` *(hero section)*

```html
<!-- Hero Section -->
<section class="hero-section" id="hero">
    <div class="hero-slideshow">
        <div class="slide active" style="background-image: url('{{ asset('images/hero1.jpg') }}')"></div>
        <div class="slide" style="background-image: url('{{ asset('images/hero2.jpg') }}')"></div>
        <div class="slide" style="background-image: url('{{ asset('images/hero3.jpg') }}')"></div>
    </div>
    <div class="hero-content">
        <div class="hero-badge animate__animated animate__fadeInDown">
            <span>Perpustakaan Digital Aviasi</span>
        </div>
        <h1 class="hero-title">
            <span class="rotating-text" data-words='["Perpustakaan","Knowledge Hub","Digital Library","Aviation Archive"]'>
                Perpustakaan
            </span>
        </h1>
        <p class="hero-subtitle">Politeknik Penerbangan Indonesia Curug</p>
        <div class="hero-cta">
            <a href="{{ route('profile') }}" class="btn btn-primary">Lihat Profil</a>
            <a href="{{ route('catalog.index') }}" class="btn btn-outline">Katalog Online</a>
        </div>
    </div>
</section>
```

### Bukti 5.2: Top Categories dengan Live Count
📄 **File:** `app/Http/Controllers/HomeController.php` *(potongan)*

```php
public function index()
{
    // Berita terbaru
    $latestNews = News::published()->latest('published_at')->take(6)->get();
    $featuredNews = News::published()->featured()->latest('published_at')->first();

    // Kategori dengan jumlah buku
    $topCategories = Category::where('is_active', true)
        ->withCount('books')
        ->orderByDesc('books_count')
        ->take(8)
        ->get();

    // Statistik perpustakaan
    $stats = [
        'total_books' => Book::count(),
        'total_categories' => Category::where('is_active', true)->count(),
        'total_members' => User::count(),
    ];

    return view('home', compact('latestNews', 'featuredNews', 'topCategories', 'stats'));
}
```

> **Screenshot yang perlu diambil:**
> - Browser: Hero section lengkap dengan slideshow
> - Browser: Section kategori buku dengan jumlah koleksi
> - Browser: Section berita terbaru
> - Browser: Section Tim Pustakawan
> - Browser: Chatbot widget (pojok kanan bawah)

---

## Minggu 7 — Modul Profil (20–24 April 2026)

### Bukti 7.1: Route Halaman Profil
📄 **File:** `routes/web.php`

```php
// Halaman Profil
Route::get('/profile', function () {
    return view('profile.index', ['title' => 'Profile - Perpustakaan PPIC']);
})->name('profile');

// Sub-halaman Profile
Route::get('/profile/sejarah', function () {
    return view('profile.sejarah', ['title' => 'Sejarah - Perpustakaan PPIC']);
})->name('profile.sejarah');

Route::get('/profile/struktur-organisasi', function () {
    return view('profile.struktur-organisasi', ['title' => 'Struktur Organisasi - Perpustakaan PPIC']);
})->name('profile.struktur-organisasi');

Route::get('/profile/visi-misi', function () {
    return view('profile.visi-misi', ['title' => 'Visi & Misi - Perpustakaan PPIC']);
})->name('profile.visi-misi');

Route::get('/profile/tata-tertib', function () {
    return view('profile.tata-tertib', ['title' => 'Tata Tertib - Perpustakaan PPIC']);
})->name('profile.tata-tertib');

Route::get('/profile/akreditasi', function () {
    return view('profile.akreditasi', ['title' => 'Akreditasi - Perpustakaan PPIC']);
})->name('profile.akreditasi');

Route::get('/profile/npp', function () {
    return view('profile.npp', ['title' => 'Nomor Pokok Perpustakaan - Perpustakaan PPIC']);
})->name('profile.npp');
```

### Bukti 7.2: Struktur File View Profil
```
resources/views/profile/
├── index.blade.php             → Overview profil
├── sejarah.blade.php           → Timeline sejarah 1952–sekarang
├── struktur-organisasi.blade.php → Bagan organisasi
├── visi-misi.blade.php         → Visi & misi
├── tata-tertib.blade.php       → Aturan peminjaman & jam operasional
├── akreditasi.blade.php        → Status akreditasi Perpusnas
└── npp.blade.php               → Nomor Pokok Perpustakaan
```

> **Screenshot yang perlu diambil:**
> - Browser: Halaman Sejarah dengan timeline
> - Browser: Halaman Tata Tertib (tabel aturan peminjaman)
> - Browser: Halaman Akreditasi
> - Browser: Halaman Visi & Misi

---

## Minggu 8 — Autentikasi & RBAC (27 April – 1 Mei 2026)

### Bukti 8.1: Model User dengan Role System
📄 **File:** `app/Models/User.php`

```php
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'avatar_path', 'password'];

    // Role & Permission relationships
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function hasRole($roles): bool
    {
        if (is_string($roles)) {
            return $this->roles->contains('slug', $roles);
        }
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->roles->contains('slug', $role)) {
                    return true;
                }
            }
            return false;
        }
        return $this->roles->contains($roles);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin') || $this->hasRole('super-admin');
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }
}
```

### Bukti 8.2: Middleware CheckRole
📄 **File:** `app/Http/Middleware/CheckRole.php`

```php
class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Handle pipe-separated roles (e.g., 'super-admin|admin')
        $allowedRoles = [];
        foreach ($roles as $role) {
            if (str_contains($role, '|')) {
                $allowedRoles = array_merge($allowedRoles, explode('|', $role));
            } else {
                $allowedRoles[] = $role;
            }
        }

        if (!$request->user()->hasRole($allowedRoles)) {
            abort(403, 'Unauthorized. You do not have the required role.');
        }

        return $next($request);
    }
}
```

### Bukti 8.3: Route Auth & Admin Protection
📄 **File:** `routes/web.php`

```php
// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes — dilindungi middleware auth + role
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:super-admin|admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // ... semua route admin
});
```

> **Screenshot yang perlu diambil:**
> - Browser: Halaman Login
> - Browser: Halaman Register
> - Browser: Error 403 ketika user biasa akses `/admin/dashboard`
> - Browser: Redirect ke login ketika belum login akses admin

---

## Minggu 9 — Admin Dashboard (4–8 Mei 2026)

### Bukti 9.1: Middleware TrackVisitor
📄 **File:** `app/Http/Middleware/TrackVisitor.php`

```php
class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        if ($this->shouldSkip($request)) {
            return $response;
        }
        try {
            $this->logVisit($request);
        } catch (QueryException) {
            // Ignore when table not migrated yet.
        }
        return $response;
    }

    private function logVisit(Request $request): void
    {
        $today = now()->toDateString();
        $sessionKey = 'visitor_last_logged_on';

        if ($request->session()->get($sessionKey) === $today) {
            return;
        }

        $request->session()->put($sessionKey, $today);

        VisitorLog::create([
            'visited_on' => $today,
            'session_id' => $request->session()->getId(),
            'user_id'    => $request->user()?->id,
            'path'       => '/'. $request->path(),
            'ip'         => $request->ip(),
            'user_agent' => mb_substr($request->userAgent(), 0, 512),
            'referer'    => $request->headers->get('referer'),
        ]);
    }
}
```

### Bukti 9.2: Migration Visitor Logs & Activity Logs

```php
// visitor_logs
Schema::create('visitor_logs', function (Blueprint $table) {
    $table->id();
    $table->date('visited_on')->index();
    $table->string('session_id', 100)->index();
    $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
    $table->string('path', 2048);
    $table->string('ip', 45)->nullable();
    $table->string('user_agent', 512)->nullable();
    $table->string('referer', 2048)->nullable();
    $table->timestamps();
    $table->unique(['visited_on', 'session_id']);
});

// user_activity_logs
Schema::create('user_activity_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
    $table->foreignId('target_user_id')->nullable()->constrained('users')->nullOnDelete();
    $table->string('action');
    $table->text('description')->nullable();
    $table->json('meta')->nullable();
    $table->timestamps();
});
```

> **Screenshot yang perlu diambil:**
> - Browser: Admin Dashboard — 4 KPI cards (Total Buku, Pengguna, Berita, Peminjaman)
> - Browser: Grafik Chart.js statistik pengunjung bulanan
> - Browser: Panel aktivitas terbaru
> - Browser: Sidebar navigasi admin

---

## Minggu 10 — CRUD Buku (11–15 Mei 2026)

### Bukti 10.1: Model Book
📄 **File:** `app/Models/Book.php`

```php
class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'author', 'isbn', 'publisher', 'year', 'pages',
        'language', 'description', 'location', 'status', 'category_id',
        'cover_image', 'subjects', 'stock',
        // Biblio SLiMS
        'gmd_name', 'call_number', 'place_name', 'classification',
        'series_title', 'collation', 'cover_url', 'item_code', 'topics',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('author', 'like', "%{$search}%")
              ->orWhere('subjects', 'like', "%{$search}%");
        });
    }
}
```

> **Screenshot yang perlu diambil:**
> - Browser: Halaman daftar buku admin (DataTables)
> - Browser: Form tambah buku baru (dengan upload cover)
> - Browser: Form edit buku
> - Browser: Konfirmasi hapus buku
> - Browser: Detail buku di admin

---

## Minggu 11 — CRUD Berita (18–22 Mei 2026)

### Bukti 11.1: Model News dengan Auto-Slug & Reading Time
📄 **File:** `app/Models/News.php`

```php
class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'featured_image',
        'status', 'is_featured', 'published_at', 'author_id', 'tags', 'views_count'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured'  => 'boolean',
        'tags'         => 'array',
    ];

    // Auto-generate slug dari judul
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Auto-generate excerpt jika kosong
    public function getExcerptAttribute($value)
    {
        if ($value) return $value;
        return Str::limit(strip_tags($this->content), 150);
    }

    // Hitung waktu baca
    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200);
        return $minutes . ' menit baca';
    }

    public function publishNow()
    {
        $this->update([
            'status' => 'published',
            'published_at' => now()
        ]);
    }
}
```

> **Screenshot yang perlu diambil:**
> - Browser: Daftar berita admin (status badge draft/published/archived)
> - Browser: Form tambah berita (dengan upload featured image)
> - Browser: Tombol "Publish Now"

---

## Minggu 12 — Katalog Publik (25–29 Mei 2026)

### Bukti 12.1: CatalogController — Multi-Search & Filter
📄 **File:** `app/Http/Controllers/CatalogController.php` *(potongan index)*

```php
public function index(Request $request)
{
    $query = Book::with('category');

    // Multi-field search
    if ($request->filled('q')) {
        $search = $request->q;
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('author', 'like', "%{$search}%")
              ->orWhere('isbn', 'like', "%{$search}%")
              ->orWhere('call_number', 'like', "%{$search}%")
              ->orWhere('publisher', 'like', "%{$search}%")
              ->orWhere('subjects', 'like', "%{$search}%")
              ->orWhere('topics', 'like', "%{$search}%");
        });
    }

    // Filter kategori, status, bahasa
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    if ($request->filled('language')) {
        $query->where('language', $request->language);
    }

    // Sorting
    $sort = $request->get('sort', 'title_asc');
    // ... sorting logic

    $books = $query->paginate(12)->withQueryString();
    $categories = Category::where('is_active', true)->get();

    return view('catalog.index', compact('books', 'categories'));
}
```

> **Screenshot yang perlu diambil:**
> - Browser: Halaman katalog publik dengan grid buku
> - Browser: Search bar dengan hasil pencarian
> - Browser: Filter kategori aktif
> - Browser: Detail buku (metadata bibliografi lengkap)
> - Browser: Carousel buku terkait

---

## Minggu 13 — Sistem Peminjaman (1–5 Juni 2026)

### Bukti 13.1: Model Borrowing dengan Kalkulasi Denda
📄 **File:** `app/Models/Borrowing.php`

```php
class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'book_id', 'requested_at', 'borrowed_at', 'due_date',
        'returned_at', 'status', 'fine_amount', 'notes',
        'approved_by', 'approved_at', 'rejection_reason',
    ];

    public function user()   { return $this->belongsTo(User::class); }
    public function book()   { return $this->belongsTo(Book::class); }
    public function approvedBy() { return $this->belongsTo(User::class, 'approved_by'); }

    // Scopes
    public function scopePending($query)  { return $query->where('status', 'pending'); }
    public function scopeActive($query)   { return $query->where('status', 'active'); }
    public function scopeOverdue($query)  {
        return $query->where('status', 'active')->where('due_date', '<', now());
    }

    // Cek apakah terlambat
    public function getIsOverdueAttribute()
    {
        return $this->status === 'active' && $this->due_date < now();
    }

    // Hitung hari keterlambatan
    public function getDaysOverdueAttribute()
    {
        if (!$this->is_overdue) return 0;
        return now()->diffInDays($this->due_date);
    }

    // Hitung denda: Rp 1.000 per hari
    public function calculateFine()
    {
        if (!$this->is_overdue) return 0;
        return $this->days_overdue * 1000;
    }
}
```

### Bukti 13.2: Request Peminjaman (max 3 buku)
📄 **File:** `app/Http/Controllers/CatalogController.php` *(potongan)*

```php
public function requestBorrow(Request $request, Book $book)
{
    $user = Auth::user();

    // Cek apakah sudah punya 3 peminjaman aktif/pending
    $activeCount = Borrowing::where('user_id', $user->id)
        ->whereIn('status', ['pending', 'active'])
        ->count();

    if ($activeCount >= 3) {
        return back()->with('error', 'Anda sudah memiliki 3 peminjaman aktif/pending.');
    }

    // Cek stok
    if ($book->stock <= 0 || $book->status !== 'available') {
        return back()->with('error', 'Buku sedang tidak tersedia.');
    }

    Borrowing::create([
        'user_id'      => $user->id,
        'book_id'      => $book->id,
        'requested_at' => now(),
        'status'       => 'pending',
        'notes'        => $request->notes,
    ]);

    return back()->with('success', 'Permintaan peminjaman berhasil dikirim!');
}
```

> **Screenshot yang perlu diambil:**
> - Browser: Tombol "Pinjam Buku" di halaman detail (user login)
> - Browser: Pesan "Login diperlukan" (guest)
> - Browser: Error max 3 peminjaman
> - Browser: Halaman riwayat peminjaman saya (status pills)

---

## Minggu 14 — Admin Approval Peminjaman (8–12 Juni 2026)

### Bukti 14.1: Workflow Approve
📄 **File:** `app/Http/Controllers/Admin/BorrowingController.php`

```php
public function approve(Request $request, Borrowing $borrowing)
{
    if ($borrowing->status !== 'pending') {
        return back()->with('error', 'Hanya permintaan pending yang dapat disetujui.');
    }

    $request->validate([
        'due_days' => 'required|integer|min:1|max:60',
        'notes'    => 'nullable|string|max:500',
    ]);

    $borrowedAt = Carbon::today();
    $dueDate    = $borrowedAt->copy()->addDays((int) $request->due_days);

    $borrowing->update([
        'status'      => 'active',
        'borrowed_at' => $borrowedAt,
        'due_date'    => $dueDate,
        'approved_by' => Auth::id(),
        'approved_at' => now(),
    ]);

    // Jika stok habis, ubah status buku
    $book = $borrowing->book;
    $activeCount = Borrowing::where('book_id', $book->id)->active()->count();
    if ($activeCount >= $book->stock) {
        $book->update(['status' => 'borrowed']);
    }

    return redirect()->route('admin.borrowings.index')
        ->with('success', "Peminjaman disetujui. Tenggat: {$dueDate->format('d M Y')}.");
}
```

### Bukti 14.2: Return Book dengan Auto-Fine

```php
public function returnBook(Request $request, Borrowing $borrowing)
{
    $fine = $borrowing->calculateFine();

    $borrowing->update([
        'status'      => 'returned',
        'returned_at' => Carbon::today(),
        'fine_amount' => $fine,
    ]);

    // Update stok buku kembali tersedia
    $book = $borrowing->book;
    $activeCount = Borrowing::where('book_id', $book->id)->active()->count();
    if ($activeCount < $book->stock) {
        $book->update(['status' => 'available']);
    }

    $msg = "Buku \"{$book->title}\" berhasil dikembalikan.";
    if ($fine > 0) {
        $msg .= " Denda: Rp " . number_format($fine, 0, ',', '.');
    }

    return redirect()->route('admin.borrowings.index')->with('success', $msg);
}
```

> **Screenshot yang perlu diambil:**
> - Browser: Halaman admin peminjaman — tab status (Pending, Active, Overdue, dll.)
> - Browser: Form approve dengan input durasi hari
> - Browser: Form reject dengan alasan penolakan
> - Browser: Pesan sukses setelah return buku (dengan denda jika ada)

---

## Minggu 15 — Berita Publik (15–19 Juni 2026)

### Bukti 15.1: Route Berita Publik

```php
Route::get('/berita', [HomeController::class, 'news'])->name('news.index');
Route::get('/news/{id}', [HomeController::class, 'showNews'])->name('news.show');
```

> **Screenshot yang perlu diambil:**
> - Browser: Halaman daftar berita publik (featured + grid)
> - Browser: Detail artikel dengan meta info (tanggal, author, kategori)
> - Browser: Share buttons (Facebook, Twitter, WhatsApp)
> - Browser: Section "Berita Terkait"

---

## Minggu 16 — Layanan & Hubungi Kami (22–26 Juni 2026)

### Bukti 16.1: ContactController dengan Email Fallback
📄 **File:** `app/Http/Controllers/ContactController.php`

```php
class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'name'    => 'required|max:100',
            'email'   => 'required|email',
            'message' => 'required|max:2000',
        ]);

        $data = $request->only(['name', 'email', 'message']);

        try {
            // Coba kirim email
            Mail::to('ppicurug.library@gmail.com')
                ->send((new ContactMail($data))->replyTo($request->email, $request->name));

            return back()->with('success', 'Pesan berhasil dikirim.');
        } catch (\Throwable $e) {
            Log::error('Contact form mail failed: ' . $e->getMessage());

            // FALLBACK: Simpan ke database jika email gagal
            Complaint::create([
                'name'       => $data['name'],
                'email'      => $data['email'],
                'message'    => $data['message'],
                'status'     => Complaint::STATUS_MASUK,
                'ip'         => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return back()->with('success', 'Pesan diterima. Kami akan menindaklanjuti.');
        }
    }
}
```

### Bukti 16.2: Model Complaint
📄 **File:** `app/Models/Complaint.php`

```php
class Complaint extends Model
{
    public const STATUS_MASUK    = 'masuk';
    public const STATUS_DIPROSES = 'diproses';
    public const STATUS_SELESAI  = 'selesai';

    protected $fillable = [
        'name', 'email', 'message', 'status',
        'ip', 'user_agent', 'admin_id', 'processed_at', 'completed_at',
    ];
}
```

> **Screenshot yang perlu diambil:**
> - Browser: Halaman Layanan (kartu layanan + fasilitas)
> - Browser: Halaman Hubungi Kami (form kontak)
> - Browser: Google Maps embed
> - Browser: Pesan sukses setelah kirim form

---

## Minggu 17 — Admin Users & Keluhan (29 Juni – 3 Juli 2026)

### Bukti 17.1: Route Admin Resources

```php
// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:super-admin|admin'])->group(function () {
    Route::resource('users', AdminUserController::class)->except(['show']);
    Route::resource('complaints', AdminComplaintController::class)->only(['index', 'show', 'update']);
});
```

> **Screenshot yang perlu diambil:**
> - Browser: Halaman admin daftar pengguna (stats row + tabel)
> - Browser: Form tambah user (dengan multi-role checkboxes)
> - Browser: Halaman admin keluhan (filter status masuk/diproses/selesai)
> - Browser: Detail keluhan (update status)

---

## Minggu 18 — Visitor Analytics & Export (6–10 Juli 2026)

### Bukti 18.1: Migration Visitor Logs
📄 **File:** `database/migrations/2026_04_08_000001_create_visitor_logs_table.php`

```php
Schema::create('visitor_logs', function (Blueprint $table) {
    $table->id();
    $table->date('visited_on')->index();
    $table->string('session_id', 100)->index();
    $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
    $table->string('path', 2048);
    $table->string('ip', 45)->nullable();
    $table->string('user_agent', 512)->nullable();
    $table->string('referer', 2048)->nullable();
    $table->timestamps();
    $table->unique(['visited_on', 'session_id']);
});
```

### Bukti 18.2: Route Export Excel

```php
Route::get('/dashboard/visitors/export', [DashboardController::class, 'exportVisitorsYear'])
    ->name('dashboard.visitors.export');
```

> **Screenshot yang perlu diambil:**
> - Browser: Dashboard — grafik Chart.js visitor bulanan
> - Browser: Dropdown filter tahun pada chart
> - Browser: File Excel yang ter-download

---

## Minggu 19 — Chatbot AI Gemini (13–17 Juli 2026)

### Bukti 19.1: ChatbotController — Dual Engine (SLiMS + Gemini)
📄 **File:** `app/Http/Controllers/API/ChatbotController.php`

```php
class ChatbotController extends Controller
{
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array',
        ]);

        $userMessage = trim($validated['message']);

        // ENGINE 1: Cari di dataset SLiMS (CSV)
        $senayanItem = $this->findSenayanItem($userMessage);

        if ($senayanItem) {
            return response()->json([
                'status'  => 'success',
                'message' => $this->formatSenayanReply($senayanItem),
                'source'  => 'senayan_dataset',
            ]);
        }

        // ENGINE 2: Fallback ke Google Gemini API
        $apiKey = config('services.gemini.api_key');
        $model = config('services.gemini.model', 'gemini-1.5-flash');

        // System prompt dengan konteks koleksi dari database
        $bookContext = Book::with('category')->latest()->limit(8)->get()
            ->map(fn(Book $b) => "- {$b->title} | {$b->author} | {$b->category?->name}")
            ->implode("\n");

        $response = Http::timeout(30)->post(
            "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
            [
                'systemInstruction' => ['parts' => [['text' => $systemInstruction]]],
                'contents' => $contents,
                'generationConfig' => ['temperature' => 0.3, 'maxOutputTokens' => 600],
            ]
        );

        return response()->json(['status' => 'success', 'message' => $reply]);
    }
}
```

### Bukti 19.2: Fuzzy Matching SLiMS Dataset

```php
private function findSenayanItem(string $message): ?array
{
    $query = $this->normalizeText($message);
    $queryTokens = $this->filterSearchTokens(explode(' ', $query));
    $bestItem = null;
    $bestScore = 0;

    foreach ($this->loadSenayanItems() as $item) {
        $score = 0;

        // Exact substring match = highest score
        if (Str::contains($item['title_normalized'], $query)) {
            $score += 140;
        }

        // Token-by-token matching
        foreach ($queryTokens as $token) {
            if (Str::contains($item['title_normalized'], $token)) $score += 35;
            if (Str::contains($item['call_number_normalized'], $token)) $score += 18;
        }

        if ($score > $bestScore) {
            $bestScore = $score;
            $bestItem = $item;
        }
    }

    return $bestScore >= 30 ? $bestItem : null;
}
```

### Bukti 19.3: Format Reply SLiMS

```php
private function formatSenayanReply(array $item): string
{
    $statusLabel = Str::contains(Str::lower($item['status']), 'missing')
        ? '❌ Tidak tersedia'
        : '✅ Tersedia';

    return "📚 **Buku ditemukan**\n\n"
        . "**Judul** : {$item['title']}\n\n"
        . "**Nomor Panggil** : {$item['call_number']}\n\n"
        . "**Lokasi Rak** : {$item['shelf']}\n\n"
        . "**Status** : {$statusLabel}";
}
```

### Bukti 19.4: API Route Chatbot

```php
// routes/api.php
Route::prefix('v1')->group(function () {
    Route::post('/chatbot', [ChatbotController::class, 'chat'])->name('chatbot.chat');
});
```

### Bukti 19.5: Training Data SLiMS
```
training/
├── senayan_biblio_export.csv    (2.18 MB — metadata bibliografi)
└── senayan_item_export.csv      (2.17 MB — data eksemplar untuk chatbot)
```

> **Screenshot yang perlu diambil:**
> - Browser: Chatbot widget (FAB button di pojok kanan bawah)
> - Browser: Chat window terbuka — tanya "buku penerbangan"
> - Browser: Response chatbot dengan data buku dari SLiMS
> - Browser: Response chatbot dari Gemini AI (pertanyaan umum)

---

## Minggu 20 — OPAC, Testing & Bug Fix (20–24 Juli 2026)

### Bukti 20.1: Route OPAC & Kerjasama

```php
// Halaman OPAC
Route::get('/opac', function () {
    return view('opac.index', ['title' => 'OPAC - Perpustakaan PPIC']);
})->name('opac');

Route::get('/opac/detail/{id}', function ($id) {
    return view('opac.detail', ['title' => 'Detail Koleksi', 'id' => $id]);
})->name('opac.detail');

// Halaman Galeri/Layanan
Route::get('/galeri0', function () {
    return view('layanan.index', ['title' => 'Galeri - Perpustakaan PPIC']);
})->name('gallery');

Route::redirect('/layanan', '/galeri0', 301);
```

> **Screenshot yang perlu diambil:**
> - Browser: Halaman OPAC dengan pencarian
> - Browser: Responsive test — tampilan mobile (Chrome DevTools)
> - Browser: Responsive test — tampilan tablet
> - Terminal: Output `php artisan route:list` (daftar semua route)

---

## Minggu 21 — Dokumentasi & Finalisasi (27–30 Juli 2026)

### Bukti 21.1: Struktur File Lengkap Project
```
project_magang/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── BookController.php
│   │   │   │   ├── BorrowingController.php
│   │   │   │   ├── ComplaintController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── NewsController.php
│   │   │   │   └── UserController.php
│   │   │   ├── API/
│   │   │   │   ├── BookController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   └── ChatbotController.php
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── RegisterController.php
│   │   │   ├── CatalogController.php
│   │   │   ├── ContactController.php
│   │   │   └── HomeController.php
│   │   └── Middleware/
│   │       ├── CheckRole.php
│   │       └── TrackVisitor.php
│   └── Models/
│       ├── Book.php
│       ├── Borrowing.php
│       ├── Category.php
│       ├── Complaint.php
│       ├── News.php
│       ├── Permission.php
│       ├── Role.php
│       ├── User.php
│       ├── UserActivityLog.php
│       └── VisitorLog.php
├── database/migrations/     (19 file migration)
├── resources/views/
│   ├── admin/              (dashboard, books, borrowings, news, users, complaints, exports)
│   ├── auth/               (login, register)
│   ├── catalog/            (index, show, my-borrowings)
│   ├── hubungikami/        (index)
│   ├── layanan/            (index)
│   ├── layouts/            (app)
│   ├── news/               (index, show)
│   ├── partials/           (navbar, footer)
│   ├── profile/            (7 sub-halaman)
│   └── home.blade.php
├── routes/
│   ├── web.php             (131 baris — 25+ route)
│   └── api.php             (API endpoints)
├── training/               (SLiMS CSV datasets)
├── docs/
│   ├── wireframes/         (12 file wireframe)
│   ├── logbook_magang.md
│   └── bukti_implementasi_logbook.md
├── docker-compose.yml
├── vite.config.js
└── composer.json
```

### Bukti 21.2: Seluruh Routes Terdaftar
📄 **File:** `routes/web.php` — 131 baris

```php
// Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Berita
Route::get('/berita', [HomeController::class, 'news'])->name('news.index');
Route::get('/news/{id}', [HomeController::class, 'showNews'])->name('news.show');

// Profile (7 halaman)
Route::get('/profile', ...)->name('profile');
Route::get('/profile/sejarah', ...)->name('profile.sejarah');
Route::get('/profile/struktur-organisasi', ...)->name('profile.struktur-organisasi');
Route::get('/profile/visi-misi', ...)->name('profile.visi-misi');
Route::get('/profile/tata-tertib', ...)->name('profile.tata-tertib');
Route::get('/profile/akreditasi', ...)->name('profile.akreditasi');
Route::get('/profile/npp', ...)->name('profile.npp');

// Kontak & Layanan
Route::get('/hubungikami', [ContactController::class, 'index']);
Route::post('/hubungikami', [ContactController::class, 'submit']);
Route::get('/galeri0', ...)->name('gallery');

// OPAC
Route::get('/opac', ...)->name('opac');

// Katalog (public + auth)
Route::get('/katalog', [CatalogController::class, 'index']);
Route::get('/katalog/{book}', [CatalogController::class, 'show']);

// Auth protected
Route::middleware('auth')->group(function () {
    Route::post('/katalog/{book}/pinjam', ...);
    Route::get('/peminjaman-saya', ...);
    Route::delete('/peminjaman/{borrowing}/batal', ...);
});

// Admin (auth + role:super-admin|admin)
Route::prefix('admin')->middleware(['auth', 'role:super-admin|admin'])->group(function () {
    Route::get('/dashboard', ...);
    Route::resource('books', AdminBookController::class);
    Route::resource('news', AdminNewsController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('complaints', AdminComplaintController::class);
    Route::get('/peminjaman', ...);
    Route::post('/peminjaman/{borrowing}/approve', ...);
    Route::post('/peminjaman/{borrowing}/reject', ...);
    Route::post('/peminjaman/{borrowing}/return', ...);
});
```

> **Screenshot yang perlu diambil:**
> - Terminal: `php artisan route:list`
> - Terminal: `php artisan migrate:status` (semua migration sudah run)
> - Browser: Halaman utama final (full page)

---

## 📌 Panduan Screenshot untuk Bukti Tambahan

Berikut daftar screenshot yang direkomendasikan untuk dilampirkan per minggu:

| Minggu | Screenshot yang Dibutuhkan |
|--------|---------------------------|
| 1 | Catatan/notulen orientasi |
| 2 | `docker ps`, halaman default Laravel |
| 3 | phpMyAdmin — tabel database, wireframe UI |
| 4 | Navbar desktop, dropdown menu, footer, mobile hamburger |
| 5-6 | Homepage full: hero, kategori, berita, tim pustakawan, chatbot |
| 7 | Halaman profil: sejarah, tata tertib, akreditasi, visi misi |
| 8 | Login, register, error 403 unauthorized |
| 9 | Admin dashboard: KPI cards, chart visitor, activity log |
| 10 | Admin buku: tabel, form tambah, edit, hapus |
| 11 | Admin berita: tabel, form, publish |
| 12 | Katalog publik: search, filter, detail buku |
| 13 | Peminjaman: tombol pinjam, max 3, riwayat peminjaman |
| 14 | Admin peminjaman: approve, reject, return dengan denda |
| 15 | Berita publik: featured, grid, detail, share |
| 16 | Layanan, hubungi kami, Google Maps |
| 17 | Admin users, admin keluhan |
| 18 | Chart visitor, export Excel |
| 19 | Chatbot: FAB, chat window, response SLiMS & Gemini |
| 20 | OPAC, responsive mobile/tablet, route list |
| 21 | File structure, migrate status, halaman final |

---

*Dokumen ini disusun sebagai lampiran bukti implementasi logbook magang.*
*Semua kode diambil langsung dari source code project.*

*Tanggal: 30 Juli 2026*
