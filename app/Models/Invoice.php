<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'quotation_id',
        'invoice_date',
        'payment_due',
        'amount',
        'time_difference',
        'current_time',
        'cash_id',
        'mpesa_id',
        'payment_id',
        'cash_amount',
        'mpesa_amount',
        'user_id',
        'usage_time',
        'balance',
        'status',
        'statas',
        'two_days_before',
        'two_days_before_status',
        'due_date_status',
        'one_day_before',
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
    public function payment(){
        return $this->belongsTo(Payment::class);
    }
}
