<?php

namespace Modules\Tenant\App\Http\Requests\Tenant;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// Request is for both creating or updating a tenant
class TenantRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $tenantId = $this->id ?? null; // null for create

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                // Unique check: ignore current tenant on update
                Rule::unique('tenants', 'email')->ignore($tenantId),
            ],
            // 'phone' => ['required', 'string', 'max:15'],
            'phone' => ['required', 'regex:/^\+?[0-9]{10,15}$/'],
            'address' => ['nullable', 'string', 'max:50'],
            'status_id' => ['required', 'exists:statuses,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be valid',
            'email.unique' => 'This email is already taken',
            'phone.required' => 'Phone is required',
            'status_id.required' => 'Status is required',
            'status_id.exists' => 'Selected status is invalid',
        ];
    }
}
