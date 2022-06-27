<?php

use App\Http\Controllers\BlockChainController;
use App\Http\Controllers\EcdsaController;
use App\Http\Controllers\FinalSheetController;
use App\Models\FinalSheet;
use App\Models\MasterGatewayPoint;
use App\Models\MasterPoint;
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
    Route::get('/form', [BlockChainController::class, 'form'])->name('form');
    Route::get('/formTranScript', [BlockChainController::class, 'formTranScript'])->name('formTranScript');
});




Route::get('/index1', [BlockChainController::class,'index1']);

Route::get('to/master/send/request' ,  function(){

    // $responses = Http::pool(fn (Pool $pool) => [
    //     $pool->as('index1')->timeout(1)->async()->get('http://127.0.0.1:8000/index1')->then(
    //         fn (Response|TransferException $result) => $this->handleResult($result)
    //     ),
    //     $pool->as('foo')->timeout(3)->async()->get('https://httpbin.org/delay/2')->then(

    //     ),
    //     $pool->as('bar')->timeout(1)->async()->get('https://httpbin.org/delay/3')->then(

    //     ),
    //     $pool->as('baz')->timeout(1)->async()->get('https://httpbin.org/delay/3')->then(

    //     ),
    //     $pool->as('google')->timeout(1)->async()->get('https://google.com')->then(

    //     ),
    // ]);
    $promises_master = [];
    $masters=MasterPoint::all();
    foreach( $masters as $master){
        $promises_master[] = Http::async()->get($master->url);
    }
    // $promises = [];
    // $promises[] = Http::async()->get('http://localhost/UniBlockChain/public/index1');
    // $promises[] = Http::async()->timeout(2)->get('https://httpbin.org/delay/5');

    // Wait for the responses to be received
    //$responses = Utils::unwrap($promises);
    $responses_master = Utils::unwrap($promises_master);

    //;
    //$responses['bar']->successful();

    //dd($responses[1]->body());
    dd($responses_master);
 return true ;
}
);



// here I'm master
Route::prefix('to/master/')->group(function () {
    Route::get('masters/request' ,  function(Request $request){
        // first step send to all master nodes
        $promises_master = [];
        $masters=MasterPoint::all();
        foreach ($masters as $master) {
            $promises_master[] = Http::async()->get($master->url+"/to/master/node/request",[
                'id' => $request->id
            ]);
        }
        $responses_master = Utils::unwrap($promises_master);
        // dd($responses_master);
        // return true ;

        // //second step send to all local node (gateways)
        // $promises_node = [];
        // $points=MasterGatewayPoint::all();
        // foreach ($points as $point) {
        //     $promises_node[] = Http::async()->get($point->url);
        // }
        // $responses_node = Utils::unwrap($promises_node);
        // dd($responses_node);
        return true ;
    }
    );
    Route::get('nodes/request' ,  function(Request $request){
        //first step send to all local node (gateways)
        $promises_node = [];
        $points=MasterGatewayPoint::all();
        foreach ($points as $point) {
            $promises_node[] = Http::async()->get($point->url);
        }
        $responses_node = Utils::unwrap($promises_node);
        //dd($responses_node);
        return true ;
    }
    );
});


// here I'm node
Route::prefix('to/node/')->group(function () {

    // receive request from local university and foreword it to master to publish it to all masters
    Route::get('master/request' ,  function(Request $request){
        $promises_node  = Http::async()->get(env('MASTER_URL')+"to/master/send/request" , [
            'university_id' => $request->university_id,
            'collage_id' => $request->collage_id,
            'section_id' => $request->section_id,
            'stage_id' => $request->stage_id,
            'hash' => $request->hash,
            'en_hash' => $request->en_hash,
        ]);
        return true ;
    }
    );
    Route::get('store/request' ,  function(Request $request){

        return true ;
    }
    );
});

require __DIR__.'/auth.php';
