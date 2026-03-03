<?php

namespace Modules\Subscription\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Subscription\app\Services\SubscriptionService;
use Modules\Subscription\app\Http\Requests\SubscriptionRequest;

class SubscriptionController extends Controller
{   
    protected $service;    

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->service = $subscriptionService;
    }
    public function index()
    {
        $plans = $this->service->getAll(true, true, ['status'], 10);
        return success_response('Subscription List', $plans);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscriptionRequest $request) {        
        $this->service->create($request->all());
        return created_responses('Subscription created successfully', []);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $plan = $this->service->findSubscriptionById($id);
        return success_response('Subscription', $plan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubscriptionRequest $request, $id) 
    {        
        $plans = $this->service->update($request->all(), $id);
        return updated_response('Subscription', $plans);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $plan = $this->service->delete($id);
        return deleted_responses('Subscription', $plan);
    }
}
