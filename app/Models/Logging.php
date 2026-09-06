<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logging extends Model
{
    use HasFactory;
        protected $fillable = [
        'date',
        'reason',
        'user_id',
        'amount',
        'status',
        'name',
        'password',
        'account',
        'phone_number',
        'package',
        'package_amount',
        'current_balance',
        'add_balance',
        'payment_date',
        'due_date',
        'duplicate_id',
        

    ];
    
    public function user(){
       return $this->belongsTo(User::class);
    }
      public function mik(){
        return $this->belongsTo(Mik::class);
    }
}
