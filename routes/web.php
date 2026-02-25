<?php

use Illuminate\Support\Facades\Route;

// Route::get('/{vue_capture?}', function () {   
//     return view('admin.v1.layouts.master');
// })->where('vue_capture', '[\/\w\.-]*');


Route::get('/{any}', function () {
    return view('admin.v1.layouts.master');
})->where('any', '^(?!api).*$'); // ignore /api routes
