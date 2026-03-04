<?php

namespace Modules\Plan\Database\seeders;

use Illuminate\Database\Seeder;
use Modules\Plan\app\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'price' => 999,
                'billing_interval' => 'monthly',
                'billing_duration' => 1,
                'max_users' => 3,
                'trial_days' => 2,
                'max_products' => 500,
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'price' => 2499,
                'billing_interval' => 'monthly',
                'billing_duration' => 1,
                'max_users' => 10,
                'trial_days' => 2,
                'max_products' => 5000,
            ]
        ];

        Plan::insert($plans);
    }
}
