<?php

namespace Modules\Expense\App\Services;

use App\Services\Core\BaseService;
use Modules\Expense\app\Models\Expense;

class ExpenseService extends BaseService
{
    public function __construct(Expense $expense)
    {
        $this->model = $expense;
    }
}
