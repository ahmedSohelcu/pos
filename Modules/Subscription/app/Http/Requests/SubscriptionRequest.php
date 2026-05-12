<?php

namespace Modules\Subscription\App\Http\Requests;

use App\Http\Requests\BaseRequest;

class SubscriptionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'tenant_id' => ['required', 'exists:tenants,id'],
            'plan_id' => ['required', 'exists:plans,id'],
            'status_id' => ['required', 'exists:statuses,id'],
            'starts_at' => ['required', 'date', 'after_or_equal:today'],
            'ends_at' => ['required', 'date', 'after_or_equal:starts_at'],
            'is_current' => ['required', 'boolean'],
            'is_trial' => ['nullable', 'boolean'],
        ];
    }


    public function messages()
    {
        return [
            'tenant_id.required' => 'Tenant is required',
            'plan_id.required' => 'Plan is required',
            'status_id.required' => 'Status is required',
            'ends_at.required' => 'End date is required',
            'ends_at.after_or_equal' => 'End date must be after or equal to start date',
            'is_current.required' => 'Is current is required',
            'starts_at.required' => 'Start date is required',
            'starts_at.after_or_equal' => 'Start date must be after or equal to today',
        ];        
    }

}
