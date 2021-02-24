<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id', 'brand_id', 'brand', 'specific_model_id', 'specific_model', 'value'
    ];
}
