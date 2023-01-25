<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\ResponseGenerator;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);

        $user = new User();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:20'],
            'email' => ['required', 'email'],
            'password' => ['required','min:8','regex:/[a-z]/','regex:/[A-Z]/','regex:/[0-9]/'],
            'role' => ['required', Rule::in(['particular','professional','admin'])],
        ]);

        if($validator->fails()){
            return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Something was wrong');
        }else{
            $user->name = $datos->name;
            $user->email = $datos->email;
            $user->password = Hash::make($datos->password);
            $user->rol = $datos->role;

            try{
                $user->save();
                return ResponseGenerator::generateResponse(200, $user, 'ok');
            }catch(\Exception $e){
                return ResponseGenerator::generateResponse(400, '', 'Failed to save');
            }
        }
    }
    public function login(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);

        try{
            $user = User::where('name', 'like', $datos->name)->firstOrFail();
        }catch(\Exception $e){
            return ResponseGenerator::generateResponse(400, '', 'Invalid email');
        }
        if (Hash::check($datos->password, $user->password)) {    
            $token = $user->createToken($user->name, [$user->rol]);
            $fullUser = [$user, $token->plainTextToken];
            return ResponseGenerator::generateResponse(200, $fullUser, 'Login succesfully');
        }else{
            return ResponseGenerator::generateResponse(400, '', 'Invalid password');
        }        
    }
    public function recoverPass(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ]);

        if($validator->fails()){
            return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Something was wrong');
        }else{
            $str=rand();
            $newPassword = md5($str);

            $hashPassword = Hash::make($newPassword);

            try{
                $user = User::where('email', 'like', $datos->email)->firstOrFail();
            }catch(\Exception $e){
                return ResponseGenerator::generateResponse(400, '', 'Invalid email');
            }

            $user->password = $hashPassword;

            try{
                $user->save();
                return ResponseGenerator::generateResponse(200, $newPassword, 'This is your new password');
            }catch(\Exception $e){
                return ResponseGenerator::generateResponse(400, '', 'Failed to save');
            }
        }
        
    }
}
