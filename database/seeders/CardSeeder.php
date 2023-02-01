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
            [
                'name' => 'mago',
                'description' => 'es un mago',
            ],
            [
                'name' => 'mago de fuego',
                'description' => 'es un mago pero de fuego',
            ],
            [
                'name' => 'duende',
                'description' => 'es un duende',
            ],
            [
                'name' => 'perro',
                'description' => 'es un perro',
            ]
        ]);
    }
}
