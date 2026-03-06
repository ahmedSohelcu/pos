<?php

use Illuminate\Support\Facades\Route;
use Modules\Role\app\Http\Controllers\Api\RoleController;

Route::
// middleware(['auth:sanctumd'])
prefix('v1')->group(function () {
    Route::apiResource('roles', RoleController::class)->names('role');
    Route::get('roles/{role}/permissions', [RoleController::class, 'permissions'])->name('role.permissions');
});
