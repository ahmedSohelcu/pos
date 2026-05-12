<?php

namespace Modules\Brand\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Brand\app\Http\Requests\BrandRequest;
use Modules\Brand\app\Services\BrandService;

class BrandController extends Controller
{   
    protected $service;    

    public function __construct(BrandService $brandService)
    {
        $this->service = $brandService;
    }
    public function index()
    {
        $units = $this->service->getAll(true, true, ['status', 'tenant'], 10);
        return success_response('Brand List', $units);
    }

    public function selectable()
    {
        return $this->service->getSelectableBrands();        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request) {        
        $this->service->create($request->all());
        return created_responses('Brand created successfully', []);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $brand = $this->service->findBrandById($id);
        return success_response('Brand', $brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, $id) 
    {        
        $brands = $this->service->update($request->all(), $id);
        return updated_response('Brand', $brands);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $brand = $this->service->delete($id);
        return deleted_responses('Brand', $brand);
    }
}