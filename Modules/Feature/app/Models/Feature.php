<?php

namespace Modules\Feature\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Plan\App\Models\Plan;
use Modules\Feature\App\Models\PlanFeature;

// use Modules\Feature\Database\Factories\FeatureFactory;

class Feature extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    
    protected $fillable = [
        'name', 'label','is_active', 'description', 'sorting_order'
    ];

    // protected static function newFactory(): FeatureFactory
    // {
    //     // return FeatureFactory::new();
    // }

    public function plans()
    {
        return $this->belongsToMany(
            Plan::class,
            'plan_features')
            ->using(PlanFeature::class)
            ->withPivot('is_enabled')
            ->withTimestamps();
    }



    /**
     * Plans that include this feature
     */
    // public function plans()
    // {
    //     return $this->belongsToMany(
    //         \Modules\Plan\App\Models\Plan::class,
    //         'plan_features'
    //     )->withPivot('is_enabled')->withTimestamps();
    // }
}
