<?php

namespace Modules\Attribute\App\Models;

use App\Models\Core\BaseModel;
use App\Models\Traits\HasStatus;
use App\Models\Traits\HasTenant;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Attribute\app\Models\AttributeValue;

class Attribute extends BaseModel
{
    use HasFactory,
        HasStatus,
        HasTenant,
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

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
