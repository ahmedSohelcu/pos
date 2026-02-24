<?php

namespace Modules\Tenant\Database\seeders;

use Illuminate\Database\Seeder;
use Modules\Tenant\app\Models\Tenant;
use Modules\Plan\app\Models\Plan;

class TenantSeeder extends Seeder
{
    public function run(): void
    {

        // Fetch plans
        $basicPlan = Plan::where('slug', 'basic')->first();
        $proPlan   = Plan::where('slug', 'pro')->first();

        // Demo tenants
        $tenants = [
            [
                'name' => 'Rahim Super Shop',
                'subdomain' => 'rahim-super-shop',
                'email' => 'rahim@example.com',
                'phone' => '01711111111',
                'address' => '123 Market Street',
                'city' => 'Dhaka',
                'country' => 'BD',
            ],
            [
                'name' => 'Karim Pharmacy',
                'subdomain' => 'karim-pharmacy',
                'email' => 'karim@example.com',
                'phone' => '01722222222',
                'address' => '45 Health Road',
                'city' => 'Chattogram',
                'country' => 'BD',
            ],
        ];

        $tenant = Tenant::insert($tenants);

        // foreach ($tenants as $tenantData) {           

            // Optional: create trial subscription
            // if ($basicPlan) {
            //     $tenant->subscriptions()->create([
            //         'plan_id' => $basicPlan->id,
            //         'starts_at' => now(),
            //         'ends_at' => now()->addDays($basicPlan->trial_days ?? 7),
            //         'status' => 'trial',
            //         'is_current' => true,
            //     ]);
            // }
        // }
    }
}
