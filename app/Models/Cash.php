<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'amount',
        'invoice_id',
        'invoice_balance',
        'reason',
        'date',
        'status',
        'currentMonth',
        'currentYear',

    ];
    public function user(){
       return $this->belongsTo(User::class);
    }
    public function invoice(){
       return $this->belongsTo(Invoice::class);
    }
}
