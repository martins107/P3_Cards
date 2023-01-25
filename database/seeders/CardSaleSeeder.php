<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('card_sale')->insert([
            'card_id' => 1,
            'sale_id' => 1,
        ]);
        DB::table('card_sale')->insert([
            'card_id' => 2,
            'sale_id' => 2,
        ]);
        DB::table('card_sale')->insert([
            'card_id' => 3,
            'sale_id' => 3,
        ]);
        DB::table('card_sale')->insert([
            'card_id' => 4,
            'sale_id' => 4,
        ]);        
    }
}
