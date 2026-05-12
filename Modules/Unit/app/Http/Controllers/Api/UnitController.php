<?php

namespace Modules\Unit\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Unit\app\Http\Requests\UnitRequest;
use Modules\Unit\app\Services\UnitService;

class UnitController extends Controller
{   
    protected $service;    

    public function __construct(UnitService $unitService)
    {
        $this->service = $unitService;
    }
    public function index()
    {
        $units = $this->service->getAll(true, true, ['status', 'tenant'], 10);
        return success_response('Unit List', $units);
    }

    public function selectable()
    {
        return $this->service->getSelectableUnits();        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitRequest $request) {        
        $this->service->create($request->all());
        return created_responses('Unit created successfully', []);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $tenant = $this->service->findUnitById($id);
        return success_response('Unit', $tenant);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitRequest $request, $id) 
    {        
        $tenants = $this->service->update($request->all(), $id);
        return updated_response('Unit', $tenants);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $tenant = $this->service->delete($id);
        return deleted_responses('Unit', $tenant);
    }
}
