<?php

namespace App\Models;

use App\Filters\FilterBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
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

    public function scopeFilters($query, FilterBuilder $filter): Builder
    {
        return $filter->apply($query);
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
