<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotlogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'end_date',
        'reason',
        'hotspot_id',
        'amount',
        'status',
  
        

    ];
    
    public function hotspot(){
       return $this->belongsTo(Hotspot::class);
    }
}
