<?php

namespace Database\Seeders;

use App\Models\StudyType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudyType::create([
            'name' => 'Morning'
        ]);
        StudyType::create([
            'name' => 'Evening'
        ]);
    }
}
