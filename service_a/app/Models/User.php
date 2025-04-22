<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['name', 'email', 'role', 'password'];

}
