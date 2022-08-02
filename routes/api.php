<?php

use App\Http\Controllers\GatewayController;
use App\Http\Controllers\MasterController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('master/')->group(function () {
    Route::post('from/gateway/store' ,[MasterController::class,'from_gateway_store']);
    Route::post('from/master/store' , [MasterController::class,'from_master_store']);
    // from portal to check the information
    Route::get('from/master/check' , [MasterController::class,'from_master_check']);
});




// the gateway node Regain
Route::prefix('gateway/')->group(function () {
    // receive request from master to check the hash
    Route::get('check/request' , [GatewayController::class,'index']);
    // receive request from master to store the hash
    Route::get('store/request' , [GatewayController::class,'store']);
    // receive request from master to store the hash
    Route::post('store/abbar/request' , [GatewayController::class,'store_abbar_request']);
    // receive request from local university and foreword it to master to publish it to all masters
    Route::get('local/request' ,[GatewayController::class,'send_master']);



    Route::post('test' ,[GatewayController::class,'store']);
});
