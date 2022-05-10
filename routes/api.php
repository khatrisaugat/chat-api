<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\passportAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/users',[UserController::class,'store']);
Route::get('/users',[UserController::class,'index']);
Route::delete('/users/{id}',[UserController::class,'destroy']);
Route::get('/users/{id}',[UserController::class,'show']);
Route::put('/users/{id}',[UserController::class,'update']);

//rooms
Route::get('/rooms',[RoomController::class,'index']);
Route::post('/rooms',[RoomController::class,'store']);
Route::delete('/rooms/{id}',[RoomController::class,'destroy']);
Route::get('/rooms/{id}',[RoomController::class,'show']);

//Messages
Route::post('/messages',[MessageController::class,'store']);
Route::put('/messages/{id}',[MessageController::class,'update']);
Route::delete('/messages/{id}',[MessageController::class,'destroy']);


//passport
Route::post('register',[passportAuthController::class,'registerUserExample']);
Route::post('login',[passportAuthController::class,'loginUserExample']);
//add this middleware to ensure that every request is authenticated
Route::middleware('auth:api')->group(function(){
    Route::get('user', [passportAuthController::class,'authenticatedUserDetails']);
});






