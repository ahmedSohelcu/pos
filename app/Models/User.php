<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Core\BaseModel;
use App\Models\Traits\HasStatus;
use App\Models\Traits\HasTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Modules\Subscription\app\Models\Subscription;
use Modules\Tenant\App\Models\Tenant;
use Spatie\Permission\Traits\HasRoles;

class User extends BaseModel
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory,
        HasRoles,
        HasStatus,
        HasTenant,
        Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
     protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'tenant_id', // important for multi-tenant
        'status_id'
    ];

    protected $guard_name = 'api';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }    
}
