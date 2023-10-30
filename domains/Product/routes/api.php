<?php

use Domain\Product\Http\Controllers\ProductApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductApiController::class);
