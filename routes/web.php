<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

Route::get('/', fn() => view('welcome'))->name('home');

Route::get('/katalog', [ProductController::class, 'index'])->name('products.index');
Route::get('/katalog/{id}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/* CART */
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');

/* CHECKOUT */
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/orders/{id}/success', [CheckoutController::class, 'success'])->name('orders.success');
});

// // RajaOngkir AJAX
// Route::get('/ajax/provinces', [CheckoutController::class, 'provinces'])
//     ->name('ajax.provinces');
// Route::get('/ajax/cities/{provinceId}', [CheckoutController::class, 'getCities']);
// Route::post('/ajax/ongkir', [CheckoutController::class, 'ajaxOngkir'])->name('ajax.ongkir');

Route::get('/ajax/provinces', [CheckoutController::class, 'provinces'])
    ->name('ajax.provinces');

Route::get('/ajax/cities/{provinceId}', [CheckoutController::class, 'getCities'])
    ->name('ajax.cities');

Route::post('/ajax/ongkir', [CheckoutController::class, 'ajaxOngkir'])
    ->name('ajax.ongkir');


/* USER */
Route::middleware('auth')->group(function () {
    Route::get('/profile', fn() => view('profile.index'))->name('profile.index');
    Route::get('/orders', fn() => view('orders.index'))->name('orders.index');
});

/* ADMIN */
Route::middleware(['auth', 'role:admin,karyawan'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard');
});
