<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\BorrowingController as AdminBorrowingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CatalogController;

// Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Berita
Route::get('/berita', [HomeController::class, 'news'])->name('news.index');
Route::get('/news/{id}', [HomeController::class, 'showNews'])->name('news.show');

// Halaman Profil
Route::get('/profile', function () {
    return view('profile.index', [
        'title' => 'Profile - Perpustakaan PPIC'
    ]);
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

// Halaman Hubungi Kami
Route::get('/hubungikami', [ContactController::class, 'index'])->name('contact.index');
Route::post('/hubungikami', [ContactController::class, 'submit'])->name('contact.submit');

// Halaman Galeri (menggantikan layanan)
Route::get('/galeri0', function () {
    return view('layanan.index', [
        'title' => 'Galeri - Perpustakaan PPIC'
    ]);
})->name('gallery');

// Redirect legacy layanan URL
Route::redirect('/layanan', '/galeri0', 301);

// Halaman OPAC
Route::get('/opac', function () {
    return view('opac.index', [
        'title' => 'OPAC - Perpustakaan PPIC'
    ]);
})->name('opac');

// Halaman Detail OPAC
Route::get('/opac/detail/{id}', function ($id) {
    return view('opac.detail', [
        'title' => 'Detail Koleksi - Perpustakaan PPIC',
        'id' => $id
    ]);
})->name('opac.detail');

// === KATALOG BUKU (public + auth) ===
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/katalog/{book}', [CatalogController::class, 'show'])->name('catalog.show');

// Route yang butuh login
Route::middleware('auth')->group(function () {
    Route::post('/katalog/{book}/pinjam', [CatalogController::class, 'requestBorrow'])->name('catalog.borrow');
    Route::get('/peminjaman-saya', [CatalogController::class, 'myBorrowings'])->name('catalog.my-borrowings');
    Route::delete('/peminjaman/{borrowing}/batal', [CatalogController::class, 'cancelRequest'])->name('catalog.cancel');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:super-admin|admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/visitors/export', [DashboardController::class, 'exportVisitorsYear'])->name('dashboard.visitors.export');

    // Books Management
    Route::resource('books', AdminBookController::class);

    // News Management
    Route::resource('news', AdminNewsController::class);
    Route::post('news/{news}/publish', [AdminNewsController::class, 'publish'])->name('news.publish');

    // Users Management
    Route::resource('users', AdminUserController::class)->except(['show']);

    // Complaints Management
    Route::resource('complaints', AdminComplaintController::class)->only(['index', 'show', 'update']);

    // Borrowings Management (admin approval)
    Route::get('/peminjaman', [AdminBorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('/peminjaman/{borrowing}', [AdminBorrowingController::class, 'show'])->name('borrowings.show');
    Route::post('/peminjaman/{borrowing}/approve', [AdminBorrowingController::class, 'approve'])->name('borrowings.approve');
    Route::post('/peminjaman/{borrowing}/reject', [AdminBorrowingController::class, 'reject'])->name('borrowings.reject');
    Route::post('/peminjaman/{borrowing}/return', [AdminBorrowingController::class, 'returnBook'])->name('borrowings.return');
});