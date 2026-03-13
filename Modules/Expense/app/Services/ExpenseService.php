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

    public function getAll(
        bool $isPaginated = true,
        bool $isSorted = true,
        array $relations = ['status'],
        int $perPage = 10
    ) {
        $query = $this->model
            ->filters(request()->filters ?? []);

        // Relations
        if (!empty($relations)) {
            $query->with($relations);
        }

        // Sorting
        if ($isSorted) {
            $query->sort();
        }

        // Pagination or Get
        if ($isPaginated) {
            return $query
                ->paginate(request('per_page', $perPage))
                ->withQueryString();
        }

        return $query->get();
    }

    public function store()
    {
        $this->model->create(
            $this->expenseRequests()
        );
        return $this;   
    }


    private function expenseRequests(){
        return [
            'tenant_id'             => $data['tenant_id'] ?? null,
            'expense_category_id'   => $data['expense_category_id'] ?? null,
            'amount'                => $data['amount'] ?? null,
            'expense_date'          => $data['expense_date'] ?? null,
            'reference'             => $data['reference'] ?? null,
            'note'                  => $data['note'] ?? null,
            'status_id'             => $data['status_id'] ?? null,
            'sorting_order'         => $data['sorting_order'] ?? null,
        ];
    }


    public function update()
    {     
        $this->model->update($this->expenseRequests());
        return $this->$this;
    }
}