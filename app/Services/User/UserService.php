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
        return $this->model->create($this->userRequests($data));
    }


    private function userRequests($data)
    {
        return [
            'name' => $data['name'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'] ?? null,
            'tenant_id' => $data['tenant_id'] ?? null,
            'status_id' => $data['status_id'] ?? null,
        ];
    }

    public function finduserById($id){
        return $this->model->findOrFail($id);
    }


    public function update(array $data, $id)
    {     
        $this->model =  $this->model->find($id);
        $this->model->update($this->userRequests($data));
        return $this->model;
    }

    
    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();
        return $this->model;
    }
}