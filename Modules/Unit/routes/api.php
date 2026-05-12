<?php

use Illuminate\Support\Facades\Route;
use Modules\Unit\app\Http\Controllers\Api\UnitController;

Route::middleware(['auth:sanctum', 'check.subscription'])->prefix('v1')->group(function () {
    Route::apiResource('units', UnitController::class)->names('unit');

    Route::get('selectable-units', [UnitController::class, 'selectable'])
        ->name('selectable_units');
});
