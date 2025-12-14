<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminProductBusukController;
use App\Http\Controllers\AdminTransactionsController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');
Route::get('/katalog', [
    ProductController::class, 'index'
])->name('products.index');
Route::get('/katalog/{id}', [
    ProductController::class, 'show'
])->name('products.show');
Route::get('/keranjang', [
    CartController::class, 'index'
])->name('cart.index');
Route::get('/checkout', [
    CheckoutController::class, 'index'
])->name('checkout.index');
Route::get('/pesanan', [
    OrderController::class, 'index'
])->name('orders.index');
Route::get('/pesanan/{id}', [
    OrderController::class, 'show'
])->name('orders.show');
Route::post('/profile/avatar', [
    ProfileController::class, 'updateAvatar'
])->name('profile.avatar');
Route::get('/profil', [
    ProfileController::class, 'index'
])->name('profile.index');

Route::prefix('admin')->name('admin.')
->group(function () {
    Route::get('/dashboard', [
        DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/laporan', [
        AdminLaporanController::class, 'index'])
        ->name('laporan.index');
        
    Route::get('/users', [
        UserController::class, 'index'])
        ->name('admin.users.index');
    Route::delete('/users/{id}', [
        UserController::class, 'destroy'])
        ->name('admin.users.destroy');
    });
Route::resource('products', 
    AdminProductController::class, [
    'names' => 'admin.products'
]);
Route::resource('busuk', 
    AdminProductBusukController::class, [
    'names' => 'admin.busuk'
]);
Route::resource('transactions', 
    AdminTransactionsController::class, ['names' => 'admin.transactions'])
    ->only(['index', 'show', 'update']); 
Route::post('/reviews', [
    ReviewController::class, 'store'])
    ->name('reviews.store')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [
        ProfileController::class, 'index'])
        ->name('profile.index');
    Route::put('/profile', [
        ProfileController::class, 'update'])
        ->name('profile.update');
});

use App\Models\User;

// --- ROUTE DARURAT (HAPUS NANTI SETELAH MERGE) ---
Route::get('/force-login', function () {
    // Kita ambil user ID 1 (atau user manapun yang ada di database kamu)
    $user = User::first(); 
    
    if (!$user) {
        return "Error: Belum ada data user di database. Jalankan seeder dulu!";
    }

    // Perintah sakti untuk login tanpa password
    Auth::login($user);

    // Redirect langsung ke halaman profil
    return redirect()->route('profile.index')->with('success', 'Login Paksa Berhasil! Sekarang silakan edit profil.');
});