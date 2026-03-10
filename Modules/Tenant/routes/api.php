<?php

use Illuminate\Support\Facades\Route;
use Modules\Tenant\app\Http\Controllers\Api\TenantController;

Route::middleware(['auth:sanctum','check.subscription'])->prefix('v1')->group(function () {
    Route::apiResource('tenants', TenantController::class)->names('tenant');

    Route::get('selectable-tenants', [TenantController::class, 'selectableTenants'])
        ->name('selectable_tenants');
});

