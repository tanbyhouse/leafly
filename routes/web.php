<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminProductBusukController;
use App\Http\Controllers\AdminTransactionsController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});
Route::get('/katalog', [
    ProductController::class, 'index'
])->name('products.index');
Route::get('/katalog/{id}', [
    ProductController::class, 'show'
])->name('products.show');
Route::get('/keranjang', [
    CartController::class, 'index'
])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [
    CheckoutController::class, 'index'
])->name('checkout.index');
Route::middleware('auth')->group(function () {
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/orders/{id}/success', [CheckoutController::class, 'success'])->name('orders.success');
});
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

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/ajax/provinces', [CheckoutController::class, 'provinces'])
    ->name('ajax.provinces');

Route::get('/ajax/cities/{provinceId}', [CheckoutController::class, 'getCities'])
    ->name('ajax.cities');

Route::post('/ajax/ongkir', [CheckoutController::class, 'ajaxOngkir'])
    ->name('ajax.ongkir');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'App\\Http\\Middleware\\RoleMiddleware:admin'])->group(function () {
    Route::get('/dashboard', [
        DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/laporan', [
        AdminLaporanController::class, 'index'])
        ->name('laporan.index');
    
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

Route::get('/users', [
    AdminUserController::class, 'index'])
    ->name('admin.users.index');
Route::delete('/users/{id}', [
    AdminUserController::class, 'destroy'])
    ->name('admin.users.destroy');