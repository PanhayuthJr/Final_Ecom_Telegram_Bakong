<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [HomeController::class, 'show'])->name('product.detail');


Route::post('/buy_now', [App\Http\Controllers\BuyNowController::class, 'buyNow'])
    ->name('buy_now');

Route::get('/check-transaction-status', [App\Http\Controllers\BuyNowController::class, 'checkTransactionStatus'])
     ->name('check_transaction_status');

Route::get('/payment-success', [App\Http\Controllers\BuyNowController::class, 'paymentSuccess'])
     ->name('payment_success');