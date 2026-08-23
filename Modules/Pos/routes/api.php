<?php

use Illuminate\Support\Facades\Route;
use Modules\Pos\App\Http\Controllers\Api\PosController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::get('pos/products', [PosController::class, 'index'])->name('pos.products');
});
