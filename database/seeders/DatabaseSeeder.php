<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Plan\database\seeders\PlanDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */    

    public function run(): void
    {
        if (app()->environment('local')) {            
            $this->call(DemoSeeder::class);
        }

        if (app()->environment('production')) {
            $this->call(ProductionSeeder::class);
        }
    }
}

// seed specific class
// php artisan db:seed --class=DemoSeeder