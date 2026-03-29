<?php

namespace Modules\Attribute\App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class AttributeRequest extends BaseRequest
{
        public function rules(): array
    {
        $attribute_id = $this->id ?? null;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('attributes', 'name')->ignore($attribute_id),
            ],
            'is_active' => ['nullable', 'boolean'],
            'slug' => [
                'nullable',
                Rule::unique('attributes', 'slug')->ignore($attribute_id),
            ],
            'tenant_id' => ['nullable','exists:tenants,id'],
            'sorting_order' => ['nullable','integer'],
        ];
    }
}
