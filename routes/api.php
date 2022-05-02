<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
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
Route::post('/register',[UserController::class,'store']);
Route::get('/users',[UserController::class,'index']);
Route::delete('/users/{id}',[UserController::class,'destroy']);
Route::get('/users/{id}',[UserController::class,'show']);
Route::put('/users/{id}',[UserController::class,'update']);

//rooms
Route::get('/rooms',[RoomController::class,'index']);
Route::post('/rooms',[RoomController::class,'store']);
Route::delete('/rooms/{id}',[RoomController::class,'destroy']);





