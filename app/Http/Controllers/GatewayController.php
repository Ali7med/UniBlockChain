<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\Master;
use App\Models\GatewayDataAllStage;
use App\Models\GatewayDataGraduateDocument;
use App\Models\GatewayDataGraduateOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    public function send_master(Request $request)
    {
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
    public function store(Request $request)
    {
        // must to check the type of hash to store it
        if($request->type=="all_stages"){
            GatewayDataAllStage::create([
                'university_id' => $request->university_id,
                'collage_id' => $request->collage_id,
                'section_id' => $request->section_id,
                'stage_id' => $request->stage_id,
                'hash' => $request->hash,
                'en_hash' => $request->en_hash,
            ]);
        }elseif($request->type=="graduate"){
            GatewayDataGraduateOrder::create([
                'university_id' => $request->university_id,
                'collage_id' => $request->collage_id,
                'section_id' => $request->section_id,
                'stage_id' => $request->stage_id,
                'hash' => $request->hash,
                'en_hash' => $request->en_hash,
            ]);
        }elseif($request->type=="document"){
            GatewayDataGraduateDocument::create([
                'university_id' => $request->university_id,
                'collage_id' => $request->collage_id,
                'section_id' => $request->section_id,
                'stage_id' => $request->stage_id,
                'hash' => $request->hash,
                'en_hash' => $request->en_hash,
            ]);
        }
        return true ;
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
