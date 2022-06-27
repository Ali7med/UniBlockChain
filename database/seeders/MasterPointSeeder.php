<?php

namespace Database\Seeders;

use App\Models\MasterPoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MasterPoint::create([
            'name' => 'Karbala Master',
            'url' => 'http://localhost/karbalaUniGatway/public/api/'
        ]);
        MasterPoint::create([
            'name' => 'Baghdad Master',
            'url' => 'http://localhost/alsalamUniGatway/public/api/'
        ]);
    }
}
