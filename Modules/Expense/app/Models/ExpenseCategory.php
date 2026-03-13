<?php

namespace Modules\Expense\App\Models;

use App\Models\Core\BaseModel;
use App\Models\Traits\HasStatus;
use App\Models\Traits\HasTenant;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseCategory extends BaseModel
{
    use HasFactory,
        HasStatus,
        HasSlug,
        HasTenant;
    /*
     * The attributes that are mass assignable.
    */
      protected $fillable = [
        'name',
        'slug',
        'tenant_id',
        'description',
        'parent_id',
        'created_by',
        'updated_by',
        'icon',        
        'is_active',
        'sorting_order'
    ];
}
