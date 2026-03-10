<?php

namespace App\Models\Traits;

use Modules\Tenant\app\Models\Tenant;
use TenantScope;

trait HasTenant
{
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}