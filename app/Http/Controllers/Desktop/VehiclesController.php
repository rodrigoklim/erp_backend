<?php

namespace App\Http\Controllers\Desktop;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Services\VehiclesService;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{
    public function createVehicle(Request $request, VehiclesService $vehiclesService)
    {
        $vehicle = $vehiclesService->handleNewVehicleRegister($request->params['form']);

        return 'ok';
    }

    public function showVehicles(Request $request)
    {
        $vehicles = Vehicle::all();

        return $vehicles[0]->with(['vehicleLoad', 'vehicleValue'])->get();
    }

    public function editVehicle(Request $request, VehiclesService $vehiclesService)
    {
        $vehicle = $vehiclesService->handleEditVehicleRegister($request->params['e']);

        return $vehicle;
    }
}
