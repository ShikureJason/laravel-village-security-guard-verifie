<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerfieTokens extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_log_id', 
        'user_id',
        'token',
        'verified',
    ];
}
