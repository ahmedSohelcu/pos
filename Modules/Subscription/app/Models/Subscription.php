<?php

namespace Modules\Subscription\App\Models;

use App\Models\Core\BaseModel;
use App\Models\Core\Status;
use App\Models\Traits\HasStatus;
use App\Models\Traits\HasTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Plan\app\Models\Plan;


class Subscription extends BaseModel
{
    use HasFactory,
        HasTenant,
        HasStatus;

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    //used in Subscription middleware 
    const STATUS_TRIAL = 4;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tenant_id',
        'plan_id',
        'starts_at',
        'ends_at',
        'is_trial',
        'status_id',
        'is_current',
    ];

    public function plan(){
        return $this->belongsTo(Plan::class, 'plan_id');
    }


    // protected static function newFactory(): SubscriptionFactory
    // {
    //     // return SubscriptionFactory::new();
    // }
}
