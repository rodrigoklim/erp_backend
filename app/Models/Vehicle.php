<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'nickname', 'fuel', 'license_plate', 'autonomy', 'fuel_tank', 'km_cost', 'oil_change', 'filters_change', 
        'toothed_belt_change', 'civ', 'cipp', 'valvules', 'ctf', 'ibama', 'tachograph', 'km_zero'
    ];

    // Relationships

    public function vehicleLoad()
    {
        return $this->hasOne(VehicleLoad::class,'vehicle_id', 'id');
    }

    public function vehicleValue()
    {
        return $this->hasOne(VehicleValue::class, 'vehicle_id', 'id');
    }

    public function FuelRecord()
    {
        return $this->hasOne(FuelRecord::class,'vehicle_id', 'id');
    }

    public function LoadRecord()
    {
        return $this->hasOne(LoadRecord::class,'vehicle_id', 'id');
    }

    // Acessors
    public function getOilChangeAttribute($value)
    {
        return Carbon::create($value)->format('d/m/Y');
    }

    public function getFiltersChangeAttribute($value)
    {
        return Carbon::create($value)->format('d/m/Y');
    }
    
    public function getToothedBeltChangeAttribute($value)
    {
        return Carbon::create($value)->format('d/m/Y');
    }
    
    public function getCivAttribute($value)
    {
        return Carbon::create($value)->format('d/m/Y');
    }
    
    public function getCippAttribute($value)
    {
        return Carbon::create($value)->format('d/m/Y');
    }

    public function getValvulesAttribute($value)
    {
        return Carbon::create($value)->format('d/m/Y');
    }

    public function getCtfAttribute($value)
    {
        return Carbon::create($value)->format('d/m/Y');
    }
    
    public function getIbamaAttribute($value)
    {
        return Carbon::create($value)->format('d/m/Y');
    }

    public function getTachographAttribute($value)
    {
        return Carbon::create($value)->format('d/m/Y');
    }
}
