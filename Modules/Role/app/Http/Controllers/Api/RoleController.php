<?php

namespace Modules\Role\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Role\app\Http\Requests\RoleRequest;
use Modules\Role\app\Services\RoleService;

class RoleController extends Controller
{
    protected $service;    

    public function __construct(RoleService $roleService)
    {
        $this->service = $roleService;
    }
    public function index()
    {
        try {
            $roles = $this->service->getAll(true, true, [], 10);
            return success_response('Role List', $roles);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request) {
        
        try {
            $this->service->create($request->all());
            return created_responses('Role created successfully', []);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return failed_responses('Failed to create Role', $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        try {
            $Role = $this->service->findRoleById($id);
            return success_response('Role', $Role->toArray());

        } catch (\Exception $e) {
            return failed_responses('Failed to load Role', $e->getMessage());
            // return response()->json(['message' => trans('default.failed_response')], 500);        
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, $id) 
    {        
        try {
            $roles = $this->service
                ->update($request->all(), $id);

            return updated_responses('Role', $roles->toArray());
        } catch (\Exception $e) {        
            return response()->json(['message' => trans('default.failed_response')], 500);
            // return failed_responses('Role', []);  
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        try {
            $role = $this->service->delete($id);
            return deleted_responses('Role', $role->toArray());
        } catch (\Exception $e) {
            return response()->json(['message' => trans('default.failed_response')], 500);        
            // return failed_responses('Failed to delete Role', $e->getMessage());
        }   
    }
}
