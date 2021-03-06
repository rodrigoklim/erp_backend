<?php

namespace App\Http\Controllers\Desktop;

use App\Http\Controllers\Controller;
use App\Services\PreSellService;
use Illuminate\Http\Request;

class PreSellController extends Controller
{
    public function createObservation(Request $request, PreSellService $preSellService)
    {
        $obs = $preSellService->handleObservationRegister($request->params);
        
        return $obs;
    }

    public function createPreSell(Request $request, PreSellService $preSellService)
    {
        $presell = $preSellService->handlePreSellRegister($request->params);

        return $presell;
    }
}
