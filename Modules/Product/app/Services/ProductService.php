<?php

namespace Modules\Product\App\Services;

use App\Services\Core\BaseService;
use Modules\Product\app\Models\Product;

class ProductService extends BaseService
{
    public function __construct(Product $product)
    {
        $this->model = $product;
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

    public function productStore()
    {
        return $this->model->create($this->productRequests());
    }


    private function productRequests(){
        return [
            'name'          => $this->getAttr('name') ?? null,
            'slug'          => $this->getAttr('slug') ?? null,
            'tenant_id'     => $this->getAttr('tenant_id') ?? null, //should be auto filled
            'status_id'     => $this->getAttr('status_id') ?? null,
            'description'   => $this->getAttr('description') ?? null,
            'sorting_order' => $this->getAttr('sorting_order') ?? null,
        ];
    }

    public function productUpdate()
    {
        $this->model->update($this->productRequests());
        return $this;
    }

    function generateCombinations($arrays)
    {
        $result = [[]];

        foreach ($arrays as $property => $values) {
            $tmp = [];

            foreach ($result as $resultItem) {
                foreach ($values as $value) {
                    $tmp[] = array_merge($resultItem, [$property => $value]);
                }
            }

            $result = $tmp;
        }

        return $result;

        // $variants = generateCombinations([
        //     'size' => ['S','M','L'],
        //     'color' => ['Red','Blue']
        // ]);

        // dd($variants);

    }

}

