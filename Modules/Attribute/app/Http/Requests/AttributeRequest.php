<?php

namespace Modules\Attribute\App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class AttributeRequest extends BaseRequest
{
    public function rules(): array
    {
        $attribute_id = $this->id ?? null;      
        $tenant_id = $this->tenant_id ?? auth()->user()->tenant_id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('attributes', 'name')
                    ->where('tenant_id', $tenant_id)
                    ->ignore($attribute_id),
            ],
            'slug' => [
                'nullable',
                Rule::unique('attributes', 'slug')
                    ->where('tenant_id', $tenant_id)
                    ->ignore($attribute_id),
            ],
            'is_active' => ['nullable', 'boolean'],
            'tenant_id' => ['nullable', 'exists:tenants,id'],
            'sorting_order' => ['nullable', 'integer'],
            'values' => ['nullable']
                // function ($attribute) {
                //     return collect($attribute)->map(function ($value) {
                //         return [
                //             'id' => $value['id'] ?? null,
                //             'value' => $value['value'] ?? '',
                //         ];
                //     })->toArray();
                // },
            
            // ],
        ];
    }
}



