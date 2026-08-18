<?php

namespace Modules\Attribute\App\Services;

use App\Services\Core\BaseService;
use Modules\Attribute\app\Models\Attribute;
use Illuminate\Support\Str;
use Modules\Product\app\Models\VariantAttributeValue;

class AttributeService extends BaseService
{
    public function __construct(Attribute $attribute)
    {
        $this->model = $attribute;
    }
    
    public function getSelectableAttributes(){
        return $this->model::select('id', 'name', 'slug')
            ->where('is_active', true)
            ->with('values:id,attribute_id,tenant_id,slug,value')
            ->get();
    }

    public function getAttributeValuesByAttributeId($attribute_id = null){
        if ($attribute_id) {
            return $this->model->find($attribute_id)->values()->get();
        }        
        return [];
    }

    public function getAll(
        bool $isPaginated = true,
        bool $isSorted = true,
        array $relations = ['status', 'tenant'],
        int $perPage = 10,
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

    public function storeAttributeData()
    {
        $this->model = $this->model->create($this->attributeRequests());
        return $this;        
    }

    private function attributeRequests(){
        return [
            'name'          => $this->getAttr('name') ?? null,
            'slug'          => $this->getAttr('slug') ?? null,
            'tenant_id'     => $this->getAttr('tenant_id') ?? null, //should be auto filled
            'is_active'     => $this->getAttr('is_active') ?? null,
            'sorting_order' => $this->getAttr('sorting_order') ?? null,

            // "created_by" => null
            // "updated_by" => 1

        ];
    }


    public function storeAttributeValues(){
        $this->model
            ->values()
            ->createMany($this->attributeValueRequests());

        return $this;
    }

    public function updateAttributeData()
    {
        $this->model->update($this->attributeRequests());
        return $this;
    }


    public function updateAttributeValues()
    {
        $values = $this->attributeValueRequests();

        $ids = collect($values)->pluck('id')->filter();

        // Find values to delete
        $toDelete = $this->model
            ->values()
            ->whereNotIn('id', $ids)
            ->get();

        foreach ($toDelete as $value) {

            $isUsed = VariantAttributeValue::where(
                'attribute_value_id',
                $value->id
            )->exists();

            if (!$isUsed) {
                $value->delete();
            }
        }

        // update or create
        foreach ($values as $value) {

            $this->model->values()->updateOrCreate(
                ['id' => $value['id']],
                $value
            );

        }

        return $this;
    }


    private function attributeValueRequests()
    {
        $values = $this->getAttr('values') ?? [];
        // dd($this->model);
        return collect($values)
            ->filter(fn($v) => !empty($v['value']))
            ->map(function ($item) {

                return [
                    'id'           => $item['id'] ?? null,
                    'attribute_id' => $this->model->id,
                    'tenant_id'    => $this->model->tenant_id,
                    'value'        => $item['value'],
                    'slug'         => Str::slug($item['value']),
                ];

            })
            ->values()
            ->toArray();
    }

}
