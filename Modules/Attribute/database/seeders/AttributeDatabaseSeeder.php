<?php

namespace Modules\Attribute\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Attribute\app\Models\Attribute;
use Modules\Tenant\app\Models\Tenant;
use Illuminate\Support\Str;

class AttributeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $attributes = [
            'Size',
            'Color',
            'Weight',
            'Volume',
            'Material'
        ];

        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {

            foreach ($attributes as $name) {

                Attribute::firstOrCreate([
                    'tenant_id' => $tenant->id,
                    'slug' => Str::slug($name),
                ],[
                    'name' => $name,
                ]);

            }
        }
    }
}