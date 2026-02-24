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
        
        $defaultCustomers = [
            [
                'name'        => 'John Doe',
                'email'       => 'john@example.com',
                'phone'       => '01710000001',
                'company'     => 'ABC Ltd',
                'city'        => 'Dhaka',
                'profile_pic' => 'uploads/customers/john_doe.png',
            ],
            [
                'name'        => 'Jane Smith',
                'email'       => 'jane@example.com',
                'phone'       => '01710000002',
                'company'     => 'XYZ Corp',
                'city'        => 'Chittagong',
                'profile_pic' => 'uploads/customers/jane_smith.png',
            ],
            [
                'name'        => 'Michael Lee',
                'email'       => 'michael@example.com',
                'phone'       => '01710000003',
                'company'     => 'Acme Inc',
                'city'        => 'Khulna',
                'profile_pic' => 'uploads/customers/michael_lee.png',
            ],
        ];

        foreach (Tenant::all() as $tenant) {
            // Get a tenant user to assign as creator
            $createdBy = User::where('tenant_id', $tenant->id)->first()?->id;

            foreach ($defaultCustomers as $customer) {
                Customer::firstOrCreate(
                    [
                        'tenant_id' => $tenant->id,
                        'email'     => $customer['email'], // unique per tenant
                    ],
                    [
                        'name'       => $customer['name'],
                        'phone'      => $customer['phone'],
                        'company'    => $customer['company'],
                        'city'       => $customer['city'] ?? null,
                        'profile_pic'=> $customer['profile_pic'] ?? null,
                        'status_id'  => null, // Active by default
                        'created_by' => $createdBy,
                    ]
                );
            }
        }
    }
}
