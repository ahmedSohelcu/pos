<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\app\Http\Controllers\CategoryController;

Route::middleware(['auth:sanctum', 'check.subscription'])->prefix('v1')->group(function () {
    Route::apiResource('categories', CategoryController::class)->names('category');
});
