<?php

use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\LikesController;
use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FollowsController;
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

    // User
    Route::prefix('/user')->group(function (){
        Route::get('/',[UserController::class,'index'])->name('user.index');
        Route::get('/s/{search}',[UserController::class,'search']);

    });

    // Follow
    Route::prefix('/follow')->group(function (){
        Route::post('/{user}', [FollowsController::class,'store'])->name('follow.store');
        Route::get('/{user}/followers',[FollowsController::class,'followers'])->name('follow.followers');
        Route::get('/{user}/following',[FollowsController::class,'following'])->name('follow.following');
    });

    // Post
    Route::prefix('/p')->group(function (){
        Route::get('/', [PostsController::class,'index'])->name('post.index');
        Route::post('/', [PostsController::class,'store'])->name('post.store');
        Route::get('/{post}', [PostsController::class,'show']);
        Route::patch('/{post}',[PostsController::class,'update'])->name('post.update');
        Route::delete('/{post}',[PostsController::class,'destroy'])->name('post.destroy');

        // Comments post
        Route::get('/{post}/comments',[CommentsController::class,'index']);
        Route::post('/{post}/comments',[CommentsController::class,'store']);

        // Likes post
        Route::get('/{post}/likes',[LikesController::class,'index'])->name('likes.index');
        Route::post('/{post}/likes',[LikesController::class,'store'])->name('likes.store');
    });

});


