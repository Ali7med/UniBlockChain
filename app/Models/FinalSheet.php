<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalSheet extends Model
{
    use HasFactory;
    public function student(){
        return $this->belongsTo(Student::class);
    }
    public function college()
    {
        return $this->belongsTo(College::class);
    }
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
    public function year()
    {
        return $this->belongsTo(Year::class);
    }
    public function study_type()
    {
        return $this->belongsTo(StudyType::class);
    }
    public function graduate()
    {
        return $this->belongsTo(GraduationDegree::class,"graduation_degree_id" , "id");
    }
}

