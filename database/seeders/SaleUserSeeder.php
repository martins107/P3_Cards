<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sale_user')->insert([
            'sale_id' => 1,
            'user_id' => 1,
        ]);
        DB::table('sale_user')->insert([
            'sale_id' => 2,
            'user_id' => 1,
        ]);
        DB::table('sale_user')->insert([
            'sale_id' => 3,
            'user_id' => 2,
        ]);
        DB::table('sale_user')->insert([
            'sale_id' => 4,
            'user_id' => 2,
        ]);

        
    }
}
