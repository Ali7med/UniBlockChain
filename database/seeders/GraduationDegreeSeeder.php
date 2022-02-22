<?php

namespace Database\Seeders;

use App\Models\GraduationDegree;
use Illuminate\Database\Seeder;

class GraduationDegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GraduationDegree::create(['name'=>'Bachelors']);
        GraduationDegree::create(['name'=>'Master']);
        GraduationDegree::create(['name'=>'Doctoral']);
    }
}
