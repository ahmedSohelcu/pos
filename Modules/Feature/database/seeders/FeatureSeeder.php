<?php

namespace Modules\Feature\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Feature\app\Models\Feature;
use Modules\Feature\app\Models\PlanFeature;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ✅ Define default features
        $features = [
            ['name' => 'product_create',  'label' => 'Create Product',  'description' => 'Allow tenant to create new products'],
            ['name' => 'product_edit',    'label' => 'Edit Product',    'description' => 'Allow tenant to edit products'],
            ['name' => 'product_delete',  'label' => 'Delete Product',  'description' => 'Allow tenant to delete products'],
            ['name' => 'branch_manage',   'label' => 'Manage Branches', 'description' => 'Allow tenant to manage branches'],
            ['name' => 'report_view',     'label' => 'View Reports',    'description' => 'Allow tenant to view reports'],
            ['name' => 'user_manage',     'label' => 'Manage Users',    'description' => 'Allow tenant to manage users'],
            ['name' => 'inventory_view',  'label' => 'View Inventory',  'description' => 'Allow tenant to see inventory stock'],
        ];

        // ⚡ Insert features
        Feature::insert($features);
    }
}

// seed specific class
// php artisan db:seed --class=DemoSeeder