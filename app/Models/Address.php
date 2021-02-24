<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
       'c_id' , 'street', 'complement', 'number', 'district', 'zip_code', 'city', 
       'city_code', 'state', 'zone','preference_period', 'latitude', 'longitude'
    ];

    public function costumerLe()
    {
        return $this->belongsTo(LegalEntity::class, 'c_id', 'c_id');
    }

    public function costumerNp()
    {
        return $this->belongsTo('NaturalPerson', 'c_id');
    }

}
