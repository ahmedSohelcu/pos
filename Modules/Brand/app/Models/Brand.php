<?php

namespace Modules\Brand\App\Models;

use App\Models\Core\BaseModel;
use App\Models\Core\Status;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Tenant\app\Models\Tenant;

// use Modules\Brand\Database\Factories\BrandFactory;

class Brand extends BaseModel
{
    use HasFactory,
        HasSlug;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'tenant_id',
        'status_id', //for later
        'is_active',
        'description',
        'logo',
        'sorting_order'
    ];

    // protected static function newFactory(): BrandFactory
    // {
    //     // return BrandFactory::new();
    // }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }


}
