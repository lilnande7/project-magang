<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;

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

// Halaman Hubungi Kami
Route::get('/hubungikami', function () {
    return view('hubungikami.index', [
        'title' => 'Hubungi Kami - Perpustakaan PPIC'
    ]);
})->name('contact');

// Halaman Layanan
Route::get('/layanan', function () {
    return view('layanan.index', [
        'title' => 'Layanan - Perpustakaan PPIC'
    ]);
})->name('services');

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
    
    // Books Management
    Route::resource('books', AdminBookController::class);
    
    // News Management
    Route::resource('news', AdminNewsController::class);
    Route::post('news/{news}/publish', [AdminNewsController::class, 'publish'])->name('news.publish');
    
});