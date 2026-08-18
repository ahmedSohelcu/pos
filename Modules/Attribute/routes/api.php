<?php

use Illuminate\Support\Facades\Route;
use Modules\Attribute\app\Http\Controllers\Api\AttributeController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('attributes', AttributeController::class)->names('attribute');

    Route::get('selectable-attributes', [AttributeController::class, 'selectable'])
        ->name('selectable_attributes');


    Route::get('attributes-values/{attribute_id}', [AttributeController::class, 'attributeValuesByAttributeId'])
        ->name('selectable_attribute_values');
});
