<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderObservation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'c_id', 'title', 'destination', 'observation'
    ];
}
