<?php

use Illuminate\Support\Facades\Route;
use Modules\Sales\App\Http\Controllers\Api\SaleController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::get('sales/stats', [SaleController::class, 'stats'])->name('sales.stats');
    Route::post('sales/{sale}/refund', [SaleController::class, 'refund'])->name('sales.refund');
    Route::apiResource('sales', SaleController::class)->names('sales');
});
