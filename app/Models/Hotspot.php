<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotspot extends Model
{
    use HasFactory;
        protected $fillable = [
        'mac',
        'ip',
        'phone',
        'amount',
        'status',
        'status_one',
        'start_date',
        'end_date',
    ];
}
