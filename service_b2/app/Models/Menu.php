<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;  // Pastikan ini ada
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory;  // Pastikan ini ada

    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['name', 'description', 'type', 'price', 'photo'];

}

