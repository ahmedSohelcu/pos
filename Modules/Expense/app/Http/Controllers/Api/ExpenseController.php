<?php

namespace Modules\Expense\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Expense\App\Models\Expense;
use Modules\Expense\app\Services\ExpenseService;
use Modules\Tenant\App\Http\Requests\Tenant\TenantRequest;

class ExpenseController extends Controller
{   
    protected $service;    


    public function __construct(ExpenseService $expenseService)
    {
        $this->service = $expenseService;
    }
    public function index()
    {
        $expenses = $this->service->getAll(true, true, ['status'], 10);
        return success_response('Expense List', $expenses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TenantRequest $request) {      
        $this->service
        ->setAttrs($request->all())
        ->create();

        return created_responses('Expense created successfully', []);
    }

    /**
     * Show the specified resource.
     */
    public function show(Expense $expense)
    {
        return success_response('Expense', $expense);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TenantRequest $request, Expense $expense) 
    {        
        $tenants = $this->service
            ->setModel($expense)
            ->setAttrs($request->all())
            ->update();

        return updated_response('Expense', $tenants);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense) {
        $expense->delete();
        return deleted_responses('Expense', $expense);
    }
}
