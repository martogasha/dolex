<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mik extends Model
{
        use HasFactory;
        protected $fillable = [
        'last_logout',
        'name',
        'cpu',
        'ram',
        'status',
        'statusOne',
        'ip',
        'user',
        'password'
        

    ];
}
