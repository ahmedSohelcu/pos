<?php

namespace Modules\Plan\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Plan\app\Services\PlanService;
use Modules\Plan\app\Http\Requests\PlanRequest;

class PlanController extends Controller
{   
    protected $service;    

    public function __construct(PlanService $planService)
    {
        $this->service = $planService;
    }
    public function index()
    {
        $tenants = $this->service->getAll(true, true, ['status'], 10);
        return success_response('Tenant List', $tenants);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanRequest $request) {        
        $this->service->create($request->all());
        return created_responses('Tenant created successfully', []);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $tenant = $this->service->findTenantById($id);
        return success_response('Tenant', $tenant);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanRequest $request, $id) 
    {        
        $tenants = $this->service->update($request->all(), $id);
        return updated_response('Tenant', $tenants);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $tenant = $this->service->delete($id);
        return deleted_responses('Tenant', $tenant);
    }
}
