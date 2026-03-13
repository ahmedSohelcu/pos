<?php

use Illuminate\Support\Facades\Route;
use Modules\Expense\app\Http\Controllers\Api\ExpenseCategoryController;
use Modules\Expense\app\Http\Controllers\Api\ExpenseController;

Route::
// middleware(['auth:sanctum'])
prefix('v1')->group(function () {
    Route::apiResource('expenses', ExpenseController::class)->names('expense');
});

Route::
middleware(['auth:sanctum'])
->prefix('v1')->group(function () {
    Route::apiResource('expense-categories', ExpenseCategoryController::class)->names('expense_category');
    
    //auto filter by tenant_id
    Route::get('selectable-expense-categories', [ExpenseCategoryController::class, 'selectableExpenseCategories'])
        ->name('selectable_expense_categories');
});