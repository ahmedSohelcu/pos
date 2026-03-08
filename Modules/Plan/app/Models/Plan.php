<?php

namespace Modules\Plan\App\Models;

use App\Models\Core\BaseModel;
use App\Models\Core\Status;
use App\Models\Traits\HasStatus;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Feature\app\Models\Feature;
use Modules\Feature\app\Models\PlanFeature;

// use Modules\Plan\Database\Factories\PlanFactory;

class Plan extends BaseModel
{
    use HasFactory,
        HasStatus,
        HasSlug;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'price',
        'currency',
        'billing_interval', //monthly, yearly
        'trial_days',
        'max_users',
        'max_products',
        'max_branches',
        'is_active',
        'description',
        'created_at',
        'updated_at',
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
