<?php

namespace Modules\Subscription\Database\seeders;

use Illuminate\Database\Seeder;
use Modules\Subscription\app\Models\Subscription;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

         dd('test');
        // $this->call([]);


        // foreach ($tenants as $tenantData) {
        //     $tenant = Tenant::create($tenantData);

        //     // Optional: create trial subscription
        //     if ($basicPlan) {
        //         $tenant->subscriptions()->create([
        //             'plan_id' => $basicPlan->id,
        //             'starts_at' => now(),
        //             'ends_at' => now()->addDays($basicPlan->trial_days ?? 7),
        //             'status' => 'trial',
        //             'is_current' => true,
        //         ]);
        //     }
        // }
    
    }
}
