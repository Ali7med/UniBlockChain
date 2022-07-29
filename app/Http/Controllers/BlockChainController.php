<?php

namespace App\Http\Controllers;

use App\Models\FinalSheet;
use App\Models\Phase1;
use App\Models\Phase2;
use App\Models\Student;
use GuzzleHttp\Promise\Utils;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
class BlockChainController extends Controller
{
    public function form()
    {
        $students= Student::all();
        return view('form',['students'=>$students]);
    }
    public function formTranScript()
    {
        return view('formTranScript');
    }
    public function index1()
    {
        $data=FinalSheet::where('sended' , false)->get();
       return response()->json($data);
    }
    public function index_phase1()
    {
        $data=Phase1::where('sended' , false)->get();
        $result=[];
        // foreach($data as $single){
        //     $resultHash= $this->makeHash($single->operation);
        //     $arr=array(
        //         'id'=> $single->id,
        //         'operation'=> $single->operation,
        //         'student' => $single->student ,
        //         'user_id' => $single->user_id,
        //         'hash' => $single->hash,
        //         'created_at' => $single->created_at,
        //         'hash2' => $resultHash,
        //     );
        //     array_push($result,$arr);
        // }
        return view('phase1' , ['data' => $data]);
    }
    public function index_phase2()
    {
        $data=Phase2::where('sended' , false)->get();
        $result=[];
        // foreach($data as $single){
        //     $resultHash= $this->makeHash($single->operation);
        //     $arr=array(
        //         'id'=> $single->id,
        //         'operation'=> $single->operation,
        //         'student' => $single->student ,
        //         'user_id' => $single->user_id,
        //         'hash' => $single->hash,
        //         'created_at' => $single->created_at,
        //         'hash2' => $resultHash,
        //     );
        //     array_push($result,$arr);
        // }
        return view('phase2' , ['data' => $data]);
    }
    public function store_phase1(Request $request)
    {
        if($request->id==null || !isset($request->id))
        return redirect()->route('phase1.index');



        $id=$request->id;
        if($id==0){
            $data=FinalSheet::where('sended' , false)->get();
        }else{
            $data=FinalSheet::where('id' ,$id)->get();
        }
        // 1- generate Hash
        // 2- Store all hash with related info
        // 3- update the previous info and make sended = true

        //1
        foreach($data as $single){
            $resultHash= $this->makeHash($single);
            // 2
            Phase1::create([
                'university_id' => $single->university_id ,
                'collage_id' => $single->collage_id ,
                'section_id' => $single->section_id ,
                'stage_id' => $single->stage_id ,
                'student_id' => $single->student_id ,
                'user_id' => auth()->user()->id,
                'operation_id' => $single->id,
                'department_head_id'=> $single->user_id,
                'hash' => $resultHash
            ]);
            //3
            $single->sended=true;
            $single->save();
        }
        return redirect()->route('phase1.index');

    }
    public function store_phase2(Request $request)
    {
        if($request->id==null || !isset($request->id))
        return redirect()->route('phase2.index');

        $id=$request->id;
        if($id==0){
            $data=Phase1::where('sended' , false)->get();
        }else{
            $data=Phase1::where('id' ,$id)->get();
        }
        // 1- generate Hash
        // 2- Store all hash with related info
        // 3- update the previous info and make sended = true

        //1
        foreach($data as $single){
            $resultHash= $this->makeHash($single->operation);
            // 2
            Phase2::create([
                'university_id' => $single->university_id ,
                'collage_id' => $single->collage_id ,
                'section_id' => $single->section_id ,
                'stage_id' => $single->stage_id ,
                'student_id' => $single->student_id ,
                'user_id' => auth()->user()->id,
                'operation_id' => $single->operation_id,
                'phase1_id'=> $single->id,
                'hash' => $resultHash
            ]);
            //3
            $single->sended=true;
            $single->save();
        }
        return redirect()->route('phase2.index');

    }

public function send_gateway(Request $request)
    {
        Log::alert("--> send_gateway");
        Log::alert("--> request->id :  $request->id");
        if($request->id==null || !isset($request->id))
        return redirect()->route('phase2.index');

        $single=Phase2::find($request->id);
        if($single){
            //dd($single);
            $single->sended=true;
            $single->save();
            $single->type="graduate";
            $path=env('GATEWAY_URL')."gateway/store/abbar/request";//dd($path);
            // $res=Http::acceptJson()->get($path,$single);
            // dd($res->Body());
            Log::alert('+++ 1');
            $client = new Client([
                'base_uri' => env('GATEWAY_URL'),
                'timeout'  => 60.0,
            ]);
            //$response = $client->get($path);

            $promise = $client->getAsync($path,['query' => ['single' =>$single ]]);
            $promise->then(
                function (ResponseInterface $res) {
                    Log::alert("successfully");
                    return response()->json([
                        'result' => 'send successfully',
                        'message' => $res->getBody()
                       ],
                       200
                    );
                },
                function (RequestException $e) {
                    Log::error('Not successfully in send_gateway ::'.$e->getMessage());
                    return response()->json([
                        'result' => 'send not successfully in send_gateway',
                        'message' => $e->getMessage()
                       ],500);
                    // dd( $e->getMessage() . "\n");
                    // echo $e->getRequest()->getMethod();
                }
            );
            $promise->wait();
//              dd(0);
//             $promises_node  = Http::acceptJson()->getAsync($path,$single)->then(function ($response){
//                 dd($response->body());
//                 return true;
//             });
            //$responses_node = Utils::unwrap($promises_node);
            //$promises_node->wait();
            //dd($promises_node->status());

        }else{
           return response()->json([
            'result' => 'send not successfully in send_gateway'
           ],500);
        }



        // $res= $this->send_request($request->id);
        // if($res){
        //     $result="Process Complete";
        // }else{
        //     $result="Process Not Complete !!!!";
        // }

        // // must to send to gateway
        //  return view('gateway',['result'=>$result]);

    }

    // public function send_request($id)
    // {

    //     $single=Phase2::find($id);
    //     if($single){
    //         //dd($single);
    //         $single->sended=true;
    //         $single->save();
    //         $single->type="graduate";
    //         $path=env('GATEWAY_URL')."gateway/store/abbar/request";//dd($path);
    //         // $res=Http::acceptJson()->get($path,$single);
    //         // dd($res->Body());
    //         Log::alert('+++ 1');

    //         $promises_node  = Http::async()->acceptJson()->get($path,$single)->then(function ($response){
    //             dd($response->body());
    //             return true;
    //         });
    //         //$responses_node = Utils::unwrap($promises_node);
    //          $promises_node->wait();
    //         //dd($promises_node->status());

    //     }else{
    //        return false;
    //     }
    // }

    public function makeHash($single)
    {
        $resultHash=$single->id.
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
}
