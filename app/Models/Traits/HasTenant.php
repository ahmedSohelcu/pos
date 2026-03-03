<?php

namespace App\Models\Traits;

use Modules\Tenant\app\Models\Tenant;
use TenantScope;

trait HasTenant
{
    public static function bootHasTenant()
    {
        // later add. automatically check super admin
        // static::addGlobalScope(new TenantScope);

        static::creating(function ($model) {
            if (auth()->check() && empty($model->tenant_id)) {
                $model->tenant_id = auth()->user()->tenant_id;
            }
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}