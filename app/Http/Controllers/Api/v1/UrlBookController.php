<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class UrlBookController extends Controller
{
   
    
    public function searchBook($nameBook)
    { 
        try{ 
    // $response = Http::get('https://www.googleapis.com/books/v1/volumes?',['q' => $nameBook]);//обработка первого url
    // return $response->json()['items'];
    
     $response = Http::get('https://www.mann-ivanov-ferber.ru/book/search.ajax?q=books',['q' => $nameBook]);//обработка второго url
        if ($response->successful()) {  
        $bookData = $response->json();
        foreach($bookData['books'] as $key => $value){
                $book = new Book;
                $book->name = $value['title'];
                $book->description = $value['url'];
                $book->user_id = Auth::user()->id;
                $book->save();
            }
            return response()->json(['message'=>'Books added Successfully']);
        }
    }catch(\Exception $e) { }
     
    }


    
}
    



  












