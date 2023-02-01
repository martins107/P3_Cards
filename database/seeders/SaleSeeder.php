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
            [
                'stock' => rand(1,100),
                'price' => rand(1,1000),
                'card_id' => 1,
                'user_id' => 1,
            ],
            [
                'stock' => rand(1,100),
                'price' => rand(1,1000),
                'card_id' => 2,
                'user_id' => 2,
            ],
            [
                'stock' => rand(1,100),
                'price' => rand(1,1000),
                'card_id' => 3,
                'user_id' => 3,
            ],
            [
                'stock' => rand(1,100),
                'price' => rand(1,1000),
                'card_id' => 4,
                'user_id' => 1,
            ]
        ]);
    }
}
