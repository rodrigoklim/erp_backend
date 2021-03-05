<?php

use App\Http\Controllers\Desktop\CostumerController;
use App\Http\Controllers\Desktop\ProductController;
use App\Http\Controllers\Desktop\TaskController;
use App\Http\Controllers\Desktop\UserController;
use App\Http\Controllers\Desktop\VehiclesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => 'auth:sanctum'], function(){
    // Task
    Route::get('/task/new',[TaskController::class, 'newTask']);
    Route::get('/task/show',[TaskController::class, 'showTasks']);
    Route::get('/task/end',[TaskController::class, 'endTask']);
    
    // Products
    Route::get('/products/show',[ProductController::class, 'showProducts']);
    Route::post('/product/create',[ProductController::class, 'createProduct']);
    Route::post('/product/edit',[ProductController::class, 'editProduct']);
    Route::get('/ncm/list',[ProductController::class, 'listNcm']);

    // Vehicles
    Route::post('/vehicle/create',[VehiclesController::class, 'createVehicle']);
    Route::get('/vehicle/show',[VehiclesController::class, 'showVehicles']);
    Route::post('/vehicle/edit',[VehiclesController::class, 'editVehicle']);

    // Costumer
    Route::get('/costumer/show',[CostumerController::class, 'listAllCostumers']);
    Route::get('/costumer/verify',[CostumerController::class, 'verifyCostumer']);
    Route::post('/costumer/edit',[CostumerController::class, 'editCostumer']);    
    Route::post('/costumer/le/create',[CostumerController::class, 'createLegalEntity']);
    Route::post('/costumer/np/create',[CostumerController::class, 'createNaturalPerson']);
    Route::get('/costumer/le/list',[CostumerController::class, 'listLegalEntities']);
    Route::post('costumer/payment/', [CostumerController::class, 'paymentDefinition']);
    });

Route::post('/login',[UserController::class, 'login']);
