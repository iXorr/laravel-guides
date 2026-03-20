<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'user_role_id',
        'login',
        'email',
        'first_name',
        'last_name',
        'middle_name',
        'phone',
        'password'
    ];

    public function role()
    {
        return $this->hasOne(UserRole::class, 'id', 'user_role_id');
    }
}
