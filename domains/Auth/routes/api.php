<?php

use Domain\Auth\Http\Controllers\AuthApiController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthApiController::class, 'login'])
    ->middleware('guest')
    ->name('login');
