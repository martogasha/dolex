<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mikrotik extends Model
{
      use HasFactory;
        protected $fillable = [
        'last_logout',
        'name',
        'cpu',
        'ram',
        'status',
        'statusOne',
        

    ];
}
