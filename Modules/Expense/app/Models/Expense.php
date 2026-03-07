<?php

namespace Modules\Expense\App\Models;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Expense\Database\Factories\ExpenseFactory;

class Expense extends BaseModel
{
    use HasFactory;

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
        'attachment',
        'created_by',
        'updated_by'
    ];

            // 'pending','approved','rejected','draft'

    // protected static function newFactory(): ExpenseFactory
    // {
    //     // return ExpenseFactory::new();
    // }
}
