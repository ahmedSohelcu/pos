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

    //auto filter by tenant_id
    public function getSelectableExpenseCategories()
    {
        return $this->model::query()
            ->select('id', 'name')
            ->get();  
    }

    public function getAll(
        bool $isPaginated = true,
        bool $isSorted = true,
        array $relations = [],
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
        $this->model = $this->model->create($this->expenseCategoryRequests());
        return $this;
    }

     private function expenseCategoryRequests(){
        return [
            'name'              => $this->getAttr('name') ?? null,
            'slug'              => $this->getAttr('slug') ?? null,
            'tenant_id'         => $this->getAttr('tenant_id') ?? null,
            'description'       => $this->getAttr('description') ?? null,
            'parent_id'         => $this->getAttr('parent_id') ?? null,
            'is_active'         => $this->getAttr('is_active') ?? null,
            'icon'              => $this->getAttr('icon') ?? null,
            'sorting_order'     => $this->getAttr('sorting_order') ?? null,
        ];
    }

    public function findTenantById($id){
        return $this->model->findOrFail($id);
    }


    public function update()
    {     
        $this->model->update($this->expenseCategoryRequests());
        return $this;
    }
}
