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
    // route manajemen transaksi
    
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