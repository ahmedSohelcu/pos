<?php

namespace Modules\Customer\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Customer\app\Services\CustomerService;
use Modules\Customer\app\Http\Requests\CustomerRequest;
use Modules\Customer\App\Models\Customer;

class CustomerController extends Controller
{   
    public function __construct(CustomerService $customerService)
    {
        $this->service = $customerService;
    }
    public function index()
    {
        $tenants = $this->service->getAll(true, true, ['status', 'user.tenant'], 10);
        return success_response('Customer List', $tenants);
    }

    public function selectableCustomers()
    {
        return $this->service->getSelectableCustomers();        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request) {    
        DB::transaction(function () use ($request) {
            $this->service
                ->setAttrs($request->all())
                ->createUser()
                ->createCustomer();
        });

        return created_responses('Customer created successfully', []);
    }

    /**
     * Show the specified resource.
     */
    public function show(Customer $customer)
    {
        return success_response('Customer', $customer->load('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, $id) 
    {        
        $tenants = $this->service->update($request->all(), $id);
        return updated_response('Customer', $tenants);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $tenant = $this->service->delete($id);
        return deleted_responses('Customer', $tenant);
    }
}
