<?php

namespace Modules\Product\App\Models;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\app\Models\VariantAttributeValue;
// use Modules\Product\Database\Factories\ProductVariantFactory;

class ProductVariant extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'product_id',
        'tenant_id',
        'sku',
        'barcode',
        'purchase_price',
        'sale_price',
        'stock',
        'thumbnail',
        'status_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(VariantAttributeValue::class);
    }

    public function attributes()
    {
        return $this->hasMany(VariantAttributeValue::class);
    }
}
