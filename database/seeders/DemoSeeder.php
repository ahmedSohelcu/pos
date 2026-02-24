<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Feature\database\seeders\FeatureSeeder;
use Modules\Feature\database\seeders\PlanFeatureSeeder;
use Illuminate\Support\Facades\DB;
use Modules\Payment\database\seeders\PaymentSeeder;
use Modules\Plan\database\seeders\PlanSeeder;
use Modules\Tenant\database\seeders\TenantSeeder;
use Modules\Subscription\database\seeders\SubscriptionSeeder;

class DemoSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //-------------------------------------------------------------
        //Truncate full database before seed
        //-------------------------------------------------------------
        DB::statement("SET foreign_key_checks=0");
        $databaseName = DB::getDatabaseName();
        $tables = DB::select("SELECT * FROM information_schema.tables WHERE table_schema = '$databaseName'");
        foreach ($tables as $table) {
            $name = $table->TABLE_NAME;
            //if you don't want to truncate migrations
            if ($name == 'migrations') {
                continue;
            }
            DB::table($name)->truncate();
        }
        DB::statement("SET foreign_key_checks=1");
        //-------------------------------------------------------------


        // User::factory(10)->create();

        // Clean table first
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            PlanSeeder::class,
            FeatureSeeder::class,
            PlanFeatureSeeder::class,
            TenantSeeder::class,
            SubscriptionSeeder::class,
            PaymentSeeder::class,
        ]);
    }
}

// seed specific class
// php artisan db:seed --class=DemoSeeder