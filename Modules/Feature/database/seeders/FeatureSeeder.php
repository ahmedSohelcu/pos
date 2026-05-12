<?php

namespace Modules\Feature\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Feature\app\Models\Feature;
use Spatie\Permission\Models\Permission;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = Permission::all();

        foreach ($permissions as $permission) {

            Feature::updateOrCreate(
                [
                    'name' => $permission->name
                ],
                [
                    'label' => $this->makeLabel($permission->name),
                    'description' => 'Feature for ' . $permission->name,
                    'is_active' => true,
                    'sorting_order' => 1
                ]
            );
        }
    }

    private function makeLabel($name)
    {
        return ucwords(str_replace('.', ' ', $name));
    }
}