<?php

namespace Modules\Brand\Database\Seeders;

use Modules\Brand\app\Models\Brand;
use Illuminate\Support\Str;
use Modules\Tenant\app\Models\Tenant;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class BrandDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::first();
        $faker = Faker::create();

        $brands = [
            ['name' => 'প্রাণ'],
            ['name' => 'আরএফএল'],
            ['name' => 'স্কয়ার'],
            ['name' => 'বাশুন্ধরা'],
            ['name' => 'আকিজ'],
            ['name' => 'ড্যানিশ'],
            ['name' => 'ইগলু'],
            ['name' => 'ফ্রেশ'],
            ['name' => 'অলিম্পিক'],
            ['name' => 'কেয়া'],
        ];

        for ($i = 1; $i <= 50; $i++) {
            $name = $faker->unique()->company;

            Brand::create([
                'name' => $name,
                'tenant_id' => $tenant->id,
                // 'status_id' => $status_id,
                'slug' => Str::slug($name)  // optional if trait handles
            ]);
        }
        
    }
}
