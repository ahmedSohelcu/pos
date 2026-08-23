<?php

namespace Modules\Sales\App\Models;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Customer\App\Models\Customer;
use App\Models\User;

class Sale extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'tenant_id',
        'customer_id',
        'user_id',
        'shift_id',
        'subtotal',
        'discount_type',
        'discount_value',
        'discount_amount',
        'total',
        'payment_method',
        'amount_tendered',
        'change_due',
        'status',
        'refunded_at',
        'note',
    ];

    protected $casts = [
        'refunded_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
