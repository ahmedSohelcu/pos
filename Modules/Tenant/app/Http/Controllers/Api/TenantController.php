<?php

namespace Modules\Tenant\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Tenant\app\Services\TenantService;
use Modules\Tenant\app\Http\Requests\Tenant\TenantRequest;

class TenantController extends Controller
{   
    protected $service;    

    public function __construct(TenantService $tenantService)
    {
        $this->service = $tenantService;
    }
    public function index()
    {
        $tenants = $this->service->getAll(true, true, ['status'], 10);
        return success_response('Tenant List', $tenants);
    }

    public function selectableTenants()
    {
        return $this->service->getSelectableTenants();        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TenantRequest $request) {      
        $this->service
        ->create($request->all())
        // ->createWalkinCustomer()
        ;
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
    public function update(TenantRequest $request, $id) 
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
