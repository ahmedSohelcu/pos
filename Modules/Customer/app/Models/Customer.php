<?php

namespace Modules\Customer\App\Models;

use App\Models\Core\BaseModel;
use App\Models\Traits\HasStatus;
use App\Models\Traits\HasUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Customer\Database\Factories\CustomerFactory;

class Customer extends BaseModel
{
    use HasFactory,
        HasStatus,
        HasUser;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'code',
        'profile_pic',
        'created_by',
        'opening_balance',
        'current_balance',
        'loyalty_points',
        'is_walkin',

        'address',
        'city',
        'state',
        'country',
        'zip_code',

        'status_id',
        'sorting_order',
    ];

    // protected static function newFactory(): CustomerFactory
    // {
    //     // return CustomerFactory::new();
    // }
}
