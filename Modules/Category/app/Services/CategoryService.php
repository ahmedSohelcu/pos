<?php

namespace Modules\Category\App\Services;

use App\Services\Core\BaseService;
use Modules\Category\app\Models\Category;

class CategoryService extends BaseService
{
    public function __construct(Category $category)
    {
        $this->model = $category;
    }   

    public function getAll(
        bool $isPaginated = true,
        bool $isSorted = true,
        array $relations = ['status', 'tenant'],
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

    public function create(array $data)
    {
        return $this->model->create($this->categoryRequests($data));
    }


    private function categoryRequests($data){
        return [
            'name'          => $data['name'] ?? null,
            'slug'          => $data['slug'] ?? null,
            'tenant_id'     => $data['tenant_id'] ?? null,
            'status_id'     => $data['status_id'] ?? null,
            'description'   => $data['description'] ?? null,
            'sorting_order' => $data['sorting_order'] ?? null,
        ];
    }

    public function findCategoryById($id){
        return $this->model->findOrFail($id);
    }


    public function update(array $data, $id)
    {     
        $this->model =  $this->model->find($id);
        $this->model->update($this->categoryRequests($data));
        return $this->model;
    }

    
    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();
        return $this->model;
    }
}

