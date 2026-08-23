<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\app\Http\Controllers\Api\ProductController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('products', ProductController::class)->names('product');

    Route::delete('products/{product}/thumbnail', [ProductController::class, 'destroyThumbnail'])
        ->name('product.thumbnail.destroy');

    Route::delete('products/{product}/galleries', [ProductController::class, 'destroyGallery'])
        ->name('product.gallery.destroy');
});
