<?php

namespace App\Models\Core;

use App\Filters\FilterBuilder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\HasApiTokens;

class BaseModel extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // -------------------------------
    // Scopes
    // -------------------------------
    public function scopeSearch($query, $value)
    {
        return $query->where('name', 'like', '%' . $value . '%');
    }

    public function scopeActive($query, $value = true)
    {
        return $query->where('is_active', $value);
    }

    public function scopeFilters($query, $filter)
    {
        if (is_array($filter)) {
            $filter = new FilterBuilder($filter);
        }

        if (!$filter instanceof FilterBuilder) {
            throw new \InvalidArgumentException("Filters must be a FilterBuilder instance or array.");
        }

        return $filter->apply($query);
    }

    public function scopeSort($query)
    {
        return $query->orderBy(request('sort_column', 'id'), request('sort_direction', 'asc'));
    }

    // -------------------------------
    // Boot method for tenant + user tracking
    // -------------------------------
    protected static function booted()
    {
        //--------------------------------
        // 1️⃣ Global Scope /  Filter data by Tenant
        //--------------------------------
        static::addGlobalScope('tenant_id', function ($builder) {
            if (!Auth::check()) return;
            $user = Auth::user();
            $model = $builder->getModel();
            $table = $model->getTable();

            if (Schema::hasColumn($table, 'tenant_id') && $user->user_type !== 'system_admin') {
                $builder->where($table.'.tenant_id', $user->tenant_id);
            }
        });

        
        //--------------------------------
        // 2️⃣ Creating
        //--------------------------------
        static::creating(function ($model) {
            if (!Auth::check()) return;

            $user = Auth::user();
            $table = $model->getTable();

            // Tenant auto assign //stopped due to testing via system admin            
            // if (Schema::hasColumn($table, 'tenant_id')) {
            //     if ($user->user_type === 'system_admin') {
            //         if (empty($model->tenant_id)) {
            //             throw new \Exception('Tenant is required for system admin');
            //         }
            //     } else {
            //         // set if not set yet
            //         if (empty($model->tenant_id)) {
            //             $model->tenant_id = $user->tenant_id;
            //         }
            //     }
            // }

            // created_by
            if (Schema::hasColumn($table, 'created_by') && empty($model->created_by)) {
                $model->created_by = $user->id;
            }

            // updated_by
            if (Schema::hasColumn($table, 'updated_by')) {
                $model->updated_by = $user->id;
            }
        });

        // 3️⃣ Updating
        static::updating(function ($model) {
            if (!Auth::check()) return;

            $user = Auth::user();
            $table = $model->getTable();

            // Prevent changing tenant_id for normal users
            if (Schema::hasColumn($table, 'tenant_id') && $user->user_type !== 'system_admin') {
                $model->tenant_id = $model->getOriginal('tenant_id');
            }

            // updated_by
            if (Schema::hasColumn($table, 'updated_by')) {
                $model->updated_by = $user->id;
            }
        });
    }
}