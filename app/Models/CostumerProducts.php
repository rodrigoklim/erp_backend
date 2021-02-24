<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostumerProducts extends Model
{
    use HasFactory;

    protected $fillable = [
        'c_id', 'products_id', 'price', 'interval', 'exact_day'
    ];
}
