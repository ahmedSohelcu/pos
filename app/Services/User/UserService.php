<?php

namespace App\Services\User;

use App\Services\Core\BaseService;
use App\Models\User;

class UserService extends BaseService
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getSelectableusers()
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

    public function create()
    {
        return $this->model->create($this->userRequests());
    }


    public function findById($id){
        return $this->model->findOrFail($id);
    }


    private function userRequests()
    {
        return [
            'name'      => $this->getAttr('name') ?? null,
            'email'     => $this->getAttr('email') ?? null,
            'phone'     => $this->getAttr('phone') ?? null,
            'user_type' => $this->getAttr('user_type') ?? null,
            'password'  => $this->getAttr('password') ?? null,
            'tenant_id' => $this->getAttr('tenant_id') ?? null, //should be auto filled
            'status_id' => $this->getAttr('status_id') ?? null,
        ];
    }

    public function update()
    {
        $this->model->update($this->userRequests());
        return $this;
    }
}