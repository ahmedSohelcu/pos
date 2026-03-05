<?php

namespace Modules\Plan\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Plan\app\Services\PlanService;
use Modules\Plan\app\Http\Requests\PlanRequest;
use Modules\Plan\App\Models\Plan;

class PlanController extends Controller
{   
    public function __construct(PlanService $planService)
    {
        $this->service = $planService;
    }
    public function index()
    {
        $tenants = $this->service
            ->getAll(true, true, ['status'], 10);

        return success_response('Plan List', $tenants);
    }

    public function selectablePlans()
    {
        return $this->service->getSelectablePlans();        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanRequest $request) {  
        $plans = $this->service
            ->setAttributes($request->all())
            ->create();

        return created_responses('Plan created successfully', []);
    }
   

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $tenant = $this->service->findPlanById($id);
        return success_response('Plan', $tenant);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanRequest $request, Plan $plan) 
    {        
        $tenants = $this->service
            ->setModel($plan)
            ->setAttributes($request->all())
            ->update();

        return updated_response('Plan', $tenants);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $tenant = $this->service->delete($id);
        return deleted_responses('Plan', $tenant);
    }
}
