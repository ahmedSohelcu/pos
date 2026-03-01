<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{   
    protected $service;    

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
        try {
            $users = $this->service->getAll(true, true, [], 10);

            return success_response('User List', $users);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request) {
        
        try {
            $this->service->create($request->all());
            return created_responses('User', []);
        } catch (\Exception $e) {
            dd($e->getMessage());
            // return failed_responses('Failed to create user', $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        try {
            $User = $this->service->findUserById($id);
            return success_response('User', $User->toArray());

        } catch (\Exception $e) {
            return failed_responses('Failed to load user', $e->getMessage());
            // return response()->json(['message' => trans('default.failed_response')], 500);        
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('User::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id) 
    {        
        try {
            $user = $this->service
                ->update($request->all(), $id);

            return updated_responses('User', $user->toArray());
        } catch (\Exception $e) {     
            dd($e->getMessage());   
            return response()->json(['message' => trans('default.failed_response')], 500);
            // return failed_responses('User', []);  
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        try {
            $User = $this->service->delete($id);
            return deleted_responses('User', $User->toArray());
        } catch (\Exception $e) {
            return response()->json(['message' => trans('default.failed_response')], 500);        
            // return failed_responses('Failed to delete User', $e->getMessage());
        }   
    }
}
