<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('card_collection')->insert([
            'card_id' => 1,
            'collection_id' => 1,
        ]);
        DB::table('card_collection')->insert([
            'card_id' => 2,
            'collection_id' => 1,
        ]);
        DB::table('card_collection')->insert([
            'card_id' => 3,
            'collection_id' => 2,
        ]);
        DB::table('card_collection')->insert([
            'card_id' => 4,
            'collection_id' => 2,
        ]);  
    }
}
