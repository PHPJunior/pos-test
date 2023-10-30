<?php

use Domain\Cart\Http\Controllers\CartApiController;
use Illuminate\Support\Facades\Route;

Route::get('/cart', [CartApiController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartApiController::class, 'store'])->name('cart.store');
Route::put('/cart/{product}', [CartApiController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartApiController::class, 'destroy'])->name('cart.destroy');
Route::delete('/cart', [CartApiController::class, 'clear'])->name('cart.clear');
