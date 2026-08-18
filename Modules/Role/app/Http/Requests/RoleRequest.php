<?php

namespace Modules\Role\App\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $role_id = $this->route('role')?->id ?? null; // null for create

        return [
            'name' => [
                'required', 'string', 'max:255', 
                Rule::unique('roles', 'name')->ignore($role_id)
            ],
            'guard_name' => ['required', 'string', 'max:50'],
            'tenant_id' => ['required', 'exists:tenants,id'],
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Role name is required',
            'name.string' => 'Role name must be a valid string',
            'name.max' => 'Role name must not exceed 255 characters',
            'name.unique' => 'This role name already exists',

            'guard_name.required' => 'Guard name is required',
            'guard_name.string' => 'Guard name must be a valid string',
            'guard_name.max' => 'Guard name must not exceed 50 characters',

            'tenant_id.required' => 'Tenant is required',
            'tenant_id.exists' => 'Selected tenant does not exist',
        ];
    }
}
