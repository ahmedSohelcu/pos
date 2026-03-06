<?php

namespace Modules\Expense\App\Services;

use App\Services\Core\BaseService;
use Modules\Expense\app\Models\ExpenseCategory;

class ExpenseCategoryService extends BaseService
{
    public function __construct(ExpenseCategory $expenseCategory)
    {
        $this->model = $expenseCategory;
    }
}
