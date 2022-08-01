<?php

namespace App\Http\Controllers;

use App\Http\Traits\HashTrait;
use App\Models\Gateway;
use App\Models\GraduationDegree;
use App\Models\Master;
use App\Models\StudyType;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Facades\Log;

class MasterController extends Controller
{
    use HashTrait;
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
        //first step send to all local node (gateways)
        Log::alert('+++ 4 --> from_master_store');
        Log::alert('My Master :' . env('MASTER_NAME') . " URL:".env('MASTER_URL'));
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

         $promises_node = [];
         $gateways=Gateway::all();
         Log::info(json_encode($gateways));

         Log::alert('::::START SEND Gateways');
         foreach ($gateways as $gateway) {
            if($gateway->url!="") {
                $path=$gateway->url."gateway/store/request";
                Log::alert('+++ must to send to Gateway '.$gateway->name . " URL:" .$path);
                $promises_node[] = Http::acceptJson()->async()->get($path,$data);

            }else{
                Log::alert('+++ Gateway '.$gateway->name . " Don't have URL");
            }
            }
         $responses_node = Utils::unwrap($promises_node);
         Log::alert('::::END SEND Gateways');
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
       Log::alert('+++ 3 IN Master --> from_gateway_store');

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

       $promises_master = [];
       $masters=Master::where(['is_me'=>false])->get();
       $path='';
       Log::alert('::::START SEND Master');
       foreach ($masters as $master) {
        if($master->url!=""){
            $path=$master->url."master/from/master/store";
            Log::alert('+++ must to send to master '.$master->name . " URL:" .$path);
            $promises_master[] = Http::acceptJson()->post($path ,$data);
        }else{
            Log::alert('+++  master '.$master->name . " NOT HAVE URL URL:");
        }
       }
       //$responses_master = Utils::unwrap($promises_master);
       Log::alert('::::END SEND Master');

       // second Step send to add gateways in our cluster
       Log::alert('::::Local Gateways');
       $promises_node = [];
         $gateways=Gateway::where('name','!=',$request->gateway)->get();
         Log::info(json_encode($gateways));

         Log::alert('::::START SEND Gateways');
         foreach ($gateways as $gateway) {
            if($gateway->url!="") {
                $path=$gateway->url."gateway/store/request";
                Log::alert('+++ must to send to Gateway '.$gateway->name . " URL:" .$path);
                $promises_node[] = Http::acceptJson()->async()->get($path,$data);

            }else{
                Log::alert('+++ Gateway '.$gateway->name . " Don't have URL");
            }
            }
         $responses_node = Utils::unwrap($promises_node);

         Log::alert('::::END SEND Local Gateways');
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
    public function master_check_view()
    {
        $graduations= GraduationDegree::all();
        $studies=StudyType::all();
        $years=Year::all();
        return view('masterCheck',[
            'graduations'=>$graduations,
            'studies'=> $studies,
            'years'=>$years
        ]);
    }
    public function master_check(Request $request)
    {

        $hash=$this->makeHash($request);
        $data=[
            'doc_id' =>$request->doc_id ,
            'student_id' =>$request->student_id,
            'college_id' => $request->college_id,
            'stage_id'=>$request->stage_id,
            'year_id'=>$request->year_id,
            'average'=>$request->average,
            'avg_1st_rank'=>$request->avg_1st_rank,
            'study_type_id'=>$request->study_type_id,
            'graduation_degree_id'=>$request->graduation_degree_id,
            'number_date_graduation_degree'=>$request->number_date_graduation_degree,
            'hash'=>$hash,
            'type'=>"graduate"

        ];


        //first step send to all local node (gateways)
        $promises_node = [];
         $gateways=Gateway::all();
         Log::alert('::::START CHECK Gateways');
         foreach ($gateways as $gateway) {
            if($gateway->url!="") {
                $path=$gateway->url."gateway/check/request";
                Log::alert('+++ must to CHECK to Gateway '.$gateway->name . " URL:" .$path);
                $promises_node[] = Http::acceptJson()->get($path,$data);

            }else{
                Log::alert('+++ Gateway '.$gateway->name . " Don't have URL");
            }
            }
         //$responses_node = Utils::unwrap($promises_node);
         Log::alert('::::END CHECK Gateways');

        // make summation the
        $SumRation=0;
        $gateway=null;
        Log::alert('::::START Make Sum CHECK Gateways');

        Log::info(json_encode(Gateway::all()));

       foreach ($promises_node as $point) {
        $value=$point->json();
        Log::info(json_encode($value));
        Log::alert('Gateways '.$value['name'].' ID ' . $value['id']);
        if($value['result']==true){
            $gateway=Gateway::where('id',$value['id'])->first();
            if($gateway){
            Log::alert('+++  Gateway '.$gateway->name . " weight:" .$gateway->weight);
            $SumRation+=$gateway->weight;
            }
        }else{
        Log::critical('----  Gateway '.$value['name'] . "  NOT FOUND");
        }
       }


       Log::alert('----  SumRation '.$SumRation. " ");

        $request->request->add(['hash' =>$hash ]);
        dd($request);
        return view('masterCheck');
    }
    public function makeHash($single)
    {
        Log::info(json_encode($single));
        $resultHash=$single->doc_id.
        $single->student_id.
        $single->college_id.
        $single->stage_id.
        $single->year_id.
        $single->average.
        $single->avg_1st_rank.
        $single->study_type_id.
        $single->graduation_degree_id.
        $single->number_date_graduation_degree;
        return hash('sha3-256', $resultHash); //Hash::make()
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
