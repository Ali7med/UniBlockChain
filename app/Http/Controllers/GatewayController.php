<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\Master;
use App\Models\GatewayDataAllStage;
use App\Models\GatewayDataGraduateDocument;
use App\Models\GatewayDataGraduateOrder;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

class GatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Log::alert('::::in Check GateWay '.env('GATEWAY_NAME'));
        $found=0;

        // must to check the type of hash to store it
        if($request->type=="all_stages"){
           $result= GatewayDataAllStage::where([
                'doc_id' => $request->doc_id ,
                'student_id' => $request->student_id ,
                'university_id' => $request->university_id,
                'college_id' => $request->college_id,
                'section_id' => $request->section_id,
                'stage_id' => $request->stage_id,
                'hash' => $request->hash
            ])->first();
            if($result) $found=1;

        }elseif($request->type=="graduate"){

            $result= GatewayDataGraduateOrder::where([
                'doc_id' => $request->doc_id ,
                'student_id' => $request->student_id ,
                'university_id' => $request->university_id,
                'college_id' => $request->college_id,
                'section_id' => $request->section_id,
                'stage_id' => $request->stage_id,
                'hash' => $request->hash
            ])->first();
            if($result) $found=1;

        }elseif($request->type=="document"){
            $result= GatewayDataGraduateDocument::where([
                'doc_id' => $request->doc_id ,
                'student_id' => $request->student_id ,
                'university_id' => $request->university_id,
                'college_id' => $request->college_id,
                'section_id' => $request->section_id,
                'stage_id' => $request->stage_id,
                'hash' => $request->hash
            ])->first();
            if($result)  $found=1;
        }
        $gateway=Gateway::where('name',env('GATEWAY_NAME'))->first();
        Log::alert('::::the result isFound:'.$found);

        $response=[
            'id'=>$gateway->id,
            'name'=>$gateway->name,
            'result'=>$found,
        ];
         return $response;
    }

    // public function send_master(Request $request)
    // {
    //     $path=env('MASTER_URL')."from/gateway/store";
    //     Log::alert('+ (send_master) Master : '.$path);
    //     $promises_node  = Http::async()->get($path , [
    //         'university_id' => $request->university_id,
    //         'college_id' => $request->college_id,
    //         'section_id' => $request->section_id,
    //         'stage_id' => $request->stage_id,
    //         'hash' => $request->hash,
    //         'prev_hash' => $request->prev_hash,
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

    public function store_abbar_request(Request $request){
        Log::alert('+++ 2 in GATEWAY --> store_abbar_request');
        $data= [
            'doc_id' => $request->doc_id ,
            'student_id' => $request->student_id ,
            'university_id' => $request->university_id,
            'college_id' => $request->college_id,
            'section_id' => $request->section_id,
            'stage_id' => $request->stage_id,
            'type' => $request->type,
            'hash' => $request->hash,
            'prev_hash' => $request->prev_hash,
        ];
        Log::info(json_encode($data));
        //send master
        $path=env('MASTER_URL')."master/from/gateway/store";
        $promises_node  =null;
        $promises_node  = Http::acceptJson()->async()->post($path ,$data)
            ->then(function ($response){
            Log::alert('successfully store_abbar_request ');
            //Log::alert($response);
        });
        $promises_node->wait();
// must to send save information to local gateway
        $this->store($request);
        return response()->json(
            [
                'send' => true,
                'result' => "send successfully store_abbar_request"
            ]
            ,200
        );
        return response()->json(
            [
                'send' => false,
                'result' => "send Not successfully in  store_abbar_request"
            ],500
        );


        //$this->send_master($request);
       //return $this->store($request);
    }
    public function store(Request $request)
    {
        // must to check the type of hash to store it
        Log::alert("In Gateway Local store");
        $data= [
            'doc_id' => $request->doc_id ,
            'student_id' => $request->student_id ,
            'university_id' => $request->university_id,
            'college_id' => $request->college_id,
            'section_id' => $request->section_id,
            'stage_id' => $request->stage_id,
            'hash' => $request->hash,
            'prev_hash' => $request->prev_hash,
        ];
        Log::info(json_encode($data));
        $doc=null;
        if($request->type=="all_stages"){
           $doc= GatewayDataAllStage::create([
                'doc_id' => $request->doc_id ,
                'student_id' => $request->student_id ,
                'university_id' => $request->university_id,
                'college_id' => $request->college_id,
                'section_id' => $request->section_id,
                'stage_id' => $request->stage_id,
                'hash' => $request->hash,
                'prev_hash' => $request->prev_hash,
            ]);
        }elseif($request->type=="graduate"){
            $prev_hash="";
            // get last hash to create chain
            $result= GatewayDataGraduateOrder::where([
                'doc_id' => $request->doc_id ,
                'student_id' => $request->student_id ,
                'university_id' => $request->university_id,
                'college_id' => $request->college_id,
                'section_id' => $request->section_id,
                'stage_id' => $request->stage_id
            ])->orderBy('id','desc')->first();
            if($result) $prev_hash=$result->hash;
            Log::info(json_encode($result));
            $doc=  GatewayDataGraduateOrder::create([
                'doc_id' => $request->doc_id ,
                'student_id' => $request->student_id ,
                'university_id' => $request->university_id,
                'college_id' => $request->college_id,
                'section_id' => $request->section_id,
                'stage_id' => $request->stage_id,
                'hash' => $request->hash,
                'prev_hash' => $prev_hash,
            ]);
        }elseif($request->type=="document"){
            $doc=GatewayDataGraduateDocument::create([
                'doc_id' => $request->doc_id ,
                'student_id' => $request->student_id ,
                'university_id' => $request->university_id,
                'college_id' => $request->college_id,
                'section_id' => $request->section_id,
                'stage_id' => $request->stage_id,
                'hash' => $request->hash,
                'prev_hash' => $request->prev_hash,
            ]);
        }else{
            Log::error("In Gateway store the type not any type known");
        }
        return response()->json(
            [
                'send' => true,
                'data' => $doc,
            ]
            ,200
        );

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
