<?php

namespace Modules\Customer\App\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
      public function rules(): array
    {
        $userId = $this->id ?? null; // null for create

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                // Unique check: ignore current tenant on update
                Rule::unique('users', 'email')->ignore($userId),
            ],
            // 'phone' => ['required', 'string', 'max:15'],
            'phone' => ['required', 'regex:/^\+?[0-9]{10,15}$/'],
            'address' => ['nullable', 'string', 'max:50'],
            'status_id' => ['nullable', 'exists:statuses,id'],

            // 'user_id' => ['nullable', 'exists:users,id'],
            // 'created_by' => ['nullable', 'exists:users,id'],
            'tenant_id' => ['nullable', 'exists:tenants,id'],
            'code' => ['nullable', 'string', 'max:255'],
            'profile_pic' => ['nullable', 'string', 'max:255'],
            'opening_balance' => ['nullable', 'numeric'],
            'current_balance' => ['nullable', 'numeric'],
            'loyalty_points' => ['nullable', 'integer'],
            'address' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:50'],
            'state' => ['nullable', 'string', 'max:50'],
            'country' => ['nullable', 'string', 'max:50'],
            'zip_code' => ['nullable', 'string', 'max:50'],
            'status_id' => ['nullable', 'exists:statuses,id'],
            'sorting_order' => ['nullable', 'integer'],
        ];
    }
}