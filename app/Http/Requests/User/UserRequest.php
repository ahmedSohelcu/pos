<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class UserRequest extends BaseRequest
{
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
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'tenant_id' => ['nullable', 'exists:tenants,id'],
            'status_id' => ['required', 'exists:statuses,id'],
        ];
    }
}
