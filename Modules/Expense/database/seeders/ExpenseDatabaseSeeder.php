<?php

namespace Modules\Expense\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Expense\app\Models\Expense;
use Modules\Expense\app\Models\ExpenseCategory;

class ExpenseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some categories
        $categories = ExpenseCategory::where('is_active', true)
            ->whereNotNull('id') // just in case
            ->get();

        // Get some users
        $users = User::all();

        if ($categories->isEmpty() || $users->isEmpty()) {
            $this->command->info('No categories or users found, skipping expense seeder.');
            return;
        }

        $expenses = [
            [
                'tenant_id' => 1,
                'expense_category_id' => 1,
                'amount' => 500,
                'expense_date' => '2026-03-01',
                'reference' => 'বাজার খরচ',
                'note' => 'অফিসের চা ও নাস্তার জন্য বাজার করা হয়েছে',
                'status_id' => 1,
            ],
            [
                'tenant_id' => 1,
                'expense_category_id' => 2,
                'amount' => 1200,
                'expense_date' => '2026-03-02',
                'reference' => 'বিদ্যুৎ বিল',
                'note' => 'অফিসের মার্চ মাসের বিদ্যুৎ বিল',
                'status_id' => 1,
            ],
            [
                'tenant_id' => 1,
                'expense_category_id' => 3,
                'amount' => 800,
                'expense_date' => '2026-03-03',
                'reference' => 'ইন্টারনেট বিল',
                'note' => 'মাসিক ইন্টারনেট সাবস্ক্রিপশন',
                'status_id' => 1,
            ],
            [
                'tenant_id' => 1,
                'expense_category_id' => 4,
                'amount' => 300,
                'expense_date' => '2026-03-04',
                'reference' => 'অফিস স্টেশনারি',
                'note' => 'কলম, কাগজ ও ফাইল কেনা হয়েছে',
                'status_id' => 1,
            ],
            [
                'tenant_id' => 1,
                'expense_category_id' => 5,
                'amount' => 1500,
                'expense_date' => '2026-03-05',
                'reference' => 'অফিস পরিষ্কার',
                'note' => 'পরিষ্কার কর্মীর মাসিক পারিশ্রমিক',
                'status_id' => 1,
            ],
        ];

        Expense::insert($expenses);



        // Generate 50 random expenses
        // for ($i = 1; $i <= 50; $i++) {

        //     $category = $categories->random();
        //     $user = $users->random();

        //     Expense::create([
        //         'tenant_id' => $category->tenant_id, // assign to same tenant as category
        //         'expense_category_id' => $category->id,
        //         'amount' => mt_rand(100, 5000), // random amount
        //         'expense_date' => now()->subDays(rand(0, 30)),
        //         'reference' => 'EXP-' . strtoupper(Str::random(6)),
        //         'note' => 'Auto-generated expense for testing.',
        //         'attachment' => null,
        //         // 'created_by' => $user->id,
        //         // 'updated_by' => $user->id,
        //     ]);
        // }
    }
}