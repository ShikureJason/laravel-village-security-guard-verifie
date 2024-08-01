<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleBrands extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_type_id',
    ];
}
