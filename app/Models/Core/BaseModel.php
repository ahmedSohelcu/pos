<?php

namespace App\Models\Core;

use App\Filters\FilterBuilder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Authenticatable
{
    // use SoftDeletes;

    // protected $guarded = [];
    // protected $casts = [
    //     'is_active' => 'boolean',
    // ];

    public function scopeSearch($query, $value)
    {
        return $query->where('name', 'like', '%' . $value . '%');
    }

    // Scope for active records
    public function scopeActive($query, $value = true)
    {
        return $query->where('is_active', $value);
    }

    public function scopeFilters($query, $filter)
    {
        if (is_array($filter)) {
            $filter = new FilterBuilder($filter); // or your base filter
        }

        if (!$filter instanceof FilterBuilder) {
            throw new \InvalidArgumentException("Filters must be a FilterBuilder instance or array.");
        }

        return $filter->apply($query);
    }

    public function scopeSort($query)
    {
        return $query->orderBy(request('sort_column', 'id'), request('sort_direction', 'asc'));
    }

    // Optional: format price helper
    // public function formatPrice($field = 'price')
    // {
    //     return number_format($this->{$field}, 2);
    // }

    // Auto set created_by and updated_by if columns exist
    // protected static function booted()
    // {
    //     static::creating(function ($model) {
    //         if (auth()->check() && $model->isFillable('created_by')) {
    //             $model->created_by = auth()->id();
    //         }
    //     });

    //     static::updating(function ($model) {
    //         if (auth()->check() && $model->isFillable('updated_by')) {
    //             $model->updated_by = auth()->id();
    //         }
    //     });
    // }


    //    public function createdRules()
//    {
//        return [
//            //
//        ];
//    }
//
//    public function updatedRules()
//    {
//        return $this->createdRules();
//    }
}


// Exaple of usage:
// $query->filter(new CustomerFilter(['customer_code' => '1234']));
// $customers = Customer::filters($filter)
//                      ->active()
//                      ->orderBy('customer_code')
//                      ->get();
