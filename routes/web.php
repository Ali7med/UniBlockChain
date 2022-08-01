<?php

use App\Http\Controllers\BlockChainController;
use App\Http\Controllers\EcdsaController;
use App\Http\Controllers\FinalSheetController;
use App\Http\Controllers\GatewayController;
use App\Http\Controllers\MasterController;
use App\Models\FinalSheet;
use App\Models\Gateway;
use App\Models\Master;
use App\Models\GatewayDataAllStage;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Promise\Utils;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/ecdsa', [EcdsaController::class,'make']);

Route::get('/dashboard', [FinalSheetController::class,'index'])->middleware(['auth'])->name('dashboard');
Route::prefix('/Algorithm')->group(function () {
    Route::get('/Phase1', [BlockChainController::class,'index_phase1'])->middleware(['auth'])->name('phase1.index');
    Route::get('/Phase2', [BlockChainController::class,'index_phase2'])->middleware(['auth'])->name('phase2.index');
    Route::get('/Phase1/store', [BlockChainController::class,'store_phase1'])->middleware(['auth'])->name('phase1.store');
    Route::get('/Phase2/store', [BlockChainController::class,'store_phase2'])->middleware(['auth'])->name('phase2.store');
    Route::get('/send/gateway', [BlockChainController::class,'send_gateway'])->middleware(['auth'])->name('send_gateway');
    Route::get('/form', [BlockChainController::class, 'form'])->name('form');
    Route::get('/formTranScript', [BlockChainController::class, 'formTranScript'])->name('formTranScript');
});
Route::prefix('/master')->group(function () {
    Route::get('/check/view', [MasterController::class,'master_check_view'])->middleware(['auth'])->name('master.check.view');
    Route::post('/check', [MasterController::class,'master_check'])->middleware(['auth'])->name('master.check');

});



Route::get('/index1', [BlockChainController::class,'index1']);

// Route::get('to/master/send/request' ,  function(){

//     // $responses = Http::pool(fn (Pool $pool) => [
//     //     $pool->as('index1')->timeout(1)->async()->get('http://127.0.0.1:8000/index1')->then(
//     //         fn (Response|TransferException $result) => $this->handleResult($result)
//     //     ),
//     //     $pool->as('foo')->timeout(3)->async()->get('https://httpbin.org/delay/2')->then(

//     //     ),
//     //     $pool->as('bar')->timeout(1)->async()->get('https://httpbin.org/delay/3')->then(

//     //     ),
//     //     $pool->as('baz')->timeout(1)->async()->get('https://httpbin.org/delay/3')->then(

//     //     ),
//     //     $pool->as('google')->timeout(1)->async()->get('https://google.com')->then(

//     //     ),
//     // ]);
//     $promises_master = [];
//     $masters=Master::all();
//     foreach( $masters as $master){
//         $promises_master[] = Http::async()->get($master->url);
//     }
//     // $promises = [];
//     // $promises[] = Http::async()->get('http://localhost/UniBlockChain/public/index1');
//     // $promises[] = Http::async()->timeout(2)->get('https://httpbin.org/delay/5');

//     // Wait for the responses to be received
//     //$responses = Utils::unwrap($promises);
//     $responses_master = Utils::unwrap($promises_master);

//     //;
//     //$responses['bar']->successful();

//     //dd($responses[1]->body());
//     dd($responses_master);
//  return true ;
// }
// );


// the Master Regain

// receive request from any ware to store


require __DIR__.'/auth.php';
