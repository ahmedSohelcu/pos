<?php

namespace Modules\Category\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Category\app\Http\Requests\CategoryRequest;
use Modules\Category\app\Services\CategoryService;

class CategoryController extends Controller
{   
    protected $service;    

    public function __construct(CategoryService $categoryService)
    {
        $this->service = $categoryService;
    }
    public function index()
    {
        $categories = $this->service->getAll(true, true, ['tenant'], 10);
        return success_response('Category List', $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request) 
    {        
        $this->service->create($request->all());
        return created_responses('Category created successfully', []);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $Category = $this->service->findCategoryById($id);
        return success_response('Category', $Category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, $id) 
    {        
        $brands = $this->service->update($request->all(), $id);
        return updated_response('Category', $brands);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $category = $this->service->delete($id);
        return deleted_responses('Category', $category);
    }
}