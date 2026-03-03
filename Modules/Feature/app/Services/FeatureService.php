<?php

namespace Modules\Feature\Services;

use App\Services\Core\BaseService;
use Modules\Feature\App\Models\Feature;

class FeatureService extends BaseService
{
    public function __construct(Feature $feature)
    {
        $this->model = $feature;
    }
}
