<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CardTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_regist_card()
    {
        $login = $this->postJson('/api/users/login', ['name' => 'mario', 'password' => 'Aa123456']);
        $json = $login->getContent();
        $datos = json_decode($json);

        $token = $datos->data;

        //dd($token);
        //Datos vacíos
        $emptyData = $this->withHeaders(['Authorization' => 'Bearer '.$token])
                        ->postJson('/api/cards/registCards', []);
        $emptyData->assertStatus(200)
                ->assertJson([
                    "status" => 400
                ]);

        //Colección incorrecta
        $wrongCollection = $this->withHeaders(['Authorization' => 'Bearer '.$datos->data[1]])
                        ->postJson('/api/cards/registCards', 
                        ["name"=> "mago de hielo",
                        "description"=> "es un mago pero de hielo",
                        "collection_id"=> 20]);
        $wrongCollection->assertStatus(200)
                ->assertJson([
                    "status" => 400
                ]);

         //Todos los datos bien
        $correctData = $this->withHeaders(['Authorization' => 'Bearer '.$datos->data[1]])
                        ->postJson('/api/cards/registCards', 
                        ["name"=> "mago de hielo2",
                        "description"=> "es un mago pero de hielo2",
                        "collection_id"=> 1]);
        $correctData->assertStatus(200)
                ->assertJson([
                    "status" => 200
                ]);
    }
}
