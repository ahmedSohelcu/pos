<?php

namespace Modules\Feature\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Modules\Plan\App\Models\Plan;
use Modules\Feature\App\Models\Feature;

class PlanFeatureSeeder extends Seeder
{
    public function run(): void
    {
        $plans = Plan::all();
        $features = Feature::all();

        // foreach ($plans as $plan) {
        //     foreach ($features as $feature) {
        //         $plan->features()->syncWithoutDetaching([
        //             $feature->id => ['is_enabled' => true]
        //         ]);
        //     }
        // }
    }
    
}