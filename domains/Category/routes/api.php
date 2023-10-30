<?php

use Domain\Category\Http\Controllers\CategoryApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('categories', CategoryApiController::class);
