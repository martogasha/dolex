<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mpesa extends Model
{
    use HasFactory;
    protected $fillable = [
        'ido',
        'topic',
        'created_at',
        'eventType',
        'resourceId',
        'status',
        'reference',
        'originationTime',
        'senderPhoneNumber',
        'amount',
        'currency',
        'tillNumber',
        'system',
        'senderFirstName',
        'senderMiddleName',
        'senderLastName',
        'linkSelf',
        'linkResource',
        'invoice_id',
        'invoice_balance',
        'currentMonth',
        'currentYear',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
