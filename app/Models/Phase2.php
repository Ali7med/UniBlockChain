<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Phase2 extends Model
{
    use HasFactory;
    protected  $guarded=[];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function phase1()
    {
        return $this->belongsTo(Phase1::class);
    }
    public function head_uni()
    {
        return $this->belongsTo(User::class);
    }
    public function operation()
    {
        return $this->belongsTo(FinalSheet::class,"operation_id" ,"id");
    }

    protected function hash2(): Attribute
    {
        // return Attribute::make(
        //     get: fn ($value) => Hash::make($this->operation->id.$this->operation->student_id.$this->operation->college_id.
        //     $this->operation->stage_id.$this->operation->year_id.$this->operation->average.
        //     $this->operation->avg_1st_rank.$this->operation->study_type_id.$this->operation->graduation_degree_id.
        //     $this->operation->number_date_graduation_degree),
        // );
        return Attribute::make(
            get: fn ($value) => hash('sha3-256',$this->operation->id.$this->operation->student_id.$this->operation->college_id.
            $this->operation->stage_id.$this->operation->year_id.$this->operation->average.
            $this->operation->avg_1st_rank.$this->operation->study_type_id.$this->operation->graduation_degree_id.
            $this->operation->number_date_graduation_degree),
        );

    }
}
