<?php

namespace Modules\Expense\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Expense\app\Models\ExpenseCategory;

class ExpenseCatetorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            [
                'name' => 'Office Expense',
                'children' => [
                    'Stationary',
                    'Printing',
                    'Cleaning',
                ]
            ],

            [
                'name' => 'Transport',
                'children' => [
                    'Fuel',
                    'Taxi',
                    'Vehicle Maintenance',
                ]
            ],

            [
                'name' => 'Utilities',
                'children' => [
                    'Electricity',
                    'Internet',
                    'Water Bill',
                ]
            ],

            [
                'name' => 'Food & Entertainment',
                'children' => [
                    'Staff Lunch',
                    'Client Meeting',
                ]
            ]

        ];

        foreach ($categories as $category) {

            $parent = ExpenseCategory::create([
                'tenant_id' => 1,
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'is_active' => true,
                'sort_order' => 0,
            ]);

            if (!empty($category['children'])) {
                foreach ($category['children'] as $child) {
                    ExpenseCategory::create([
                        'tenant_id' => 1,
                        'parent_id' => $parent->id,
                        'name' => $child,
                        'slug' => Str::slug($child),
                        'is_active' => true,
                        'sort_order' => 0,
                    ]);
                }
            }
        }
    }
}
