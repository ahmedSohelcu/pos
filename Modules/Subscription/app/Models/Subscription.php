<?php

namespace Modules\Subscription\App\Models;

use App\Models\Core\BaseModel;
use App\Models\Core\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Subscription\Database\Factories\SubscriptionFactory;

class Subscription extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tenant_id',
        'plan_id',
        'start_date',
        'end_date',
        'status',
        'status_id', //later implemet 
        'is_current',
    ];

     public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }


    // protected static function newFactory(): SubscriptionFactory
    // {
    //     // return SubscriptionFactory::new();
    // }
}
