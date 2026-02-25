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
                'created_at' => now(),
            ],
            [
                'name' => 'Karim Pharmacy',
                'subdomain' => 'karim-pharmacy',
                'email' => 'karim@example.com',
                'phone' => '01722222222',
                'address' => '45 Health Road',
                'city' => 'Chattogram',
                'country' => 'BD',
                'created_at' => now(),
            ],
            [
                'name' => 'Jannat Super Shop',
                'subdomain' => 'jannat-super-shop',
                'email' => 'jannat@example.com',
                'phone' => '01733333333',
                'address' => '78 Market Street',
                'city' => 'Dhaka',
                'country' => 'BD',
                'created_at' => now(),
            ],
            [
                'name' => 'Kamal Pharmacy',
                'subdomain' => 'kamal-pharmacy',
                'email' => 'kamal@example.com',
                'phone' => '01744444444',
                'address' => '90 Health Road',
                'city' => 'Chattogram',
                'country' => 'BD',
                'created_at' => now(),
            ],
            [
                'name' => 'Tofail Pharmacy',
                'subdomain' => 'tofail-pharmacy',
                'email' => 'tofail@example.com',
                'phone' => '01766666666',
                'address' => '45 Health road',
                'city' => 'Chattogram',
                'country' => 'BD',
                'created_at' => now(),
            ],
            [
                'name' => 'Rafi Super Shop',
                'subdomain' => 'rafi-super-shop',
                'email' => 'rafi@example.com',
                'phone' => '01777777777',
                'address' => '78 Market Street',
                'city' => 'Dhaka',
                'country' => 'BD',
                'created_at' => now(),
            ],
            [
                'name' => 'Jahid Pharmacy',
                'subdomain' => 'jahid-pharmacy',
                'email' => 'jahid@example.com',
                'phone' => '01788888888',
                'address' => '90 Health road',
                'city' => 'Chattogram',
                'country' => 'BD',
                'created_at' => now(),
            ],
            [
                'name' => 'Mehedi Super Shop',
                'subdomain' => 'mehedi-super-shop',
                'email' => 'mehedi@example.com',
                'phone' => '01799999999',
                'address' => '123 Market Street',
                'city' => 'Dhaka',
                'country' => 'BD',
                'created_at' => now(),
            ],
            [
                'name' => 'Mahmud Pharmacy',
                'subdomain' => 'mahmud-pharmacy',
                'email' => 'mahmud@example.com',
                'phone' => '01722222222',
                'address' => '45 Health road',
                'city' => 'Chattogram',
                'country' => 'BD',
                'created_at' => now(),
            ],
            [
                'name' => 'Rahul Super Shop',
                'subdomain' => 'rahul-super-shop',
                'email' => 'rahul@example.com',
                'phone' => '01733333333',
                'address' => '78 Market Street',
                'city' => 'Dhaka',
                'country' => 'BD',
                'created_at' => now(),
            ],
            [
                'name' => 'Sohel Pharmacy',
                'subdomain' => 'sohel-pharmacy',
                'email' => 'sohel@example.com',
                'phone' => '01766666666',
                'address' => '90 Health road',
                'city' => 'Chattogram',
                'country' => 'BD',
                'created_at' => now(),
            ]
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
