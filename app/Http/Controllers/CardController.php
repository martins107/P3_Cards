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

            try{
                $card->save();
                $card->collections()->attach($datos->collection_id);
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
                        ->where('name', 'like', $datos->name)
                        ->orderBy('sales.price', 'desc')
                        ->get();
            return ResponseGenerator::generateResponse(200, $cards, 'ok');
            /*try{
                $cards = Card::where('name', 'like', $datos->name)->get();
                return ResponseGenerator::generateResponse(200, $card, 'These are the cards');
            }catch(\Exception $e){
                return ResponseGenerator::generateResponse(400, '', 'We didnt found cards');
            }
            foreach($cards as $card){
                $cardToAdd = $card::join('sales', 'cards.id', '=', 'sales.card_id')
                                    ->orderBy('sales.price', 'desc')
                                    ->get();
                if(!empty($cardToAdd)){
                    array_push($cardsToBuy, $cardToAdd);
                }
            }
            return ResponseGenerator::generateResponse(200, $cardsToBuy, 'ok');*/
            
        }
    }
}
