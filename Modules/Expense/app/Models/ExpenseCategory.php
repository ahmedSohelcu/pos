<?php

namespace Modules\Expense\App\Models;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Expense\Database\Factories\ExpenseCategoryFactory;

class ExpenseCategory extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): ExpenseCategoryFactory
    // {
    //     // return ExpenseCategoryFactory::new();
    // }
}
