<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseGenerator;
use App\Models\Card;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollectionController extends Controller
{
    public function registCollections(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:20'],
            'image' => ['required', 'max:50'],
            'edit_date' => ['required', 'date_format:Y-m-d'],
            'cards' => ['required'],
        ]);
        if($validator->fails()){
            return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Something was wrong');
        }else{
            $collection = new Collection();

            $collection->name = $datos->name;
            $collection->image = $datos->image;
            $collection->edit_date = $datos->edit_date;

            try{
                $collection->save();
            }catch(\Exception $e){
                return ResponseGenerator::generateResponse(400, '', 'Failed to save');
            }
            //$cardsToDecode = $datos->cards->getContent();
           // $cards = json_decode($datos->cards);

            /*$validator = Validator::make($datos->cards, [
                'name' => ['required', 'max:20'],
                'description' => ['required', 'max:100'],
                'card_id' => ['integer', 'max:20', 'exists:cards,id'],
            ]);
            if($validator->fails()){
                $collection->delete();
                return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Something was wrong');
            }else{*/
                foreach($datos->cards as $card){
                    print_r($card->name);
                    $cardDecode = json_decode(json_encode($card));
                    print_r($card);
                    die();
                    if($card->id){
                        $existingCard = Card::find($card->id);

                        try{
                            $collection->cards()->attach($existingCard);
                        }catch(\Exception $e){
                            $collection->delete();
                            return ResponseGenerator::generateResponse(400, '', 'Failed to save');
                        }
                    }else{
                        $newCard = new Card();
                        $newCard->name = $card->name;
                        $newCard->description = $card->description;

                        try{
                            $newCard->save();    
                            $collection->cards()->attach($newCard);                        
                        }catch(\Exception $e){
                            $collection->delete();
                            return ResponseGenerator::generateResponse(400, '', 'Failed to save');
                        }
                    }
                
                }
            //}
            return ResponseGenerator::generateResponse(200, $collection, 'Collection was saved');
        }
    }
}
