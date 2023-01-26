<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseGenerator;
use App\Models\Card;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    public function searchCard(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:20'],
        ]);
        if($validator->fails()){
            return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Something was wrong');
        }else{
            try{
                $card = Card::where('name', 'like', $datos->name)->get();
                return ResponseGenerator::generateResponse(200, $card, 'These are the cards');
            }catch(\Exception $e){
                return ResponseGenerator::generateResponse(400, '', 'We didnt found cards');
            }
        }
    }
    public function sellCard(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);

        $validator = Validator::make($request->all(), [
            'id' => ['required', 'max:20', 'integer', 'exists:cards,id'],
            'stock' => ['required', 'max:20', 'integer'],
            'price' => ['required', 'decimal:2'],
        ]);
        if($validator->fails()){
            return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Something was wrong');
        }else{
            $sale = new Sale();

            $sale->stock = $datos->stock;
            $sale->price = $datos->price;
            $sale->card_id = $datos->id;
            $sale->user_id = Auth::id();

        }
    }
}
