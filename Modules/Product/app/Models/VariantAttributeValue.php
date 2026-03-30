<?php

namespace Modules\Product\Models;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Product\Database\Factories\VariantAttributeValueFactory;

class VariantAttributeValue extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'product_variant_id',
        'attribute_id',
        'attribute_value_id',
    ];
}
