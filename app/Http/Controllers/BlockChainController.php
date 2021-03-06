<?php

namespace App\Http\Controllers;

use App\Models\FinalSheet;
use App\Models\Phase1;
use App\Models\Phase2;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
