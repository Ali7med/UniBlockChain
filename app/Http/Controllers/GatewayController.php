<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\Master;
use App\Models\GatewayDataAllStage;
use App\Models\GatewayDataGraduateDocument;
use App\Models\GatewayDataGraduateOrder;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response=[
            'id'=>Gateway::find(env('GATEWAY_NAME'))->id,
            'result'=>true,
        ];
        // must to check the type of hash to store it
        if($request->type=="all_stages"){
           $result= GatewayDataAllStage::where([
                'university_id' => $request->university_id,
                'collage_id' => $request->collage_id,
                'section_id' => $request->section_id,
                'stage_id' => $request->stage_id,
                'hash' => $request->hash,
                'en_hash' => $request->en_hash,
            ])->get();
            if($result) return $response;

        }elseif($request->type=="graduate"){
            $result= GatewayDataGraduateOrder::where([
                'university_id' => $request->university_id,
                'collage_id' => $request->collage_id,
                'section_id' => $request->section_id,
                'stage_id' => $request->stage_id,
                'hash' => $request->hash,
                'en_hash' => $request->en_hash,
            ])->get();
            if($result) return $response;

        }elseif($request->type=="document"){
            $result= GatewayDataGraduateDocument::where([
                'university_id' => $request->university_id,
                'collage_id' => $request->collage_id,
                'section_id' => $request->section_id,
                'stage_id' => $request->stage_id,
                'hash' => $request->hash,
                'en_hash' => $request->en_hash,
            ])->get();
            if($result) return $response;
        }
        return true ;
    }

    // public function send_master(Request $request)
    // {
    //     $path=env('MASTER_URL')."from/gateway/store";
    //     Log::alert('+ (send_master) Master : '.$path);
    //     $promises_node  = Http::async()->get($path , [
    //         'university_id' => $request->university_id,
    //         'collage_id' => $request->collage_id,
    //         'section_id' => $request->section_id,
    //         'stage_id' => $request->stage_id,
    //         'hash' => $request->hash,
    //         'en_hash' => $request->en_hash,
    //     ]);
    //     $promises_node->wait();
    //     Log::alert('- (send_master) Master ');
    //     return true ;
    // }

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

    public function store_abbar(Request $request){
        //dd(1);
        Log::alert('+++ 2');
        //send master
        $path=env('MASTER_URL')."from/gateway/store";
        $promises_node  = Http::acceptJson()->async()->get($path , [
            'university_id' => $request->university_id,
            'collage_id' => $request->collage_id,
            'section_id' => $request->section_id,
            'stage_id' => $request->stage_id,
            'hash' => $request->hash,
            'en_hash' => $request->en_hash,
        ])->then(function ($response){
            Log::alert('finsh store_abbar ');
            Log::alert($response);
            //dd($response->body());
            return true;
        });
        $promises_node->wait();
        return true ;


        //$this->send_master($request);
       //return $this->store($request);
    }
    public function store(Request $request)
    {
        // Log::alert($request);
        // return response()->json(
        //     $request,200
        // );
        // Log::alert($request);
        // must to check the type of hash to store it
        if($request->type=="all_stages"){
           $doc= GatewayDataAllStage::create([
                'university_id' => $request->university_id,
                'collage_id' => $request->collage_id,
                'section_id' => $request->section_id,
                'stage_id' => $request->stage_id,
                'hash' => $request->hash,
                'en_hash' => $request->en_hash,
            ]);
        }elseif($request->type=="graduate"){
            $doc=  GatewayDataGraduateOrder::create([
                'university_id' => $request->university_id,
                'collage_id' => $request->collage_id,
                'section_id' => $request->section_id,
                'stage_id' => $request->stage_id,
                'hash' => $request->hash,
                'en_hash' => $request->en_hash,
            ]);
        }elseif($request->type=="document"){
            $doc=GatewayDataGraduateDocument::create([
                'university_id' => $request->university_id,
                'collage_id' => $request->collage_id,
                'section_id' => $request->section_id,
                'stage_id' => $request->stage_id,
                'hash' => $request->hash,
                'en_hash' => $request->en_hash,
            ]);
        }
        return response()->json(
            $doc,200
        );
        return $doc->id ;
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