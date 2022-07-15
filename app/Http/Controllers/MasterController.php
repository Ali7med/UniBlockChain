<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\Master;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Promise\Utils;
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
    public function store_local(Request $request)
    {
         //first step send to all local node (gateways)
         $promises_node = [];
         $points=Gateway::all();
         foreach ($points as $point) {
             $promises_node[] = Http::async()->get($point->url."/gateway/store/request",$request);
         }
         $responses_node = Utils::unwrap($promises_node);
         //dd($responses_node);
         return true ;
    }
    public function store_send_master(Request $request)
    {
       // first step send to all master nodes(without me)
       $promises_master = [];
       $masters=Master::where(['is_me'=>false])->get();
       foreach ($masters as $master) {
           $promises_master[] = Http::async()->get($master->url."/master/from/master/store",$request);
       }
       $responses_master = Utils::unwrap($promises_master);
       //return true ;
    }
    public function check_send_master(Request $request)
    {
       // first step send to all master nodes(without me)
       $promises_master = [];
       $masters=Master::where(['is_me'=>false])->get();
       foreach ($masters as $master) {
           $promises_master[] = Http::async()->get($master->url."/master/from/master/store",$request);
       }
       $responses_master = Utils::unwrap($promises_master);
       //return true ;
    }
    public function check_local(Request $request)
    {
         //first step send to all local node (gateways)
         $promises_node = [];
         $points=Gateway::all();
         foreach ($points as $point) {
             $promises_node[] = Http::async()->get($point->url."/gateway/check/request",$request);
         }
         $responses_node = Utils::unwrap($promises_node);
         // make sumation the
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
