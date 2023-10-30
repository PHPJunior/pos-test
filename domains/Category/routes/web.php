<?php

use Domain\Category\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::resource('/categories', CategoryController::class)
    ->middleware(['auth', 'verified'])
    ->except(['store', 'update', 'destroy']);
