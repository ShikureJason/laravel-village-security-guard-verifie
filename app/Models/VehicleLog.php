<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_id', 
        'check_out',
        'check_in',
        'user_id',
    ];
}
