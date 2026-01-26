<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BuyNowController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckOutController;

// Home page / Catalog
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [HomeController::class, 'index'])->name('catalog');

// Product detail page
Route::get('/product/{id}', [HomeController::class, 'show'])->name('product.detail');

// Buy Now functionality
Route::post('/buy-now', [BuyNowController::class, 'buyNow'])->name('buy_now');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.view');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout routes
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckOutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckOutController::class, 'process'])->name('checkout.process');
    Route::get('/payment', [CheckOutController::class, 'payment'])->name('payment');
    Route::get('/checkout/success', [CheckOutController::class, 'success'])->name('checkout.success');
});

Route::get('/check-transaction-status', [BuyNowController::class, 'checkTransactionStatus']);

// Authentication routes
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Additional routes you might need
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Admin Routes
use App\Http\Controllers\Admin\ProductController as AdminProductController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', AdminProductController::class);
});