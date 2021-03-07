<?php

namespace App\Http\Controllers\Desktop;

use App\Http\Controllers\Controller;
use App\Services\RouteService;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function showRoutes(RouteService $routeService)
    {
        $routes = $routeService->handleRouteList();

        return $routes;
    }
}
