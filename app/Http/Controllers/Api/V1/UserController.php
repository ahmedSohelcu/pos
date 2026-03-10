<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{   

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    public function selectableTenants()
    {
        return $this->service->getSelectableUsers();        
    }

    public function index()
    {
        $users = $this->service->getAll(true, true, ['status', 'tenant', 'roles'], 10);
        return success_response('User List', $users);        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request) 
    {
        $user = $this->service
            ->setAttrs($request->all())
            ->create();

        return created_responses('User', $user);
    }

    /**
     * Show the specified resource.
     */
    public function show(User $user)
    {
        return success_response('User', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user) 
    {        
        $user = $this->service
            ->setModel($user)
            ->setAttrs($request->all())
            ->update();

        return updated_response('User', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user) 
    {
        $user->delete();
        return deleted_responses('User', $user);
    }

    public function getUserRoles(User $user) 
    {
        $roles = $user->roles->pluck('id');
        return success_response('User Roles', $roles);    
    }

    public function updateUserRoles(Request $request, User $user){
        $roleNames = Role::whereIn('id', $request->roles)->pluck('name');
        $data = $user->syncRoles($roleNames);
        return updated_response('User Role', $data);
    }
}
