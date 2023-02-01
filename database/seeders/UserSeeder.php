<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'paco',
                'email' => 'paco@gmail.com',
                'password' => Hash::make('Aa123456'),
                'role' => 'particular',
            ],
            [
                'name' => 'pedro',
                'email' => 'pedro@gmail.com',
                'password' => Hash::make('Aa123456'),
                'role' => 'professional',
            ],
            [
                'name' => 'mario',
                'email' => 'mario@gmail.com',
                'password' => Hash::make('Aa123456'),
                'role' => 'admin',
            ]
        ]);
    }
}
