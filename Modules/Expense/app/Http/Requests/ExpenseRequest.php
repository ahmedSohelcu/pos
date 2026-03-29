<?php

namespace Modules\Expense\App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class ExpenseRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $expense_id = $this->id ?? null; // null for create         
            
        return [            
            'tenant_id' => ['nullable','exists:tenants,id'],
            'expense_category_id' => ['required','exists:expense_categories,id'],
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'reference' => 'nullable|string',
            'note' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx',
            'sorting_order' => 'nullable|integer|min:0',                      
            'status_id' => ['nullable', 'exists:statuses,id'],
        ]; 
    }
}
