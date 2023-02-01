<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('collections')->insert([
            [
                'name' => 'magos',
                'image' => Str::random(10),
                'edit_date' => '2022-05-15',
            ],
            [
                'name' => 'cosas raras',
                'image' => Str::random(10),
                'edit_date' => '2023-01-01',
            ]
        ]);
    }
}
