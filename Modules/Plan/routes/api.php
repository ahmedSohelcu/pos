<?php

use Illuminate\Support\Facades\Route;
use Modules\Plan\app\Http\Controllers\Api\PlanController;

Route::
// middleware(['auth:sanctum'])->
prefix('v1')->group(function () {
    Route::apiResource('plans', PlanController::class)->names('plan');

    Route::get('selectable-plans', [PlanController::class, 'selectablePlans'])
        ->name('selectable_plans');
});
