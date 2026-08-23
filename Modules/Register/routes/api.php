<?php

use Illuminate\Support\Facades\Route;
use Modules\Register\App\Http\Controllers\Api\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes (Register / Cash Drawer Module)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->prefix('v1/register')->name('register.')->group(function () {
    Route::get('current', [RegisterController::class, 'current'])->name('current');
    Route::post('open', [RegisterController::class, 'open'])->name('open');
    Route::post('close', [RegisterController::class, 'close'])->name('close');
    Route::post('movements', [RegisterController::class, 'movements'])->name('movements');
    Route::get('history', [RegisterController::class, 'history'])->name('history');
});
