<?php

use Illuminate\Support\Facades\Route;
use Modules\Tenant\app\Http\Controllers\Api\TenantController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('tenants', TenantController::class)->names('tenant');
});
