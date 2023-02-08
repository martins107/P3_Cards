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
            return ResponseGenerator::generateResponse(400, print_r($validator->errors()->all(),true), 'Something was wrong');
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
            foreach($request->all()['cards'] as $card){

                if(isset($card['card_id'])){            
                    $validatorExistingCards = Validator::make($card, [
                        'card_id' => ['integer', 'exists:cards,id'],
                    ]);
                    if($validatorExistingCards->fails()){
                        return ResponseGenerator::generateResponse(400, $validatorExistingCards->errors()->all(), 'Format of this card is wrong');
                    }else{
                        $existingCard = Card::find($card['card_id']);

                        try{
                            $collection->cards()->attach($existingCard);
                        }catch(\Exception $e){
                            return ResponseGenerator::generateResponse(400, $existingCard, 'Failed to save this card');
                        }
                    }
                }else{
                    $validatorNewCards = Validator::make($card, [
                        'name' => ['required', 'max:20'],
                        'description' => ['required', 'max:100'],
                    ]);
                    if($validator->fails()){
                        return ResponseGenerator::generateResponse(400, $validatorNewCards->errors()->all(), 'Format of this card is wrong');
                    }else{
                        $newCard = new Card();
                        $newCard->name = $card['name'];
                        $newCard->description = $card['description'];

                        try{
                            $newCard->save();    
                            $collection->cards()->attach($newCard);                        
                        }catch(\Exception $e){
                            return ResponseGenerator::generateResponse(400, '', 'Failed to save this card');
                        }
                    }
                }
            }
            /*if(empty($collection->cards())){
                $collection->delete();
                return ResponseGenerator::generateResponse(200, '', 'Collection has not have cards. The collection was deleted');
            }else{
                return ResponseGenerator::generateResponse(200, $collection, 'Collection was saved');
            }*/
            
        }
    }
    public function updateCollections(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);


        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric', 'exists:collections,id'],
            'name' => 'max:20',
            'image' => 'max:50',
            'edit_date' => 'date_format:Y-m-d',
        ]);

        if($validator->fails()){
            return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Something was wrong');
        }else{
            $collection = Collection::find($datos->id);
            if(isset($datos->name)){
                $collection->name = $datos->name;
            }
            if(isset($datos->image)){
                $collection->image = $datos->image;
            }
            if(isset($datos->edit_date)){
                $collection->edit_date = $datos->edit_date;
            }
            try{
                $collection->save();
                return ResponseGenerator::generateResponse(200, $collection, 'Datos modificados correctamente.');
            }catch(\Exception $e){
                return ResponseGenerator::generateResponse(400, '', 'Algo salió mal.');
            }
        }
    }
}
