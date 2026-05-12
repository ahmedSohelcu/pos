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

    public function create()
    {
        return $this->model->create($this->subscriptionRequests());
    }

    private function subscriptionRequests(){
        return [
            'tenant_id'     => $this->getAttr('tenant_id') ?? null,
            'plan_id'       => $this->getAttr('plan_id') ?? null,
            'starts_at'     => $this->getAttr('starts_at') ?? null,
            'ends_at'       => $this->getAttr('ends_at') ?? null,
            'status_id'     => $this->getAttr('status_id') ?? null,
            'is_current'    => $this->getAttr('is_current') ?? null,
        ];
    }

    public function update()
    {     
        $this->model->update($this->subscriptionRequests());
        return $this;
    }
}
