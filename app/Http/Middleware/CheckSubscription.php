<?php

namespace App\Http\Middleware;

use App\Models\Core\Status;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Modules\Subscription\App\Models\Subscription;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
        // $user = $request->user()->tenant;
        
        /*
        if user is supper admin then no need to check subscription and permissions
        other
        1. user under tenant
        2. tenant has subscriptions
        3. is_current subscription not expred
        4. trial end date not more than today
        5. subscription ->features if available and user->roles->permissions
        then will get access..

        */
        //subscriptions
        //  "id" => 1
        // "tenant_id" => 1
        // "plan_id" => 1
        // "starts_at" => "2026-03-09"
        // "ends_at" => "2026-03-11" // expire or not
        // "is_current" => 1
        // "status_id" => null
        // "created_at" => "2026-03-09 14:40:32"
        // "updated_at" => "2026-03-09 14:40:32"
        // status => 'status_trial' or  'status_active',

        // start
        $user = $request->user();

        //-------------------------------
        // 1️⃣ System Admin bypass
        //-------------------------------
        if ($user->user_type === 'system_admin') {
            return $next($request);
        }

        //-------------------------------
        // 2️⃣ User must belong to tenant
        //-------------------------------
        $tenant = $user->tenant;

        if (!$tenant) {
            return response()->json([
                'success' => false,
                'message' => 'Tenant not found'
            ], 403);
        }

        //-------------------------------
        // 3️⃣ Get current subscription
        //-------------------------------
        $subscription = $tenant->subscriptions()
            ->where('is_current', 1)
            ->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'No active subscription'
            ], 403);
        }

        //--------------------------------
        // 4️⃣ Check trial
        //--------------------------------
        if ($subscription->status_id === Subscription::STATUS_TRIAL && Carbon::parse($subscription->ends_at)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Trial period ended'
            ], 403);
        }

        //--------------------------------
        // 5️⃣ Check Paid subscription expired
        //--------------------------------
        if (Carbon::parse($subscription->ends_at)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription expired'
            ], 403);
        }

        //--------------------------------
        // 6️⃣ Save subscription in request
        //--------------------------------
        $request->attributes->set('subscription', $subscription);

        
        // When a middleware runs, sometimes you fetch data that controllers or other middlewares will need. In your case:
        // You just queried the tenant’s current subscription.
        // Later, in your controller or another middleware, you might want:
        // Instead of querying the database again, you attach it to the request.
        // $subscription = $request->attributes->get('subscription');


        //--------------------------------
        // 7️⃣ Check feature access
        //--------------------------------
        $planFeatures = $subscription->plan->features()->where('is_active', true)->pluck('name')->toArray();

        // Optional: define required feature in route using middleware parameter
        $requiredFeature = $request->route()->getAction('feature') ?? null;

        if ($requiredFeature && !in_array($requiredFeature, $planFeatures)) {
            return response()->json([
                'success' => false,
                'message' => 'Feature not available in your plan'
            ], 403);
        }

        //--------------------------------
        // 8️⃣ Check permission
        //--------------------------------
        $requiredPermission = $request->route()->getAction('permission') ?? null;

        if ($requiredPermission && !$user->can($requiredPermission)) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to perform this action'
            ], 403);
        }

        return $next($request);
    }
}



// Route::middleware(['auth:sanctum','check.subscription'])
//     ->prefix('v1')->group(function () {

//     Route::get('tenants', [TenantController::class, 'index'])
//         ->name('tenant.index')
//         ->middleware('feature:tenant_view') // feature key
//         ->middleware('permission:tenant.view'); // spatie permission

//     Route::post('tenants', [TenantController::class, 'store'])
//         ->name('tenant.store')
//         ->middleware('feature:tenant_create')
//         ->middleware('permission:tenant.create');
// });