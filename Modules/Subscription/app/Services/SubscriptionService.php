<?php

namespace Modules\Subscription\App\Services;

use App\Services\Core\BaseService;
use Modules\Subscription\app\Models\Subscription;

class SubscriptionService extends BaseService
{
    public function __construct(Subscription $subscription)
    {
        $this->model = $subscription;
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
        return $this->model->create($this->subscriptionRequests($data));
    }


    private function subscriptionRequests($data){
        return [
            'tenant_id'     => $data['tenant_id'] ?? null,
            'plan_id'       => $data['plan_id'] ?? null,
            'starts_at'     => $data['starts_at'] ?? null,
            'ends_at'       => $data['ends_at'] ?? null,
            'address'       => $data['address'] ?? null,
            'status_id'     => $data['status_id'] ?? null,
            'is_current'    => $data['is_current'] ?? null,
        ];
    }

    public function findSubscriptionById($id){
        return $this->model->findOrFail($id);
    }


    public function update(array $data, $id)
    {     
        $this->model =  $this->model->find($id);
        $this->model->update($this->subscriptionRequests($data));
        return $this->model;
    }

    
    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();
        return $this->model;
    }
}
