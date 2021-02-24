<?php

namespace App\Services;

use App\Models\Vehicle;
use App\Models\VehicleLoad;
use App\Models\VehicleValue;
use Carbon\Carbon;

class VehiclesService
{
    public function handleNewVehicleRegister($data)
    {
        $vehicle = new Vehicle();

        $vehicle->type                  = $data['type'];
        $vehicle->nickname              = $data['nickname'];
        $vehicle->fuel                  = $data['fuel'];
        $vehicle->license_plate         = $data['licensePlate'];
        $vehicle->autonomy              = $data['autonomy'];
        $vehicle->fuel_tank             = $data['fuelTank'];
        $vehicle->km_cost               = clearMoneyMask($data['kmCost']);
        $vehicle->oil_change            = Carbon::createFromFormat('d/m/Y', $data['oilChange']);
        $vehicle->filters_change        = Carbon::createFromFormat('d/m/Y', $data['filterChange']);

        if($data['toothedBelt'] !== null){
            $vehicle->toothed_belt_change   = Carbon::createFromFormat('d/m/Y', $data['toothedBelt']);
        }

        $vehicle->civ                   = Carbon::createFromFormat('d/m/Y', $data['civ']);
        $vehicle->cipp                  = Carbon::createFromFormat('d/m/Y', $data['cipp']);
        $vehicle->valvules              = Carbon::createFromFormat('d/m/Y', $data['valvule']);
        $vehicle->ibama                 = Carbon::createFromFormat('d/m/Y', $data['ibama']);
        $vehicle->tachograph            = Carbon::createFromFormat('d/m/Y', $data['tachograph']);
        $vehicle->km_zero               = $data['initialKm'];

        $vehicle->save();

        if($vehicle->id){

            $vehicleLoad    = $this->handleVehicleLoadRegister($data, $vehicle->id);
            $vehicleValue   = $this->handleVehicleValueRegister($data, $vehicle->id);

            return 'ok';

        } else {
            
            return 'error';
        }
        
    }

    public function handleEditVehicleRegister($data)
    {
        $vehicle = Vehicle::find($data['id']);
       
        if($vehicle->count() > 0){

            $vehicle->autonomy              = $data['autonomy'];
            $vehicle->km_cost               = clearMoneyMask($data['km_cost']);
            $vehicle->oil_change            = Carbon::createFromFormat('d/m/Y', $data['oil_change']);
            $vehicle->filters_change        = Carbon::createFromFormat('d/m/Y', $data['filters_change']);
    
            if($data['toothed_belt_change'] !== null){
                $vehicle->toothed_belt_change   = Carbon::createFromFormat('d/m/Y', $data['toothed_belt_change']);
            }
    
            $vehicle->civ                   = Carbon::createFromFormat('d/m/Y', $data['civ']);
            $vehicle->cipp                  = Carbon::createFromFormat('d/m/Y', $data['cipp']);
            $vehicle->valvules              = Carbon::createFromFormat('d/m/Y', $data['valvules']);
            $vehicle->ibama                 = Carbon::createFromFormat('d/m/Y', $data['ibama']);
            $vehicle->tachograph            = Carbon::createFromFormat('d/m/Y', $data['tachograph']);
            $vehicle->km_zero               = $data['km_zero'];
    
            $vehicle->save();
            
            return 'ok';
            
        } else {

            return 'error';

        }
    }

    private function handleVehicleLoadRegister($data, $id)
    {
        $vehicleLoad = new VehicleLoad();

        $vehicleLoad->vehicle_id        = $id;
        $vehicleLoad->category          = $data['load_category'];
        $vehicleLoad->classification    = $data['load_classification'];
        $vehicleLoad->unity             = $data['load_unity'];
        $vehicleLoad->load_capacity     = $data['load_capacity'];
        $vehicleLoad->load_code         = $this->handleLoadCode($data);

        $vehicleLoad->save();

        return 'ok';
    }

    private function handleLoadCode($data)
    {
       
        switch ($data['load_category']){
            case 'granel':
            $load = "1";
            break;
            case 'fracionado':
            $load = "2";
            break;
        }
        
        switch ($data['load_classification']){
            case 'gas':
            $load = $load . "1";
            break;
            case 'liquido':
            $load = $load . "2";
            break;
            case 'embalagem':
            $load = $load . "3";
            break;
            case 'equipamento':
            $load = $load . "4";
            break;
        
        }
        
        switch ($data['load_unity']){
            case 'litros':
            $load = $load . "1";
            break;
            case 'quilos':
            $load = $load . "2";
            break;
            case 'm3':
            $load = $load . "3";
            break;
            case 'carga':
            $load = $load . "4";
            break;
            case 'unidade':
            $load = $load . "5";
            break;
        }
        
        if($load > 110 && $load < 120){
            $load_code = 'CT1';
        } else if($load > 120 && $load < 200){
            $load_code = 'CT2';
        } else if($load > 200){
            $load_code = 'CF2';
        }
        
        return $load_code;
          
    }

    private function handleVehicleValueRegister($data, $id)
    {
        $vehicleValue = new VehicleValue();

        $vehicleValue->vehicle_id           = $id;
        $vehicleValue->brand_id             = $data['brand']['id'];
        $vehicleValue->brand                = $data['brand']['name'];
        $vehicleValue->specific_model_id    = $data['vehicle']['id'];
        $vehicleValue->specific_model       = $data['vehicle']['name'];
        $vehicleValue->value                = clearMoneyMask($data['vehicle']['preco']);
        
        $vehicleValue->save();

        return $vehicleValue;
    }
}