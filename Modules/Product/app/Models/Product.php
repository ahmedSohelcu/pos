<?php

namespace Modules\Product\App\Models;

use App\Models\Core\BaseModel;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Product\Database\Factories\ProductFactory;

class Product extends BaseModel
{
    use HasFactory,
        HasSlug;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'tenant_id', // important for multi-tenant
        'is_active',
        'sorting_order',
    ];
}