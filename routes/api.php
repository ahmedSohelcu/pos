<?php

use App\Http\Controllers\Api\V1\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::prefix('v1')->group(function () {
    Route::get('selectable-statuses/{type?}', [StatusController::class, 'selectableStatuses'])
        ->name('selectable_statuses');
});


Route::get('status/{id}', [StatusController::class, 'show'])
    ->name('show_status_by_id');


