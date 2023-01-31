<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseGenerator;
use App\Models\Card;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    public function registCards(Request $request){
        
        $json = $request->getContent();
        $datos = json_decode($json);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:20'],
            'description' => ['required', 'max:100'],
            'collection_id' => ['required', 'max:20', 'exists:collection,id'],
        ]);
        if($validator->fails()){
            return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Something was wrong');
        }else{
            $card = new Card();

            $card->name = $datos->name;
            $card->description = $datos->description;
            $collection = Collection::find($datos->collection_id);

            try{
                $card->save();
                $card->collections()->attach($collection);
                return ResponseGenerator::generateResponse(200, $card, 'Your card was saved');
            }catch(\Exception $e){
                return ResponseGenerator::generateResponse(400, '', 'Failed to save');
            }
        }

    }
    public function addCardToCollection(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);

        $validator = Validator::make($request->all(), [
            'card_id' => ['required', 'max:20', 'exists:cards,id'],
            'collection_id' => ['required', 'max:20', 'exists:collections,id'],
        ]);
        if($validator->fails()){
            return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Something was wrong');
        }else{
            $card = Card::find($datos->card_id);
            $collection = Collection::find($datos->collection_id);

            try{
                $collection->cards()->attach($card);
                return ResponseGenerator::generateResponse(200, '', 'Card was added to the collection');
            }catch(\Exception $e){
                $collection->delete();
                return ResponseGenerator::generateResponse(400, '', 'Failed to save');
            }
        }
    }
    public function buyCard(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:20'],
        ]);
        if($validator->fails()){
            return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Something was wrong');
        }else{

            $cards = Card::join('sales', 'cards.id', '=', 'sales.card_id')
                        ->join('users', 'sales.user_id', '=', 'users.id')
                        ->where('cards.name', 'like', '%'.$datos->name.'%')
                        ->orderBy('sales.price', 'desc')
                        ->select('cards.name', 'sales.price', 'sales.stock', 'users.name as user')
                        ->get();
            return ResponseGenerator::generateResponse(200, $cards, 'ok');            
        }
    }
}
