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
        try {
            $tenants = $this->service->getAll(true, true, ['status'], 10);
            return success_response('Tenant List', $tenants);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TenantRequest $request) {
        
        try {
            $this->service->create($request->all());
            return created_responses('Tenant created successfully', []);
        } catch (\Exception $e) {
            return failed_responses('Failed to create tenant', $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        try {
            $tenant = $this->service->findTenantById($id);
            return success_response('Tenant', $tenant->toArray());

        } catch (\Exception $e) {
            return failed_responses('Failed to load tenant', $e->getMessage());
            // return response()->json(['message' => trans('default.failed_response')], 500);        
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('tenant::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TenantRequest $request, $id) 
    {        
        try {
            $tenants = $this->service
                ->update($request->all(), $id);

            return updated_responses('Tenant', $tenants->toArray());
        } catch (\Exception $e) {        
            return response()->json(['message' => trans('default.failed_response')], 500);
            // return failed_responses('Tenant', []);  
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        try {
            $tenant = $this->service->delete($id);
            return deleted_responses('Tenant', $tenant->toArray());
        } catch (\Exception $e) {
            return response()->json(['message' => trans('default.failed_response')], 500);        
            // return failed_responses('Failed to delete tenant', $e->getMessage());
        }   
    }
}
