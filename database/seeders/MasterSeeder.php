<?php

namespace Database\Seeders;

use App\Models\Master;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Master::create([
            'name' => 'Karbala_Master',
            'url' => 'http://localhost/karbalaUniGatway/public/api/',
            'is_me'=>true
        ]);
        Master::create([
            'name' => 'Baghdad_Master',
            'url' => 'http://localhost/alsalamUniGatway/public/api/'
        ]);
    }
}
