<?php

namespace Modules\Plan\App\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class PlanRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $plan_id = $this->id ?? null; // null for create          

        return [
            'name' => ['nullable','string','max:255', Rule::unique('plans','name')->ignore($plan_id)],
            'slug' => ['nullable','string','max:255', Rule::unique('plans','slug')->ignore($plan_id)],
            'price' => 'required|numeric|min:0',
            'currency' => 'nullable|string|size:3',
            'billing_interval' => ['required', Rule::in(['monthly','yearly'])],
            'trial_days' => 'nullable|integer|min:0',
            'max_users' => 'nullable|integer|min:1',
            'max_products' => 'nullable|integer|min:1',
            'max_branches' => 'nullable|integer|min:1',
            'is_active' => 'nullable',
            'description' => 'nullable|string',
            'sorting_order' => 'nullable|integer|min:0',
        ];        
    }



    public function messages()
    {
        return [
            'name.required' => 'Plan name is required.',
            'name.string' => 'Plan name must be a valid string.',
            'name.max' => 'Plan name may not be greater than 255 characters.',

            'slug.unique' => 'This slug is already in use.',
            'slug.max' => 'Slug may not be greater than 255 characters.',

            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price cannot be negative.',

            'currency.required' => 'Currency is required.',
            'currency.size' => 'Currency must be a 3-letter code (e.g., USD, BDT).',

            'billing_interval.required' => 'Billing interval is required.',
            'billing_interval.in' => 'Billing interval must be monthly or yearly.',

            'trial_days.integer' => 'Trial days must be a valid number.',
            'trial_days.min' => 'Trial days cannot be negative.',

            'max_users.integer' => 'Max users must be a valid number.',
            'max_users.min' => 'Max users must be at least 1.',

            'max_products.integer' => 'Max products must be a valid number.',
            'max_products.min' => 'Max products must be at least 1.',

            'max_branches.integer' => 'Max branches must be a valid number.',
            'max_branches.min' => 'Max branches must be at least 1.',

            'is_active.required' => 'Status field is required.',
            'is_active.boolean' => 'Status must be true or false.',

            'sorting_order.integer' => 'Sorting order must be a valid number.',
            'sorting_order.min' => 'Sorting order cannot be negative.',
        ];
    }


    public function attributes()
    {
        return [
            'name' => 'Plan name',
            'slug' => 'Slug',
            'price' => 'Price',
            'currency' => 'Currency',
            'billing_interval' => 'Billing interval',
            'trial_days' => 'Trial days',
            'max_users' => 'Max users',
            'max_products' => 'Max products',
            'max_branches' => 'Max branches',
            'is_active' => 'Status',
            'description' => 'Description',
            'sorting_order' => 'Sorting order',
        ];
    }
}
