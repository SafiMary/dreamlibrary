<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{

public function registerUser(Request $request)
    {
       
    try{
        //Validated
     $validateUser = Validator::make($request->all(),
     [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
        ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }  
        
       

        //Registered

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
           
        ]);
       

        return response()->json([
               'status' => true,
                'message' => 'User Created',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            
            ], 200);
        
    } catch (\Throwable $th){
        return response()->json([
               'status' => false,
                'message' => $th->getMessage(),
            ], 500);


        }
}

}