<?php

namespace Database\Seeders;

use App\Models\FinalSheet;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            CollegeSeeder::class,
            GraduationDegreeSeeder::class,
            StageSeeder::class,
            SubjectTypeSeeder::class,
            UniversityTypeSeeder::class,
            YearTypeSeeder::class,
            StudyTypeSeeder::class,
            FinalSheetSeeder::class,
            MasterSeeder::class,
            GatewaySeeder::class
        ]);
        Student::factory(100)->create();
    }
}
