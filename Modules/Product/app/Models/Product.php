<?php

namespace Modules\Product\App\Models;

use App\Models\Core\BaseModel;
use App\Models\Core\Media;
use App\Traits\HasSlug;
use App\Models\Traits\HasStatus;
use App\Models\Traits\HasTenant;
use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\app\Models\ProductVariant;
use Modules\Product\app\Models\VariantAttributeValue;

// use Modules\Product\Database\Factories\ProductFactory;

class Product extends BaseModel
{
    use HasFactory,
        HasSlug,
        HasStatus,
        HasTenant,
        HasUserTracking //for created_by and updated_by
        ;

    protected $casts = [
        'track_stock' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'tenant_id', // important for multi-tenant
        'product_type',
        'brand_id',
        'category_id',
        'unit_id',
        'sku',
        'barcode',
        'purchase_price',
        'sale_price',
        'stock',        
        'track_stock',
        'alert_quantity',
        'description',
        'thumbnail',
        'status_id', //for late uses
        'is_active',
        'sorting_order',
        'created_by',
        'updated_by',
    ];


    public function variants()
    {
        return $this->hasMany(ProductVariant::class);        
    }    

    public function variantAttributes()
    {
        return $this->hasManyThrough(
            VariantAttributeValue::class,
            ProductVariant::class,
            'product_id',
            'product_variant_id'
        );
    }

    public function category()
    {
        return $this->belongsTo(\Modules\Category\App\Models\Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(\Modules\Brand\app\Models\Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(\Modules\Unit\app\Models\Unit::class);
    }

    public function getThumbnailAttribute($value)
    {
        if (!$value) return null;

        return \Illuminate\Support\Facades\Storage::disk('public')->url($value);
    }    

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}