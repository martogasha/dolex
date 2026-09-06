<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'estimate_date',
        'expiry_date',
        'current_date',
        'time_difference',
        'status',
        'statas',
    ];
}
