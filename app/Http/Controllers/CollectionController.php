<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseGenerator;
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
                ]);

                if($validator->fails()){
                    $collection->delete();
                    return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Something was wrong');
                }else{
                    try{
                        $collection->cards()->attach($card);
                    }catch(\Exception $e){
                        $collection->delete();
                        return ResponseGenerator::generateResponse(400, '', 'Failed to save');
                    }
                }
            }
        }
    }
}
