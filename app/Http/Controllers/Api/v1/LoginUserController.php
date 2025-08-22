<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginUserController extends Controller
{
    public function loginUser(Request $request)
    {
        //Validated
        try{
            $validateUser = Validator::make($request->all(),
     [
            'name' => ['required', 'string', 'max:255'],
            'password' => 'required'
            
        ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

      $user = User::where('name', $request->name)->first();
    

       return response()->json([
               'status' => true,
                'message' => 'User logged',
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
