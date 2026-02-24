<?php

namespace Modules\Subscription\Database\seeders;

use Illuminate\Database\Seeder;
use Modules\Plan\App\Models\Plan;
use Modules\Subscription\app\Models\Subscription;
use Modules\Tenant\App\Models\Tenant;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $basicPlan = Plan::where('slug', 'basic')->first();
        $proPlan   = Plan::where('slug', 'pro')->first();        
        $tenants = Tenant::query()->get();

        foreach ($tenants as $tenant) {

            // Optional: create trial subscription
            if ($basicPlan) {
                $tenant->subscriptions()->create([
                    'plan_id' => $basicPlan->id,
                    'starts_at' => now(),
                    'ends_at' => now()->addDays($basicPlan->trial_days ?? 7),
                    'status' => 'trial',
                    'is_current' => true,
                ]);
            }
        }
    
    }
}
