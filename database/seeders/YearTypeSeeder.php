<?php

namespace Database\Seeders;

use App\Models\Year;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YearTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Year::create(['name'=>'2019-2020']);
        Year::create(['name'=>'2020-2021']);
        Year::create(['name'=>'2021-2022']);
        Year::create(['name'=>'2022-2023']);
    }
}
