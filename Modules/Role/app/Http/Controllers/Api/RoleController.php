<?php

namespace Modules\Role\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Role\app\Http\Requests\RoleRequest;
use Modules\Role\app\Models\Role;
use Modules\Role\app\Services\RoleService;
use Spatie\Permission\Models\Role as ModelsRole;

class RoleController extends Controller
{
    public function __construct(RoleService $roleService)
    {
        $this->service = $roleService;
    }
    public function index()
    {
        $roles = $this->service->getAll(true, true, [], 10);
        return success_response('Role List', $roles);
    }

    public function permissions() 
    {
        $permissions = $this->service
            ->getPermissions();

        return success_response('Permissions', $permissions);
    }

    public function updatePermissionsByRole(Request $request, ModelsRole $role) 
    {   // Sync permissions
        $role->syncPermissions($request->permissions);
        $permissionIds = $role->permissions->pluck('id')->toArray();
        return updated_response('Permissions', $permissionIds);
    }

    public function permissionsByRole(ModelsRole $role) 
    {
        $permissions = $this->service
            ->setModel($role)
            ->getPermissionsByRole($role->id);

        $permissions = $permissions->pluck('id')->toArray();

        return success_response('Permissions by Role', $permissions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request) {
        
        $role = $this->service
            ->setAttrs($request->all())
            ->create();
        return created_responses('Role created successfully', $role);
    }

    /**
     * Show the specified resource.
     */
    public function show(Role $role)
    {
        return success_response('Role', $role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role) 
    {        
        $role = $this->service
                ->setModel($role)
                ->setAttributes($request->all())
                ->update();

        return updated_response('Role', $role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role) {
        $role->delete();
        return deleted_responses('Role', $role);   
    }
}
