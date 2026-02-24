<?php

namespace Modules\Brand\Database\Seeders;

use Modules\Brand\app\Models\Brand;
use Modules\Tenant\app\Models\Tenant;

use Illuminate\Database\Seeder;

class BrandDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Example brands per tenant
         $tenant = Tenant::first();
        // foreach (Tenant::first() as $tenant) {

            $brands = [
                ['name' => 'Coca Cola', 'slug' => 'coca-cola', 'tenant_id' => $tenant->id],
                ['name' => 'Pepsi',      'slug' => 'pepsi',      'tenant_id' => $tenant->id],
                ['name' => 'Nestle',     'slug' => 'nestle',     'tenant_id' => $tenant->id],
                ['name' => 'Unilever',   'slug' => 'unilever',   'tenant_id' => $tenant->id],
            ];

            foreach ($brands as $brand) {
                Brand::firstOrCreate($brand);
            }
        // }
    }
}
