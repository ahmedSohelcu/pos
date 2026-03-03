<?php

namespace Modules\Brand\App\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class BrandRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $brand_id = $this->id ?? null;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brands', 'name')->ignore($brand_id),
            ],
            'slug' => [
                'nullable',
                Rule::unique('categories', 'slug')->ignore($brand_id),
            ],
            'tenant_id' => ['nullable','exists:tenants,id'],
            'status_id' => ['required','exists:statuses,id'],
            'description' => ['nullable','string'],
            'logo' => ['nullable'],
            'sorting_order' => ['nullable','integer'],
        ];
    }
}
