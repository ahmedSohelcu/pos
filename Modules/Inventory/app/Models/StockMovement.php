<?php

namespace Modules\Inventory\App\Models;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\App\Models\ProductVariant;

class StockMovement extends BaseModel
{
    use HasFactory;

    public const TYPES = ['purchase', 'sale', 'adjustment', 'return', 'damage', 'opening'];

    protected $fillable = [
        'tenant_id',
        'product_variant_id',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'reference_type',
        'reference_id',
        'user_id',
        'note',
    ];

    protected $casts = [
        'quantity' => 'float',
        'stock_before' => 'float',
        'stock_after' => 'float',
    ];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
