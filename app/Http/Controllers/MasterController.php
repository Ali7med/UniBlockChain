<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\Master;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Facades\Log;

class MasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $responses = Http::pool(fn (Pool $pool) => [
        $pool->add('foo')->get('https://httpbin.org/delay/6')->then(

        ),
        $pool->add('bar')->get('https://httpbin.org/delay/3')->then(

        ),
        $pool->add('baz')->get('https://httpbin.org/delay/3')->then(

        ),
    ]);

    $responses['foo']->ok();
    $responses['bar']->successful();
    //$connectionFailed = $responses['baz'] instanceof GuzzleHttp\Exception\ConnectException;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function from_master_store(Request $request)
    {
        Log::alert('--> from_master_store');
        Log::alert('+++ 4');
         //first step send to all local node (gateways)
         $promises_node = [];
         $gateways=Gateway::all();
         Log::alert('::::START SEND Gateways');
         foreach ($gateways as $gateway) {
            if($gateway->url!="") {
                Log::alert('+++ must to send to Gateway '.$gateway->name . " URL:" .$gateway->url);
                $promises_node[] = Http::async()->get($gateway->url."gateway/store/request",$request);

            }else{
                Log::alert('+++ Gateway '.$gateway->name . " Don't have URL");
            }
            }
         $responses_node = Utils::unwrap($promises_node);
         Log::alert('::::END SEND Gateways');
         //dd($responses_node);
         return response()->json(
            [
                'send' => true,
                'result' => "send successfully"
            ]
            ,200
        );
    }
    // receive request from any ware to store
    public function from_gateway_store(Request $request)
    {
       // first step send to all master nodes(without me)
       Log::alert('IN Master');
       Log::alert('--> from_gateway_store');
       Log::alert('+++ 3');
    //    return response()->json(
    //     [
    //         'send' => true,
    //         'result' => "send from_gateway_store successfully"
    //     ],200
    // );

        $data= [
            'university_id' => $request->university_id,
            'collage_id' => $request->collage_id,
            'section_id' => $request->section_id,
            'stage_id' => $request->stage_id,
            'hash' => $request->hash,
            'en_hash' => $request->en_hash,
       ];
       $promises_master = [];
       $masters=Master::where(['is_me'=>false])->get();
       $path='';
       Log::alert('::::START SEND Master');

       foreach ($masters as $master) {
        if($master->url!=""){
            Log::alert('+++ must to send to master '.$master->name . " URL:" .$master->url);
            $path=$master->url."master/from/master/store";
            $promises_master[] = Http::async($path)->post($path ,$data);
        }else{
            Log::alert('+++  master '.$master->name . " NOT HAVE URL URL:");
        }
       }
       $responses_master = Utils::unwrap($promises_master);
       Log::alert('::::END SEND Master');
       // second step send to local gateways
    //    Log::alert('second step send to local gateways');
    //    $this->from_master_store($request);
    //    return true;

    return response()->json(
        [
            'send' => true,
            'result' => "send successfully to masters"
        ]
        ,200
    );
    }
    public function check_send_master(Request $request)
    {
       // first step send to all master nodes(without me)
       $promises_master = [];
       $masters=Master::where(['is_me'=>false])->get();
       foreach ($masters as $master) {
           $promises_master[] = Http::async()->get($master->url."/master/from/master/check",$request);
       }
       $responses_master = Utils::unwrap($promises_master);
    //second step calculate
       $SumTrues=0;
        foreach ($responses_master as $master) {
            $SumTrues+= $master->results;
        }

       //second step check all local gateways
        $SumLocals=$this->from_master_check($request);
        $SumTrues+=$SumLocals;
        return $SumTrues;
    }
    public function from_master_check(Request $request)
    {
         //first step send to all local node (gateways)
         $promises_node = [];
         $points=Gateway::all();
         foreach ($points as $point) {
             $promises_node[] = Http::async()->get($point->url."/gateway/check/request",$request);
         }
         $responses_node = Utils::unwrap($promises_node);
         // make summation the
         $SumRation=0;
        foreach ($responses_node as $point) {
            if($point->result==true){
                $SumRation+=Gateway::find($point->id)->weight;
            }

        }

         //dd($responses_node);
         return $SumRation ;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
