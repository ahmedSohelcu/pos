<?php

namespace Modules\Role\App\Models;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Role\Database\Factories\RoleFactory;

class Role extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'guard_name',
        'tenant_id',
    ];

    // protected static function newFactory(): RoleFactory
    // {
    //     // return RoleFactory::new();
    // }
}
