<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\v1\RegisteredUserController;
use App\Http\Controllers\Api\v1\LoginUserController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\PermissionController;
use App\Http\Controllers\Api\v1\BookController;
use App\Http\Controllers\Api\v1\UrlBookController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//Register
Route::post('/register',[RegisteredUserController::class,'registerUser']);
//Login
Route::post('/login',[LoginUserController::class,'loginUser']);

//For registered users only
Route::middleware(['auth:sanctum'])->group(function () {
  Route::get('/list_users',[UserController::class,'allUsers']); //List of all users
  Route::post('/list_users/{id}',[PermissionController::class,'addPermission']); //Give permissions
  Route::post('/books',[BookController::class,'store']); //Creating a book
  Route::get('/books',[BookController::class,'show']);//Get books belonging to the authorized user
  Route::get('/books/{id}',[BookController::class,'index']); //Open a book
  Route::put('/books/{id}',[BookController::class,'update']);//Update book
  Route::delete('/books/{id}',[BookController::class,'destroy']); //Delete book
  Route::get('/list_users_permission/{id}',[PermissionController::class,'showListPermission']); //List of books of another user
  Route::get('/book_outside/{nameBook}',[UrlBookController::class,'searchBook']); //Search and save for books outside
  
});



