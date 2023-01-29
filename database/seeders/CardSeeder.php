<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cards')->insert([
            'name' => 'mago',
            'description' => 'es un mago',
        ]);
        DB::table('cards')->insert([
            'name' => 'mago de fuego',
            'description' => 'es un mago pero de fuego',
        ]);
        DB::table('cards')->insert([
            'name' => 'duende',
            'description' => 'es un duende',
        ]);
        DB::table('cards')->insert([
            'name' => 'perro',
            'description' => 'es un perro',
        ]);
    }
}
