<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class BookController extends Controller
{
    //Open a book
    public function index($id){
        try {
            $book =  Book::select(['name', 'description'])->where('id', $id)->get();
        } catch (ModelNotFoundException $exception) {
            return ("Book with id {id} not found");
        }

        return $book;
    }

    //Creating a book
    public function store(Request $request){

    $idCurrentUser = Auth::user()->id;//id of the current user
    //Validated
    $validateBook = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'description' =>'required'
        ]);
       
    
       $book = Book::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $idCurrentUser
        ]);

    if($validateBook->fails()){
         $name= $request->validate([
            'name' => 'required|max:255'
        ]);
    //Read txt file
    if(File::exists($request)){
    $contents = File::get($request);
     $book = Book::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $idCurrentUser
        ]);
    } 
    else{
        return "The file doesn't exist";
    }
    }   
        return $book;
    }

    //Get books belonging to the authorized user
    public function show(){
   $books = Book::select(['id', 'name'])->where('user_id', Auth::user()->id)->get();
   
    return  $books;
    }

    //Update book
    public function update(Request $request,$id){     
          try {
         $book = Book::findOrFail($id);
        $fields = $request->validate([
            'name' => 'required|max:255',
            'description' =>'required'
        ]);
        $book -> update($fields);
         } catch (ModelNotFoundException $exception) {
            return ("Book with id {id} not found");
        }
        return $book;
    }

    //Delete book
    public function destroy($id){     
     
        $book = Book::findOrFail($id);
        $result =  $book->delete();
        if($result){
        return ['message' => 'Book deleted'];
        }
    }


}
