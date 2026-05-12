<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\app\Http\Controllers\Api\CustomerController;

Route::
// middleware(['auth:sanctum'])
prefix('v1')->group(function () {
    Route::apiResource('customers', CustomerController::class)->names('customer');

    Route::get('selectable-customers', [CustomerController::class, 'selectableCustomers'])
        ->name('selectable_customers');
});
