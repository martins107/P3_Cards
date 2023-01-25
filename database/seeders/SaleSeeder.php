<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sales')->insert([
            'stock' => rand(1,100),
            'price' => rand(1,1000),
        ]);
        DB::table('sales')->insert([
            'stock' => rand(1,100),
            'price' => rand(1,1000),
        ]);
        DB::table('sales')->insert([
            'stock' => rand(1,100),
            'price' => rand(1,1000),
        ]);
        DB::table('sales')->insert([
            'stock' => rand(1,100),
            'price' => rand(1,1000),
        ]);
    }
}
