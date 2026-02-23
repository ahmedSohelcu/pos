<?php
namespace App\Services\Core;
use App\Helpers\Traits\HasAttrs;
use Illuminate\Database\Eloquent\Model;

class BaseService {

    protected $model;
    use HasAttrs;

    public function setModel(Model $model): BaseService
    {
        $this->model = $model;
        return $this;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function save($options = [])
    {
        $attributes = count($options) ? $options : request()->all();

        $this->model
            ->fill($this->getFillAble($attributes))
            ->save();

        return $this->model;
    }
}
