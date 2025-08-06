<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use \Illuminate\Auth\Authenticatable;
    protected $fillable = [
        'email',
        'name',
        'avatar',
        'password',
    ];
}
