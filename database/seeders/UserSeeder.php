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
            'name' => 'paco',
            'email' => 'paco@gmail.com',
            'password' => '1234',
            'role' => 'particular',
        ]);
        DB::table('users')->insert([
            'name' => 'pedro',
            'email' => 'pedro@gmail.com',
            'password' => '1234',
            'role' => 'professional',
        ]);
        DB::table('users')->insert([
            'name' => 'mario',
            'email' => 'mario@gmail.com',
            'password' => '1234',
            'role' => 'admin',
        ]);
    }
}
