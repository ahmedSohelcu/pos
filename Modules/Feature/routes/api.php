<?php

use Illuminate\Support\Facades\Route;
use Modules\Feature\app\Http\Controllers\Api\FeatureController;

Route::
// middleware(['auth:sanctum'])->
prefix('v1')->group(function () {
    Route::apiResource('features', FeatureController::class)->names('feature');
});
