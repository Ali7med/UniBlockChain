<?php

namespace Database\Seeders;

use App\Models\Gateway;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gateway::create([
            'name' => 'Baghdad_University',
            'url' => 'http://192.168.0.240/karbalaUniGatway/public/api/',
            'weight'=>51
        ]);
        Gateway::create([
            'name' => 'Mustansiriyah_University',
            'url' => '',
            'weight'=>20
        ]);

        Gateway::create([
            'name' => 'Technology_University',
            'url' =>'',
            'weight'=>20
        ]);
        Gateway::create([
            'name' => 'Al-Mammon_University',
            'url' =>'',
            'weight'=>5
        ]);
        Gateway::create([
            'name' => 'Rafdeen_University',
            'url' =>'',
            'weight'=>2
        ]);
        Gateway::create([
            'name' => 'Dijlah_University',
            'url' =>'',
            'weight'=>2
        ]);

    }
}
