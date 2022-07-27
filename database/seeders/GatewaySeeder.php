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
            'url' => 'http://localhost/UniBlockChain/public/api/',
            'weight'=>55
        ]);
        Gateway::create([
            'name' => 'Al-Salam_University',
            'url' => '',
            'weight'=>11
        ]);

        // Gateway::create([
        //     'name' => 'AlSafwa_University',
        //     'url' =>'',
        //     'weight'=>11
        // ]);
        // Gateway::create([
        //     'name' => 'Warith_University',
        //     'url' =>'',
        //     'weight'=>14
        // ]);
        // Gateway::create([
        //     'name' => 'Rafdeen_University',
        //     'url' =>'',
        //     'weight'=>13
        // ]);
        // Gateway::create([
        //     'name' => 'AlZahra_University',
        //     'url' =>'',
        //     'weight'=>18
        // ]);
        // Gateway::create([
        //     'name' => 'AlZahra_University',
        //     'url' =>'',
        //     'weight'=>21
        // ]);

    }
}
