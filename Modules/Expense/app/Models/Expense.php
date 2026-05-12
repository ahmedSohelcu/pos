<?php

namespace Modules\Expense\App\Models;

use App\Models\Core\BaseModel;
use App\Models\Traits\HasStatus;
use App\Models\Traits\HasTenant;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Expense\Database\Factories\ExpenseFactory;

class Expense extends BaseModel
{
    use HasFactory,
        HasStatus,
        HasTenant;
    /*

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tenant_id',
        'expense_category_id',
        'amount',
        'expense_date',
        'reference',
        'note',
        'status_id',
        'attachment',
        'sorting_order',
    ];
}
