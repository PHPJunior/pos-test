<?php

use Domain\Category\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');

    Route::get('/create', [CategoryController::class, 'create'])
        ->name('create')
        ->middleware('can:manage categories');

    Route::get('/{category}', [CategoryController::class, 'show'])->name('show');

    Route::get('/{category}/edit', [CategoryController::class, 'edit'])
        ->name('edit')
        ->middleware('can:manage categories');
})->middleware(['auth', 'verified']);
