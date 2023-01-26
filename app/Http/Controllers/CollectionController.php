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
            'edit_date' => ['required', 'date_fomat:Y-m-d'],
            'cards' => ['required', 'array:card'],
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
                return ResponseGenerator::generateResponse(200, $collection, 'ok');
            }catch(\Exception $e){
                return ResponseGenerator::generateResponse(400, '', 'Failed to save');
            }

            foreach($datos->cards as $card){
                $validator = Validator::make($card->all(), [
                    'name' => ['required', 'max:20'],
                    'description' => ['required', 'max:100'],
                    'card_id' => ['integer', 'max:20', 'exists:cards,id'],
                ]);

                if($validator->fails()){
                    $collection->delete();
                    return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Something was wrong');
                }else{
                    if($datos->card_id){
                        $existingCard = Card::find($datos->card_id);

                        try{
                            $collection->cards()->attach($existingCard);
                        }catch(\Exception $e){
                            $collection->delete();
                            return ResponseGenerator::generateResponse(400, '', 'Failed to save');
                        }
                    }else{
                        $newCard = new Card();
                        $newCard->name = $datos->name;
                        $newCard->description = $datos->description;

                        try{
                            $newCard->save();    
                            $collection->cards()->attach($newCard);                        
                        }catch(\Exception $e){
                            $collection->delete();
                            return ResponseGenerator::generateResponse(400, '', 'Failed to save');
                        }
                    }
                   
                }
            }
            return ResponseGenerator::generateResponse(200, $collection, 'Collection was saved');
        }
    }
}
