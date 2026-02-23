<?php

namespace Modules\Plan\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Feature\App\Models\Feature;
use Modules\Feature\App\Models\PlanFeature;

// use Modules\Plan\Database\Factories\PlanFactory;

class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [

    ];

    public function features()
    {
        return $this->belongsToMany(Feature::class,'plan_features')
            ->using(PlanFeature::class)
            ->withPivot('is_enabled')
            ->withTimestamps();
    }

    // protected static function newFactory(): PlanFactory
    // {
    //     // return PlanFactory::new();
    // }

    // protected $appends = ['feature_count'];

    // public function features()
    // {
    //     return $this->belongsToMany(\Modules\Feature\App\Models\Feature::class, 'plan_features')
    //                 ->withPivot('is_enabled')->withTimestamps();
    // }

    // public function getFeatureCountAttribute()
    // {
    //     return $this->features->where('is_enabled', true)->count();
    // }
}
