<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Subscription\App\Models\Subscription;
use Carbon\Carbon;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // 1️⃣ System admin bypass
        if ($user->user_type === 'system_admin') {
            return $next($request);
        }

        // 2️⃣ User must belong to tenant
        $tenant = $user->tenant;
        if (!$tenant) {
            return response()->json([
                'success' => false,
                'message' => 'Tenant not found',
            ], 403);
        }

        // 3️⃣ Get current subscription
        $subscription = $tenant->subscriptions()->where('is_current', 1)->first();

        // 6️⃣ Attach subscription info to request
        $request->attributes->set('subscription', $subscription);

        // 4️⃣ & 5️⃣ Check trial or paid subscription
        if (!$subscription || Carbon::parse($subscription->ends_at)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription expired',
                'error'   => 'SUBSCRIPTION_EXPIRED',
                'subscription' => $subscription ? $subscription->load('plan.features') : null,
            ], 403);
        }

        // 7️⃣ Check feature access
        $planFeatures = $subscription->plan->features()->where('is_active', true)->pluck('name')->toArray();
        $requiredFeature = $request->route()->getAction('feature') ?? null;
        if ($requiredFeature && !in_array($requiredFeature, $planFeatures)) {
            return response()->json([
                'success' => false,
                'message' => 'Feature not available in your plan',
            ], 403);
        }

        // 8️⃣ Check permission
        $requiredPermission = $request->route()->getAction('permission') ?? null;
        if ($requiredPermission && !$user->can($requiredPermission)) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to perform this action',
            ], 403);
        }

        return $next($request);
    }
}