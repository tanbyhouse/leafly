<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
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
Route::get('/profil', [
    ProfileController::class, 'index'
])->name('profile.index');