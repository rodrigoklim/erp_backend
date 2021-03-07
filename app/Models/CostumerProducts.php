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

    public function costumerNp()
    {
        return $this->belongsTo(NaturalPerson::class, 'c_id', 'c_id');
    }

    public function costumerLe()
    {
        return $this->belongsTo(LegalEntity::class, 'c_id','c_id');
    }
}
