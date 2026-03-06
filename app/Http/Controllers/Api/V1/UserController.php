<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{   
    // protected $service;    

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
        $users = $this->service->getAll(true, true, [], 10);
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
}
