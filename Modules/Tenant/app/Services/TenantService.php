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

    public function getSelectableTenants()
    {
        return $this->model::query()
            ->select('id', 'name')
            ->get();  
    }

    public function getAll(
        bool $isPaginated = true,
        bool $isSorted = true,
        array $relations = ['status'],
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