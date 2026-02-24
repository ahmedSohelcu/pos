<?php

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Tenant\app\Models\Tenant;
use Modules\Plan\app\Models\Plan;
use Modules\Subscription\app\Models\Subscription;
use Modules\Payment\app\Models\Payment;
use App\Models\User;


class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ⚡ Get some tenants, plans, subscriptions
        $tenants = Tenant::take(5)->get();
        $plans = Plan::all();

        $adminUser = User::first(); // who created the payments

        foreach ($tenants as $tenant) {
            // Each tenant has 1-2 subscriptions
            $subscriptions = Subscription::where('tenant_id', $tenant->id)->take(2)->get();

            foreach ($subscriptions as $subscription) {
                // Random plan for payment
                $plan = $plans->random();

                Payment::create([
                    'tenant_id'       => $tenant->id,
                    'subscription_id' => $subscription->id,
                    'plan_id'         => $plan->id,
                    'plan_name'       => $plan->name,
                    'plan_price'      => $plan->price,
                    'gateway'         => ['bkash', 'nagad', 'bank', 'cash'][array_rand(['bkash', 'nagad', 'bank', 'cash'])],
                    'transaction_id'  => 'TRX-' . strtoupper(Str::random(8)),
                    'invoice_no'      => 'INV-' . strtoupper(Str::random(6)),
                    'amount'          => $plan->price,
                    'currency'        => 'BDT',
                    'status'          => ['pending', 'paid', 'failed'][array_rand(['pending', 'paid', 'failed'])],
                    'gateway_response'=> json_encode([
                        'mock_response' => true,
                        'transaction' => 'TRX-' . strtoupper(Str::random(8))
                    ]),
                    'paid_at'         => now(),
                    'created_by'      => $adminUser?->id,
                ]);
            }
        }

    }
}
