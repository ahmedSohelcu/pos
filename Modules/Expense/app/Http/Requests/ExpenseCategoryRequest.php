<?php

namespace Modules\Expense\App\Http\Requests;
use Illuminate\Validation\Rule;

use App\Http\Requests\BaseRequest;

class ExpenseCategoryRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $category_id = $this->route('expense_category')?->id ?? null;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('expense_categories', 'name')
                    ->where('tenant_id', $this->tenant_id)
                    ->ignore($category_id),
            ],
            'tenant_id' => ['nullable','exists:tenants,id'],
            'description' => ['nullable','string'],
            'sorting_order' => ['nullable','integer'],
            'is_active' => ['nullable', 'boolean'],
            'slug' => [
                'nullable',
                Rule::unique('expense_categories', 'slug')
                    ->where('tenant_id', $this->tenant_id)
                    ->ignore($category_id),
            ],
        ];
    }
}
