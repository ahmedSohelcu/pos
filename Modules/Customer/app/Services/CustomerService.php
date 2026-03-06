<?php

namespace Modules\Customer\App\Services;

use App\Models\User;
use App\Services\Core\BaseService;
use App\Services\User\UserService;
use Modules\Customer\app\Models\Customer;

class CustomerService extends BaseService
{
    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }

    public function getSelectablecustomers()
    {
        return $this->model::query()
            ->select('id', 'name')
            ->get();  
    }

    public function getAll(
        bool $isPaginated = true,
        bool $isSorted = true,
        array $relations = ['status', 'customer', 'tenant'],
        int $perPage = 10
    ) {
        $query = $this->model
            ->filters(request()->filters ?? []);

        // Relations
        if (!empty($relations)) {
            $query->with($relations);
        }

        // Sorting
        if ($isSorted) {
            $query->sort();
        }

        // Pagination or Get
        if ($isPaginated) {
            return $query
                ->paginate(request('per_page', $perPage))
                ->withQueryString();
        }

        return $query->get();
    }


    public function createCustomer()
    {
        $this->model->create($this->customerRequests());
        return $this;
    }


    public function createUser()
    { 
        $user = User::query()->create($this->userRequests());
        $this->setAttr('user_id', $user->id);
        return $this;
    }


    private function customerRequests(){
        return [
            'user_id'   => $this->getAttr('user_id') ?? null,
            'status_id' => $this->getAttr('status_id') ?? null,
        ];
    }


    private function userRequests(){
        return [
            'name'      => $this->getAttr('name') ?? null,
            'email'     => $this->getAttr('email') ?? null,
            'phone'     => $this->getAttr('phone') ?? null,
            'tenant_id' => $this->getAttr('tenant_id') ?? null,
            'status_id' => $this->getAttr('status_id') ?? null,
            'user_type' => 'tenant_customer',
        ];
        
    }

    public function findTenantById($id){
        return $this->model->findOrFail($id);
    }


    public function update(array $data, $id)
    {     
        $this->model =  $this->model->find($id);
        $this->model->update($this->tenantRequests($data));
        return $this->model;
    }

    
    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();
        return $this->model;
    }
}
