<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreSellProduct extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'presell_id', 'product_id', 'product_qty', 'product_price'
    ];

    public function productDetails()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

    public function preSell()
    {
        return $this->belongsTo(PreSell::class, 'presell_id', 'id');
    }

    
}
