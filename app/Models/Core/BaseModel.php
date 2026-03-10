<?php

namespace App\Models\Core;

use App\Filters\FilterBuilder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\HasApiTokens;

// use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Authenticatable
{
    use HasApiTokens,
        Notifiable;
    // use SoftDeletes;
    
    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    /*         
        -------------------------------
        Here Boot optin belos works for 
        -------------------------------
        * Filte by tentant_id if logged in user not system admin
        * auto assign tenant_id if logged in user not system admin
        * auto assign created_by id
        * auto assign updated_by id
    */

    public function scopeSearch($query, $value)
    {
        return $query->where('name', 'like', '%' . $value . '%');
    }

    // Scope for active records
    public function scopeActive($query, $value = true)
    {
        return $query->where('is_active', $value);
    }

    public function scopeFilters($query, $filter)
    {
        if (is_array($filter)) {
            $filter = new FilterBuilder($filter); // or your base filter
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

    // Global Scopes for tenant_id, created_by, updated_by
    protected static function booted()
    {         
        //--------------------------
        // 01 Tenant Global Scope
        //--------------------------
        static::addGlobalScope('tenant_id', function ($builder) {
            if (!Auth::check()) {
                return;
            }
            
            $model = $builder->getModel();
            $table = $model->getTable();
            $user  = Auth::user();

            // check column exists
            if (Schema::hasColumn($table, 'tenant_id') && $user->user_type !== 'system_admin') {
                $builder->where($table.'.tenant_id', $user->tenant_id);
            }
        });

        //02 Creating
        static::creating(function ($model) {
            if (!Auth::check()) {
                return;
            }

            $user = Auth::user();
            $table = $model->getTable();

            // Auto set tenant_id
            if (Schema::hasColumn($table, 'tenant_id') && $user->user_type !== 'system_admin') {
                $model->tenant_id = $user->tenant_id;
            }

            // Auto set created_by
            if (Schema::hasColumn($table, 'created_by')) {
                $model->created_by = $user->id;
            }

            // Auto set updated_by
            if (Schema::hasColumn($table, 'updated_by')) {
                $model->updated_by = $user->id;
            }
        });

        // Updating
        static::updating(function ($model) {

            if (!Auth::check()) {
                return;
            }
            $table = $model->getTable();

            if (Schema::hasColumn($table, 'updated_by')) {
                $model->updated_by = Auth::id();
            }
        });
    }

    //    public function createdRules()
//    {
//        return [
//            //
//        ];
//    }
//
//    public function updatedRules()
//    {
//        return $this->createdRules();
//    }
}
