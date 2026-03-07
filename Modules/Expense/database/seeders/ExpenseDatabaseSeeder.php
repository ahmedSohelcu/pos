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

        // Generate 50 random expenses
        for ($i = 1; $i <= 50; $i++) {

            $category = $categories->random();
            $user = $users->random();

            Expense::create([
                'tenant_id' => $category->tenant_id, // assign to same tenant as category
                'expense_category_id' => $category->id,
                'amount' => mt_rand(100, 5000), // random amount
                'expense_date' => now()->subDays(rand(0, 30)),
                'reference' => 'EXP-' . strtoupper(Str::random(6)),
                'note' => 'Auto-generated expense for testing.',
                'attachment' => null,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
    }
}