<?php

namespace Modules\Register\App\Models;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Modules\Sales\App\Models\Sale;

class RegisterShift extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'register_name',
        'opening_float',
        'closing_counted',
        'expected_cash',
        'difference',
        'status',
        'opened_at',
        'closed_at',
        'note',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'opening_float' => 'float',
        'closing_counted' => 'float',
        'expected_cash' => 'float',
        'difference' => 'float',
    ];

    public function cashier()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function movements()
    {
        return $this->hasMany(RegisterCashMovement::class, 'shift_id')->latest();
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'shift_id');
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }
}
