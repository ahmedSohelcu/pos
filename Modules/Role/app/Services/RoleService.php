<?php

namespace Modules\Role\App\Services;
use App\Services\Core\BaseService;
use Modules\Role\app\Models\Role;

// use Spatie\Permission\Models\Role;

class RoleService extends BaseService
{
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    public function getAll(
        $isPaginated = true,
        $isSorted = true,
        $relations = [],
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
        return $this->model->create($this->roleRequests($data));
    }


    private function roleRequests($data){
        return [
            'name' => $data['name'],
            'guard_name' => $data['guard_name'] ?? null,
            'tenant_id' => $data['tenant_id'],
        ];
    }

    public function findRoleById($id){
        return $this->model->findOrFail($id);
    }


    public function update(array $data, $id)
    {     
        $this->model =  $this->model->find($id);
        $this->model->update($this->roleRequests($data));
        return $this->model;
    }

    
    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();
        return $this->model;
    }
}
