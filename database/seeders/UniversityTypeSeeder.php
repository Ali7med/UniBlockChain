<?php

namespace Database\Seeders;

use App\Models\UniversityType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UniversityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        UniversityType::create(['name'=>'Private']);
        UniversityType::create(['name'=>'Public']);
    }
}
