<?php

namespace App\Services\Status;

use App\Models\Status;
use App\Services\Core\BaseService;

class StatusService extends BaseService
{
    public function __construct(Status $status)
    {
        $this->model = $status;
    }

    // this method is used from multiple endpoint
    public function getSelectableStatuses($type)
    {
        return $this->model::query()
            ->where(['type' => $type])
            ->select(['id', 'name', 'type', 'class'])
            ->get();
    }
}



