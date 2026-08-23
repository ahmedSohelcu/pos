<?php

use Illuminate\Support\Facades\Route;
use Modules\Inventory\App\Http\Controllers\Api\InventoryController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::get('inventory/movements', [InventoryController::class, 'movements'])->name('inventory.movements');
    Route::get('inventory/low-stock', [InventoryController::class, 'lowStock'])->name('inventory.low_stock');
    Route::get('inventory/stats', [InventoryController::class, 'stats'])->name('inventory.stats');
    Route::post('inventory/adjustments', [InventoryController::class, 'adjust'])->name('inventory.adjust');
});
