<?php

use Illuminate\Support\Facades\Route;
use Modules\Reports\App\Http\Controllers\Api\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes (Reports Module)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->prefix('v1/reports')->name('reports.')->group(function () {
    Route::get('overview', [ReportController::class, 'overview'])->name('overview');
});
