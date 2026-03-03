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

    public function create()
    {
        return $this->model
            ->create($this->roleRequests());
    }


    private function roleRequests(){
        return [
            'name' => $this->getAttr('name') ?? null,
            'guard_name' => $this->getAttr('guard_name') ?? null,
            'tenant_id' => $this->getAttr('tenant_id') ?? null,                   
        ];
    }

    public function update()
    {     
        $this->model = $this->model->update($this->roleRequests());
        return $this;
    }
}
