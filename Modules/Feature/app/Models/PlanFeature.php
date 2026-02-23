<?php

namespace Modules\Feature\App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Plan\App\Models\Plan;
use Modules\Feature\App\Models\Feature;

class PlanFeature extends Pivot
{
    protected $table = 'plan_features';

    protected $fillable = [
        'plan_id',
        'feature_id',
        'is_enabled',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}