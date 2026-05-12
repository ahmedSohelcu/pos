<?php

use Illuminate\Support\Facades\Route;
use Modules\Attribute\app\Http\Controllers\Api\AttributeController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('attributes', AttributeController::class)->names('attribute');
});
