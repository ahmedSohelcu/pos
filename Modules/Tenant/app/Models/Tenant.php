<?php

namespace Modules\Tenant\App\Models;

use App\Models\BaseModel;
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
    protected $fillable = [];

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
