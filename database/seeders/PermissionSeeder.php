<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔥 Clear Spatie cache
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // 1️⃣ Base permissions (system level)
        $basePermissions = [
            ['name' => 'user.create', 'guard_name' => 'api', 'tenant_id' => null],
            ['name' => 'user.edit',   'guard_name' => 'api', 'tenant_id' => null],
            ['name' => 'user.delete', 'guard_name' => 'api', 'tenant_id' => null],
            ['name' => 'user.view',   'guard_name' => 'api', 'tenant_id' => null],
            //full user modules permission need to add
        ];

        // 2️⃣ Collect module permissions
        $modules = [
            'role',
            'subscription',
            'plan',
            'feature',
            'tenant',
            'payment',
            'unit',
            'category',
            'brand',
            'customer',
            'expense',
        ];

        $modulePermissions = [];

        foreach ($modules as $module) {
            $configPermissions = config($module . '.permissions', []);
            $modulePermissions = array_merge($modulePermissions, $configPermissions);
        }

        // 3️⃣ Merge all
        $allPermissions = array_merge($basePermissions, $modulePermissions);

        // 4️⃣ Insert safely (no duplicates)
        foreach ($allPermissions as $permission) {

            Permission::firstOrCreate(
                [
                    'name'       => $permission['name'],
                    'guard_name' => $permission['guard_name'] ?? 'api',
                ],
                [
                    'tenant_id'  => $permission['tenant_id'] ?? null
                ]
            );
        }
    }
}