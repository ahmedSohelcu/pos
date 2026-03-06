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
// middleware(['auth:sanctum'])
prefix('v1')->group(function () {
    Route::apiResource('expense-categories', ExpenseCategoryController::class)->names('expense_category');
    Route::get('selectable-expense-categories/{tenant_id}', [ExpenseCategoryController::class, 'selectableExpenseCategories'])
        ->name('selectable_expense_categories');
});