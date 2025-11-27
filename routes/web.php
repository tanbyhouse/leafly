<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

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