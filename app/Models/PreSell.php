<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreSell extends Model
{
    use HasFactory;

     /*
    authorization = 0 - awaiting
    authorization = 1 - auth
    authorization = 2 - canceled

    status = 0 - not on route
    status = 1 - on route
    status = 2 - super auth
    */

    protected $fillable =[
        'c_id', 'invoice_option', 'status', 'zone', 'delivery_period', 'delivery_address', 'delivery_date', 'invoice_obs',
        'driver_obs', 'pay_code', 'pay_term', 'pay_contract', 'pay_commitment_number', 'authorization'
    ];
    
    public function setZoneAttribute($value)
    {
        $this->attributes['zone'] = strtoupper($value);
    }
    
    public function setDeliveryPeriodAttribute($value)
    {
        $this->attributes['delivery_period'] = strtoupper($value);
    }

    public function setInvoiceObsAttribute($value)
    {
        $this->attributes['invoice_obs'] = strtoupper($value);
    }

    public function setDriverObsAttribute($value)
    {
        $this->attributes['driver_obs'] = strtoupper($value);
    }

    public function costumer()
    {
        $costumer = $this->belongsTo(NaturalPerson::class, 'c_id', 'c_id');

        if($costumer->count === 0){
            $costumer = $this->belongsTo(LegalEntity::class, 'c_id', 'c_id');
        }

        return $costumer;
    }

    public function products()
    {
        return $this->hasMany(PreSellProduct::class, 'presell_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany(PreSellMessageCenter::class, 'presell_id', 'id');
    }
}
