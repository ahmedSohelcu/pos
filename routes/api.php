<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function () {
    Route::get('selectable-statuses/{type?}', [StatusController::class, 'selectableStatuses'])
        ->name('selectable_statuses');
});


Route::get('status/{id}', [StatusController::class, 'show'])
    ->name('show_status_by_id');


// User Crud
Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('users', UserController::class)->names('api.users');
    Route::get('selectable-users', [UserController::class, 'selectableUsers'])
        ->name('api.selectable-users');
});


// user Login and logout
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout')->middleware('auth:sanctum');


//----------------------------------------------
// logged in user data
//----------------------------------------------
Route::middleware(['auth:sanctum', 'check.subscription'])->prefix('v1')->group(function () {
    
    //---------------------------------------------
    // ** logged user data ** 
    //---------------------------------------------
    Route::get('/me', function (Request $request) {
        $user = $request->user();
        $subscription = $request->attributes->get('subscription'); 

        return response()->json([
            'user' => $user,
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'subscription' => $subscription,
            'features' => $subscription ? $subscription->plan->features()->where('is_active', true)->pluck('name') : []
        ]);
    })->name('api.me');
    
    //Get user roles
    //-----------------------
    Route::get('/users/{user}/roles', [UserController::class, 'getUserRoles'])->name('api.users.roles');

    // reassign user roles
    //-----------------------
    Route::patch('/users/{user}/roles', [UserController::class, 'updateUserRoles'])->name('api.users.update-roles');  
});

// Route::middleware(['auth:sanctum', 'check.subscription'])->prefix('v1')->group(function () {
    
// });



