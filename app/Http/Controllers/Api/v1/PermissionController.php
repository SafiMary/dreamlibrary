<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;



class PermissionController extends Controller
{
    public function addPermission(Request $request,$id){
    
    $idCurrentUser = Auth::user()->id;//id of the current user
    $permission = $request->user()->permission()->create([ 'name' => $id ], ['user_id' => $idCurrentUser ]);
    

         return response()->json([
               'status' => true,
                'message' => 'Permission received',
                'permission' =>  $permission
            
            ], 200);
    }

    public function showListPermission($id){
    
    //We will find id  who gave us permission
    $permissions = Permission::select(['user_id'])->where('name', Auth::user()->id)->get();
   
    //Return the list of books where there is an accurate coincidence in the table Book
    // user_id (owner owner) and permissions (user who gave permission)
    return Book::whereIn('user_id',$permissions)->select('name')->get();
    

    }





}



