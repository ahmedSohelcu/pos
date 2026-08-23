<?php

namespace Modules\Register\App\Models;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RegisterCashMovement extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'shift_id',
        'type',
        'amount',
        'reason',
        'user_id',
    ];

    protected $casts = [
        'amount' => 'float',
    ];
}
