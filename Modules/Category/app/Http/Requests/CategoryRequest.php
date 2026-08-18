<?php

namespace Modules\Category\App\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $category_id = $this->route('category')?->id ?? null;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($category_id),
            ],
            'tenant_id' => ['nullable','exists:tenants,id'],
            'status_id' => ['required','exists:statuses,id'],
            'description' => ['nullable','string'],
            'logo' => ['nullable'],
            'sorting_order' => ['nullable','integer'],
            'slug' => [
                'nullable',
                Rule::unique('categories', 'slug')->ignore($category_id),
            ],
        ];
    }
}
