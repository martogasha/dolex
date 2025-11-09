<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qproduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'quantity',
        'amount',
        'total',
        'quotation_id',
        'invoice_id',
    ];
    public function quotation(){
        return $this->belongsTo(Quotation::class);
    }
}
