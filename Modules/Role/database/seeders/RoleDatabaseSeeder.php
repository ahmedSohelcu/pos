<?php

namespace Modules\Role\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Modules\Tenant\App\Models\Tenant;

class RoleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // 2️⃣ Tenant-specific roles
        foreach (Tenant::all() as $tenant) {

            $roles = [
                'Admin',
                'Manager',
                'Staff',
            ];

            foreach ($roles as $roleName) {
                Role::firstOrCreate(
                    [
                        'name' => $roleName,
                        'guard_name' => 'api',
                        'tenant_id' => null,
                    ]
                );
            }
        }
    }
}
