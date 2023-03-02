<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UserTest extends TestCase
{
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        //Artisan::call('migrate');

        //Usuario no encontrado
        $response = $this->postJson('/api/users/login', ['name' => 'asdfasdfasddsasdf']);
        $response->assertStatus(200)
                ->assertJson([
                    "status" => 400
                ]);

        //Usuario y contraseña no coincidentes
        $response = $this->postJson('/api/users/login', ['name' => 'paquito', 'password' => 'Aa654321']);
        $response->assertStatus(200)
                ->assertJson([
                    "status" => 400
                ]);

        //Usuario y contraseña coincidentes
        $response = $this->postJson('/api/users/login', ['name' => 'mario', 'password' => 'Aa123456']);
        $response->assertStatus(200)
                ->assertJson([
                    "status" => 200
                ]);


    }
}
