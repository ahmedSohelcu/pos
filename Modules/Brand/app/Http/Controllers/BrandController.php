<?php

namespace Modules\Brand\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('brand::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('brand::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('brand::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('brand::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}


// Schema::create('brands', function (Blueprint $table) {
//     $table->id();
//     $table->string('name')->unique(); // Brand name
//     $table->string('slug')->unique()->nullable(); // Optional slug
//     $table->text('description')->nullable(); // Optional description

//     // unsignedInteger will never be negative and also helps to prevent SQL injection attacks
//     $table->unsignedInteger('sort_order')->default(0); // sorting order

//     // $table->unsignedBigInteger('status_id')->default(1); // active/inactive etc
//     // $table->unsignedBigInteger('tenant_id')->nullable(); // for multi-tenan

//     $table->timestamps();
// });