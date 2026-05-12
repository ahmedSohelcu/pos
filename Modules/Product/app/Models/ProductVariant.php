<?php

namespace Modules\Product\Models;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Product\Database\Factories\ProductVariantFactory;

class ProductVariant extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_id',
        'sku',
        'barcode',
        'cost_price',
        'sale_price',
        'stock',
    ];
}
