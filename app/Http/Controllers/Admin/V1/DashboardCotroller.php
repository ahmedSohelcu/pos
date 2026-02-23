<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardCotroller extends Controller
{
    public function dashboard()
    {
        return view('admin.v1.layouts.master');
    }
}


        // No try/catch needed anymore:
        // public function store(Request $request)        // {
        //     $customer = Customer::create($request->validated());
        //     return created_response('Customer', [
        //         'data' => $customer
        //     ]);
        // }


// <?php

// namespace App\Http\Controllers;

// use App\Models\Customer;
// use Illuminate\Http\Request;

// class CustomerController extends Controller
// {

// use Illuminate\Support\Facades\DB;
// use App\Helpers\Core\General\ResponseHelper;

        // DB Transatio Example
        // public function storeUserWithProfile(Request $request)
        // {
        //     try {
        //         $result = DB::transaction(function () use ($request) {

        //             // 1. Create User
        //             $user = User::create($request->only(['name', 'email', 'password']));

        //             // 2. Create Profile linked to User
        //             $profile = $user->profile()->create($request->only(['phone', 'address']));

        //             // 3. Assign Role
        //             $user->assignRole('Customer');

        //             // return all created data
        //             return [
        //                 'user' => $user,
        //                 'profile' => $profile
        //             ];
        //         });

        //         // Transaction succeeded → return professional response
        //         return created_response('User', ['data' => $result]);

        //     } catch (\Exception $e) {
        //         // Transaction failed → rollback automatically
        //         return failed_response([
        //             'errors' => ['exception' => $e->getMessage()]
        //         ]);
        //     }
        // }


//     public function store(Request $request)
//     {
//         try {
//             $customer = Customer::create($request->all());

//             return created_response('Customer', ['data' => $customer]);

//         } catch (\Exception $e) {
//             return failed_response(['errors' => ['exception' => $e->getMessage()]]);
//         }
//     }

//     public function update(Request $request, Customer $customer)
//     {
//         try {
//             $customer->update($request->all());

//             return updated_response('Customer', ['data' => $customer]);

//         } catch (\Exception $e) {
//             return failed_response(['errors' => ['exception' => $e->getMessage()]]);
//         }
//     }

//     public function destroy(Customer $customer)
//     {
//         try {
//             $customer->delete();

//             return deleted_response('Customer');

//         } catch (\Exception $e) {
//             return failed_response(['errors' => ['exception' => $e->getMessage()]]);
//         }
//     }
// }