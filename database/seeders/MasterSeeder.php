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
            'url' => 'http://192.168.71.136/UniBlockChain/public/api/',
            'is_me'=>true
        ]);
        Master::create([
            'name' => 'Baghdad_Master',
            'url' => 'http://localhost/UniBlockChain2/public/api/',
            'is_me'=>false
        ]);
    }
}
