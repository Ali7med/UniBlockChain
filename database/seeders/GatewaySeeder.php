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
            'name' => 'Karbala_University',
            'url' => 'http://192.168.71.136/UniBlockChain/public/api/',
            'weight'=>51
        ]);
        Gateway::create([
            'name' => 'Warith_University',
            'url' => 'http://192.168.71.27/UniBlockChain/public/api/',
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
