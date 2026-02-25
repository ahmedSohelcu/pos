<?php

namespace Modules\Tenant\App\Services;

use App\Services\Core\BaseService;
use Modules\Tenant\app\Models\Tenant;

class TenantService extends BaseService
{
    public function __construct(Tenant $tenant)
    {
        $this->model = $tenant;
    }

    public function all()
    {
        return $this->model
            ->paginate(request('per_page', 10));
    }
}
