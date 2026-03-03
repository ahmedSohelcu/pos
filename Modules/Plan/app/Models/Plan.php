<?php

namespace Modules\Plan\App\Models;

use App\Models\Core\BaseModel;
use App\Models\Core\Status;
use App\Models\Traits\HasStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Feature\App\Models\Feature;
use Modules\Feature\App\Models\PlanFeature;

// use Modules\Plan\Database\Factories\PlanFactory;

class Plan extends BaseModel
{
    use HasFactory,
        HasStatus;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'price',
        'currency',
        'billing_interval',
        'billing_duration',
        'trial_days',
        'max_users',
        'max_products',
        'max_branches',
        'is_active',
        'description',
        'sorting_order',
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
