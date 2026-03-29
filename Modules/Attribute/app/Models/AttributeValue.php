<?php

namespace Modules\Attribute\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Attribute\app\Models\Attribute;


class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'attribute_id',
        'value',
        'slug',
        'sorting_order',
        'is_active'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
