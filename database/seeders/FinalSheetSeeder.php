<?php

namespace Database\Seeders;

use App\Models\FinalSheet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinalSheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        FinalSheet::create([
            'university_id'=> '1',
            'student_id'=> '1',
            'college_id'=> '1',
            'section_id'=> '1',
            'stage_id'=> '1',
            'year_id'=> '1',
            'user_id'=>1,
            'average'=> '88',
            'avg_1st_rank' => '88',
            'study_type_id' => '1',
            'graduation_degree_id' => '1',
            'number_date_graduation_degree' => '3241 2021-01-23',
        ]);
        FinalSheet::create([
            'university_id'=> '1',
            'student_id'=> '1',
            'college_id'=> '1',
            'section_id'=> '2',
            'stage_id'=> '2',
            'year_id'=> '2',
            'user_id'=>1,
            'average'=> '78',
            'avg_1st_rank' => '80',
            'study_type_id' => '2',
            'graduation_degree_id' => '1',
            'number_date_graduation_degree' => '5124 2022-03-23',
        ]);
        FinalSheet::create([
            'university_id'=> '1',
            'student_id'=> '2',
            'college_id'=> '1',
            'section_id'=> '1',
            'stage_id'=> '2',
            'year_id'=> '1',
            'user_id'=>1,
            'average'=> '60',
            'avg_1st_rank' => '77',
            'study_type_id' => '2',
            'graduation_degree_id' => '1',
            'number_date_graduation_degree' => '2211 2021-03-13',
        ]);
    }
}
