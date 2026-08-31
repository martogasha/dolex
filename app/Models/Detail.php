<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;
        protected $fillable = [
        'last_logout',
        'uptime',
        'bytes_in',
        'bytes_out',
        'user_id',
        'status',
    ];
}
