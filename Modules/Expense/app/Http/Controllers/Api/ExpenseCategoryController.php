<?php

namespace Modules\Expense\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Expense\App\Http\Requests\ExpenseCategoryRequest;
use Modules\Expense\App\Models\ExpenseCategory;
use Modules\Expense\app\Services\ExpenseCategoryService;

class ExpenseCategoryController extends Controller
{   
    public function __construct(ExpenseCategoryService $expenseCategoryService)
    {
        $this->service = $expenseCategoryService;
    }
    public function index()
    {
        $expenseCategories = $this->service->getAll(true, true, ['status'], 10);
        return success_response('Expense Category List', $expenseCategories);
    }

    public function selectableExpenseCategories($tenant_id)
    {
        return $this->service->getSelectableExpenseCategories($tenant_id);        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseCategoryRequest $request) {      
        $this->service
            ->setAttrs($request->all())
            ->create();

        return created_responses('Expense created successfully', []);
    }

    /**
     * Show the specified resource.
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        return success_response('Expense Category', $expenseCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseCategoryRequest $request, ExpenseCategory $expenseCategory) 
    {        
        $tenants = $this->service
            ->setModel($expenseCategory)
            ->setAttrs($request->all())
            ->update();

        return updated_response('Expense Category', $tenants);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseCategory $expenseCategory) {
        $expenseCategory->delete();
        return deleted_responses('Tenant', $expenseCategory);
    }
}

