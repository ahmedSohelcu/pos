<?php

namespace Modules\Unit\App\Models;

use App\Models\Core\BaseModel;
use App\Models\Core\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Tenant\app\Models\Tenant;

// use Modules\Unit\Database\Factories\UnitFactory;

class Unit extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'tenant_id',
        'status_id',//for later uses
        'is_active',
        'sorting_order',
        'short_name'
    ];

    // protected static function newFactory(): UnitFactory
    // {
    //     // return UnitFactory::new();
    // }

    /**
     * Get the tenant associated with the unit.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
