<?php

use App\Http\Controllers\admin\v1\DashboardCotroller;
use Illuminate\Support\Facades\Route;

// Route::get('/te', [DashboardCotroller::class, 'dashboard'])->name('dashboard');

Route::get('/{vue_capture?}', function () {   
    return view('admin.v1.layouts.master');
})->where('vue_capture', '[\/\w\.-]*');
