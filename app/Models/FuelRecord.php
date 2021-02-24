<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelRecord extends Model
{
    use HasFactory;

    /**
     * status = 0 - promise | 1 - certain
     */
    
    protected $fillable = [
        'vehicle_id', 'movement', 'balance', 'status', 'source', 'responsible', 'driver'
    ];
}
