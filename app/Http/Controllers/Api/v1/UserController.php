<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
   
public function allUsers(Request $request){
    //List of all users
    return $users = User::all('id','name')->except(Auth::id());
   
}



}
