<?php

namespace Modules\Tenant\App\Models;

use App\Models\Core\BaseModel;
use App\Models\Core\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Subscription\app\Models\Subscription;

// use Modules\Tenant\Database\Factories\TenantFactory;

class Tenant extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'subdomain',
        'phone',
        'address',
        'city',
        'country',
        'created_by',
        'status_id',
        'sorting_order'
    ];

    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }

    // protected static function newFactory(): TenantFactory
    // {
    //     // return TenantFactory::new();
    // }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function currentSubscription()
    {
        return $this->hasOne(Subscription::class)
                    ->where('is_current', true);
    }
}
