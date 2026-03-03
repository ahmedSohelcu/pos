<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Core\BaseModel;
use App\Models\Traits\HasTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Modules\Tenant\App\Models\Tenant;
use Spatie\Permission\Traits\HasRoles;

class User extends BaseModel
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory,
        HasRoles,
        Notifiable,
        HasTenant;

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


    // Optional: Global scope by tenant
    protected static function booted()
    {
        static::addGlobalScope('tenant', function ($query) {
            if (auth()->check()) {
                $query->where('tenant_id', auth()->user()->tenant_id);
            }
        });
    }


    
}
