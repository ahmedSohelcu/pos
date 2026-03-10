<?php

use Illuminate\Support\Facades\Route;
use Modules\Role\app\Http\Controllers\Api\RoleController;

Route::middleware(['auth:sanctum', 'check.subscription'])->prefix('v1')->group(function () {
    Route::apiResource('roles', RoleController::class)->names('role');
    Route::get('permissions', [RoleController::class, 'permissions'])->name('permissions');

    Route::get('roles/{role}/permissions', [RoleController::class, 'permissionsByRole'])
        ->name('role.permissions');
        
    Route::post('roles/{role}/permissions', [RoleController::class, 'updatePermissionsByRole'])
        ->name('role.permissions.update');

    Route::get('selectable-roles', [RoleController::class, 'selectableRoles'])
        ->name('selectable_roles');
});
