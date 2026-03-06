<?php

namespace Modules\Customer\Database\Seeders;
use Modules\Customer\app\Models\Customer;
use Modules\Tenant\app\Models\Tenant;
use app\Models\User;
use Illuminate\Database\Seeder;

class CustomerDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::query()->where('user_type', 'tenant_customer')
            ->get();

        foreach ($users as $user) {

            // Skip if customer already exists
            // if ($user->customer) {
            //     continue;
            // }

            Customer::create([
                'user_id'   => $user->id,                
                'opening_balance' => 0,
                'current_balance' => 0,
                'loyalty_points'  => 0,
                'is_walkin' => false,
            ]);
        }

        // Create walk-in customer for each tenant
        $tenantIds = User::pluck('tenant_id')->unique();

        foreach ($tenantIds as $tenantId) {
            Customer::firstOrCreate([
                'user_id' => $tenantId,
                'is_walkin' => true,
            ], [
                'opening_balance' => 0,
                'current_balance' => 0,
            ]);
        }
    
    }
}



        // 'user_id',
        // 'code',
        // 'profile_pic',
        // 'tenant_id',
        // 'created_by',
        // 'opening_balance',
        // 'current_balance',
        // 'loyalty_points',
        // 'is_walkin',

        // 'address',
        // 'city',
        // 'state',
        // 'country',
        // 'zip_code',

        // 'status_id',
        // 'sorting_order',