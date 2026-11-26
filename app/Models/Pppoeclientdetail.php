<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pppoeclientdetail extends Model
{
    use HasFactory;
        protected $fillable = [
        'user_id',
        'status',
        'uptime',
        'ip_address',
        'last_logged_out',
        'statusOne',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
