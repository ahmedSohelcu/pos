<?php

namespace Modules\Unit\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Unit\app\Models\Unit;
use Modules\Tenant\app\Models\Tenant;

class UnitDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultUnits = [
            ['name' => 'Piece', 'short_name' => 'pc'],
            ['name' => 'Kilogram', 'short_name' => 'kg'],
            ['name' => 'Gram', 'short_name' => 'g'],
            ['name' => 'Liter', 'short_name' => 'L'],
            ['name' => 'Milliliter', 'short_name' => 'ml'],
            ['name' => 'Pack', 'short_name' => 'pack'],
        ];

        // foreach (Tenant::all() as $tenant) {
        $tenant = Tenant::first();
            foreach ($defaultUnits as $unit) {
                Unit::firstOrCreate([
                    'tenant_id'   => $tenant->id,
                    'short_name'  => $unit['short_name'],
                ], [
                    'name'        => $unit['name'],
                    'status_id'   => null, // Active by default
                ]);
            }
        // }
    }
}
