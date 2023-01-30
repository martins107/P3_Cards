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
            foreach($request->all()['cards'] as $card){

                if(isset($card['card_id'])){
                    $validator = Validator::make($card, [
                        'card_id' => ['integer', 'max:20', 'exists:cards,id'],
                    ]);
                    if($validator->fails()){
                        return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Format of this card is wrong: '.$card);
                    }else{
                        $existingCard = Card::find($card['card_id']);

                        try{
                            $collection->cards()->attach($existingCard);
                        }catch(\Exception $e){
                            return ResponseGenerator::generateResponse(400, $existingCard, 'Failed to save this card');
                        }
                    }
                }else{
                    $validator = Validator::make($card, [
                        'name' => ['required', 'max:20'],
                        'description' => ['required', 'max:100'],
                    ]);
                    if($validator->fails()){
                        //$collection->delete();
                        return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Format of this card is wrong: '.$card);
                    }else{
                        $newCard = new Card();
                        $newCard->name = $card['name'];
                        $newCard->description = $card['description'];

                        try{
                            $newCard->save();    
                            $collection->cards()->attach($newCard);                        
                        }catch(\Exception $e){
                            //$collection->delete();
                            return ResponseGenerator::generateResponse(400, '', 'Failed to save this card');
                        }
                    }
                }
            }
            /*$collectionCards = Card::join('sales', 'cards.id', '=', 'sales.card_id')
                                    ->select('card.*')
                                    ->get();
            if(empty($collectionCards)){
                $collection->delete();
                return ResponseGenerator::generateResponse(200, '', 'Failed to save the collection');
            }else{*/
                return ResponseGenerator::generateResponse(200, $collection, 'Collection was saved');
            //}
            
        }
    }
}
