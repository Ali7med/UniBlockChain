<?php

namespace Database\Seeders;

use App\Models\Stage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Stage::create([
            'name' => 'First'
        ]);
        Stage::create([
            'name' => 'Second'
        ]);
        Stage::create([
            'name' => 'Third'
        ]);
        Stage::create([
            'name' => 'Fourth'
        ]);
        Stage::create([
            'name' => 'Fifth'
        ]);
        Stage::create([
            'name' => 'Sixth'
        ]);
    }
}
