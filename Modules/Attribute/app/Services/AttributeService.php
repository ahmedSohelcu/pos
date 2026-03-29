<?php

namespace Modules\Attribute\App\Services;

use App\Services\Core\BaseService;
use Modules\Attribute\app\Models\Attribute;

class AttributeService extends BaseService
{
    public function __construct(Attribute $attribute)
    {
        $this->model = $attribute;
    } 

    public function getAll(
        bool $isPaginated = true,
        bool $isSorted = true,
        array $relations = ['status', 'tenant'],
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

    public function store()
    {
        return $this->model->create($this->attributeRequests());
    }


    private function attributeRequests(){
        return [
            'name'          => $this->getAttr('name') ?? null,
            'slug'          => $this->getAttr('slug') ?? null,
            'tenant_id'     => $this->getAttr('tenant_id') ?? null, //should be auto filled
            'status_id'     => $this->getAttr('status_id') ?? null,
            'description'   => $this->getAttr('description') ?? null,
            'sorting_order' => $this->getAttr('sorting_order') ?? null,
        ];
    }

    public function update()
    {
        $this->model->update($this->attributeRequests());
        return $this;
    }

}
