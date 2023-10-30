<?php

use Domain\Product\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::resource('/products', ProductController::class)
    ->middleware(['auth', 'verified'])
    ->except(['store', 'update', 'destroy']);
