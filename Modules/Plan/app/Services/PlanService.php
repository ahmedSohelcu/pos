<?php

namespace Modules\Plan\App\Services;

use App\Services\Core\BaseService;
use Modules\Plan\app\Models\Plan;

class PlanService extends BaseService
{
    public function __construct(Plan $plan)
    {
        $this->model = $plan;
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
        return $this->model->create($this->planRequests($data));
    }


    private function planRequests($data){
        return [
            'name'              => $data['name'],
            'slug'              => $data['slug'],
            'price'             => $data['price'],
            'currency'          => $data['currency'],
            'billing_interval'  => $data['billing_interval'],
            'billing_duration'  => $data['billing_duration'],
            'trial_days'        => $data['trial_days'],
            'max_users'         => $data['max_users'],
            'max_products'      => $data['max_products'],
            'max_branches'      => $data['max_branches'],
            'is_active'         => $data['is_active'],
            'description'       => $data['description'],
            'sorting_order'     => $data['sorting_order'],
        ];
    }

    public function findPlanById($id){
        return $this->model->findOrFail($id);
    }


    public function update(array $data, $id)
    {     
        $this->model =  $this->model->find($id);
        $this->model->update($this->planRequests($data));
        return $this->model;
    }

    
    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();
        return $this->model;
    }
}

