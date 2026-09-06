<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'quotation_id',
        'invoice_date',
        'payment_due',
        'amount',
        'time_difference',
        'current_time',
        'cash_id',
        'cash_amount',
        'mpesa_amount',
        'user_id',
        'usage_time',
        'balance',
        'status',
        'statas',
    ];
    public function quotation(){
        return $this->belongsTo(Quotation::class);
    }
    public function cash(){
        return $this->belongsTo(Cash::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
