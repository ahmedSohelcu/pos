<?php

namespace Modules\Product\App\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends BaseRequest
{
   
    public function rules(): array
    {
        $product_id = $this->id ?? null;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('attributes', 'name')->ignore($product_id),
            ],
            'is_active' => ['nullable', 'boolean'],
            'slug' => [
                'nullable',
                Rule::unique('attributes', 'slug')->ignore($product_id),
            ],
            'tenant_id' => ['nullable','exists:tenants,id'],
            'sorting_order' => ['nullable','integer'],
        ];
    }
}