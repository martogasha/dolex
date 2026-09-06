<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pulltransaction extends Model
{
    use HasFactory;
        protected $fillable = [
        'transactionId',
        'trxDate',
        'msisdn',
        'sender',
        'transactiontype',
        'billreference',
        'amount',
        'organizationname',
    ];
}
