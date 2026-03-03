<?php

namespace Modules\Unit\App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class UnitRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $unitId = $this->id ?? null; // null for create

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('units', 'name')->ignore($unitId),
            ],
            'short_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('units', 'short_name')->ignore($unitId),
            ],
            'tenant_id' => ['nullable', 'exists:tenants,id'],
            'status_id' => ['required', 'exists:statuses,id'],
            'sorting_order' => ['nullable', 'integer'],
        ];
    }
}
