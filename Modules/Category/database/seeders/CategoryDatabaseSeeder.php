<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\app\Models\Category;
use Modules\Tenant\app\Models\Tenant;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::first();
            Category::firstOrCreate(
                ['tenant_id' => $tenant->id, 'slug' => 'beverages'],
                ['name' => 'Beverages']
            );

            Category::firstOrCreate(
                ['tenant_id' => $tenant->id, 'slug' => 'snacks'],
                ['name' => 'Snacks']
            );
    }
}
