<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseGenerator;
use App\Models\Card;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
    public function searchCard(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);

        Log::info('Recogemos los datos del request.', ['request' => $datos]);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:20'],
        ]);
        if($validator->fails()){
            Log::error('La validación de los datos de la request han fallado', ['fallos' => $validator->errors()->all()]);
            return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Something was wrong');
        }else{
            Log::info('La request ha sido validada.', ['request' => $datos]);
            try{                
                $card = Card::where('name', 'like', '%'.$datos->name.'%')->get();
                Log::info('La petición ha ido bien y ha devuelto estos datos: ',['cartas' => $card]);
                return ResponseGenerator::generateResponse(200, $card, 'These are the cards');
            }catch(\Exception $e){
                Log::error('La petición a la base de datos ha salido mal', ['fallo' => $e]);
                return ResponseGenerator::generateResponse(400, '', 'Something was wrong');
            }
        }

    }
    public function sellCard(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);

        $validator = Validator::make($request->all(), [
            'id' => ['required', 'max:20', 'integer', 'exists:cards,id'],
            'stock' => ['required', 'max_digits:11', 'integer'],
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

            try{
                $sale->save();
                return ResponseGenerator::generateResponse(200, $sale, 'ok');
            }catch(\Exception $e){
                return ResponseGenerator::generateResponse(400, '', 'Failed to save');
            }
        }
    }
}
