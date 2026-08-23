<?php

namespace Modules\Sales\App\Models;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Sales\App\Models\Sale;

class SaleItem extends BaseModel
{
    use HasFactory;

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    protected $fillable = [
        'sale_id',
        'product_variant_id',
        'product_name',
        'variant_name',
        'sku',
        'quantity',
        'unit_price',
        'cost_price',
        'total',
    ];

    protected $casts = [
        'quantity' => 'float',
        'unit_price' => 'float',
        'cost_price' => 'float',
        'total' => 'float',
    ];
}
