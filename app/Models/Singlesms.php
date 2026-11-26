<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Singlesms extends Model
{
    use HasFactory;
        protected $fillable = [
        'user_id',
        'status',
        'message_status',
           

    ];
    public function user(){
       return $this->belongsTo(User::class);
    }
}
