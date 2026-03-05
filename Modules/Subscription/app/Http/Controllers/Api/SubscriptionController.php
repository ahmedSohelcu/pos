<?php

namespace Modules\Subscription\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Subscription\app\Services\SubscriptionService;
use Modules\Subscription\app\Http\Requests\SubscriptionRequest;
use Modules\Subscription\app\Models\Subscription;

class SubscriptionController extends Controller
{   
    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->service = $subscriptionService;
    }
    public function index()
    {
        $plans = $this->service->getAll(true, true, ['tenant','plan','status'], 10);
        return success_response('Subscription List', $plans);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscriptionRequest $request) {        
        $this->service
            ->setAttrs($request->all())
            ->create();

        return created_responses('Subscription created successfully', []);
    }

    /**
     * Show the specified resource.
     */
    public function show(Subscription $subscription)
    {
        return success_response('Subscription', $subscription);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubscriptionRequest $request, Subscription $subscription) 
    {        
        $plans = $this->service
            ->setModel($subscription)
            ->setAttrs($request->all())
            ->update();

        return updated_response('Subscription', $plans);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription) {
        $subscription->delete();
        return deleted_responses('Subscription', $subscription);
    }
}
