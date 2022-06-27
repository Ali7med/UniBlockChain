<?php

namespace Database\Seeders;

use App\Models\MasterGatewayPoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterGatewayPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MasterGatewayPoint::create([
            'name' => 'Karbala University',
            'url' => 'http://localhost/karbalaUniGatway/public/api/'
        ]);
        MasterGatewayPoint::create([
            'name' => 'Al-Salam University',
            'url' => 'http://localhost/alsalamUniGatway/public/api/'
        ]);
    }
}
