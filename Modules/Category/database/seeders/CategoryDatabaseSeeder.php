<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Category\app\Models\Category;
use Modules\Tenant\app\Models\Tenant;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::first();

        $categories = [
            'Grocery',
            'Medicine',
            'Beverages',
            'Snacks',
            'Electronics',
            'Furniture',
            'Books',
            'Clothing',
            'Home Appliances',
            'Kitchenware',
            'Sports',
            'Toys',
            'Cosmetics',
            'Healthcare',
            'Petcare',
            'Baby Products',
            'Stationery',
            'Office Supplies',
            'Home Decor',
            'Gardening',
            'Automotive',
            'Musical Instruments',
            'Fitness Equipment',
            'Jewelry',
            'Watches',
            'Eyewear',
            'Perfumes',
            'Digital Accessories',
            'Software',
            'Gifts',
            'Flowers',
            'Cakes',
            'Chocolates',
            'Food Items',
            'Spices',
            'Oils',
            'Fuel',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['tenant_id' => $tenant->id, 'slug' => Str::slug($category)],
                ['name' => $category]
            );
        }
    }
}
