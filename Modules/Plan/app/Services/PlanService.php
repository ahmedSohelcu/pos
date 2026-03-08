<?php

namespace Modules\Plan\App\Services;

use App\Services\Core\BaseService;
use Modules\Feature\app\Models\Feature;
use Modules\Plan\app\Models\Plan;

class PlanService extends BaseService
{
    public function __construct(Plan $plan)
    {
        $this->model = $plan;
    }

    public function getSelectablePlans(){
        return $this->model->select('id', 'name')->get();
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
        // dd($this->planRequests());
        return $this->model
            ->create($this->planRequests());
    }


    private function planRequests(){
        return [
            'name'              => $this->getAttr('name') ?? null,
            'slug'              => $this->getAttr('slug') ?? null,
            'price'             => $this->getAttr('price') ?? null,
            'currency'          => $this->getAttr('currency') ?? null,
            'billing_interval'  => $this->getAttr('billing_interval') ?? null,
            'billing_duration'  => $this->getAttr('billing_duration') ?? null,
            'trial_days'        => $this->getAttr('trial_days') ?? null,
            'max_users'         => $this->getAttr('max_users') ?? null,
            'max_products'      => $this->getAttr('max_products') ?? null,
            'max_branches'      => $this->getAttr('max_branches') ?? null,
            'is_active'         => $this->getAttr('is_active') ?? null,
            'description'       => $this->getAttr('description') ?? null,
            'sorting_order'     => $this->getAttr('sorting_order') ?? null,
        ];
    }

    public function findPlanById($id){
        return $this->model->findOrFail($id);
    }


    public function update()
    {   
        $this->model = $this->model->update($this->planRequests());
        return $this;
    }

    
    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();
        return $this->model;
    }



    // Features

    public function getFeatures(){
        // 1️⃣ Get all features of the role
        $features = Feature::all();
        
        // 2️⃣ Transform to include module and action
        $featuresMapped = $features->map(function($perm){
            // Example: 'user.create' => ['module'=>'User', 'action'=>'create']
            $parts = explode('.', $perm->name);
            return [
                'id' => $perm->id,
                'name' => $perm->name,
                'module' => ucfirst($parts[0]),
                'action' => $parts[1] ?? null,
            ];
        });

        // 3️⃣ Group by module
        $grouped = $featuresMapped->groupBy('module')
            ->map(function($items, $module){
                return [
                    'module' => $module,
                    'features' => $items->map(fn($p)=>[
                        'id' => $p['id'],
                        'name' => $p['name'],
                    ])->values()
                ];
            })
            ->sortBy(fn($group) => $group['module'])
            ->values(); // ->values() to reset array keys
        

        return $grouped;
    }

    public function getfeaturesByPlan(){
        return $this->model->features;
    }
}

