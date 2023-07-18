<?php

use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\UserController;
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
Route::middleware('auth:api')->prefix('/')->group(function (){
    Route::get('/user',[UserController::class,'index'])->name('user.index');


});
Route::get('/p/{post}/comment',[CommentsController::class,'index']);
Route::post('/p/{post}/comment',[CommentsController::class,'store']);
Route::get('/user/s/{search}',[UserController::class,'search']);
