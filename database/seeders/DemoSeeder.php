<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Feature\database\seeders\FeatureSeeder;
use Modules\Feature\database\seeders\PlanFeatureSeeder;
use Illuminate\Support\Facades\DB;
use Modules\Brand\database\seeders\BrandDatabaseSeeder;
use Modules\Category\database\seeders\CategoryDatabaseSeeder;
use Modules\Customer\database\seeders\CustomerDatabaseSeeder;
use Modules\Payment\database\seeders\PaymentSeeder;
use Modules\Plan\database\seeders\PlanSeeder;
use Modules\Role\database\seeders\RoleDatabaseSeeder;
use Modules\Tenant\database\seeders\TenantSeeder;
use Modules\Subscription\database\seeders\SubscriptionSeeder;
use Modules\Unit\database\seeders\UnitDatabaseSeeder;

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

        //-------------------------
        // Create System Admin
        //-------------------------
        $user = User::create([
                'name'              => config('settings.system_admin.name'),
                'email'             => config('settings.system_admin.email'),
                'user_type'         => 'super_admin',
                'password'          => bcrypt(config('settings.system_admin.email'),),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10)
            ]);    
        // User::factory()->create();

        $this->call([
            PlanSeeder::class,
            FeatureSeeder::class,
            PlanFeatureSeeder::class,
            TenantSeeder::class,
            SubscriptionSeeder::class,
            PaymentSeeder::class,
            RoleDatabaseSeeder::class,
            PermissioSeeder::class,
            CategoryDatabaseSeeder::class,
            BrandDatabaseSeeder::class,
            UnitDatabaseSeeder::class,
            CustomerDatabaseSeeder::class
        ]);
    }
}

// seed specific class
// php artisan db:seed --class=DemoSeeder