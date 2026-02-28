<?php

namespace Modules\Tenant\App\Services;

use App\Services\Core\BaseService;
use Modules\Tenant\app\Models\Tenant;

class TenantService extends BaseService
{
    public function __construct(Tenant $tenant)
    {
        $this->model = $tenant;
    }

    public function getAll(
        $isPaginated = true,
        $isSorted = true,
        $relations = ['status'],
        $perPage = 10
    )
    {
        $query =  $this->model
            ->filters(request()->filters ?? []);

             if (!empty($relations)) {
                $query->with($relations);
            }

            if ($isSorted) {
                $query->sort();
            }

            if ($isPaginated) {
                return $query->paginate(request('per_page', 10));
            }

            // 🔹 Pagination
        return $isPaginated
        ? $query->paginate($perPage)->withQueryString()
        : $query->get(); 
    }

    public function create(array $data)
    {
        // dd($data);
        return $this->model->create($this->tenantRequests($data));
    }


    private function tenantRequests($data){
        return [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'status_id' => $data['status_id'],
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