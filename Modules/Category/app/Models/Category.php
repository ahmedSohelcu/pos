<?php

namespace Modules\Category\App\Models;

use App\Models\Core\BaseModel;
use App\Models\Core\Status;
use App\Models\Traits\HasStatus;
use App\Models\Traits\HasTenant;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Tenant\app\Models\Tenant;

// use Modules\Category\Database\Factories\CategoryFactory;

class Category extends BaseModel
{
    use HasFactory,
        HasStatus,
        HasTenant,
        HasSlug;

        // protected static $slugFrom = 'name';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'tenant_id',
        'status_id',
        'created_by',
        'updated_by',

    ];

}
