<?php

use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\LikesController;
use App\Http\Controllers\Api\MessagesController;
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
        Route::get('/{post}', [PostsController::class,'show'])->name('post.show');
        Route::patch('/{post}',[PostsController::class,'update'])->name('post.update');
        Route::delete('/{post}',[PostsController::class,'destroy'])->name('post.destroy');

        // Comments post
        Route::get('/{post}/comments',[CommentsController::class,'index']);
        Route::post('/{post}/comments',[CommentsController::class,'store']);

        Route::patch('/comments/{comment}',[CommentsController::class,'update']);
        Route::delete('/comments/{comment}',[CommentsController::class,'destroy']);
        // Comment replies
        Route::get('/{comment}/replies',[CommentsController::class,'loadReplies']);

        // Likes post
        Route::get('/{post}/likes',[LikesController::class,'index'])->name('likes.index');
        Route::post('/{post}/likes',[LikesController::class,'store'])->name('likes.store');

        // Likes Comment
        Route::get('/comment/{comment}/likes',[LikesController::class,'loadUserLikeComment'])->name('likes.comment.index');
        Route::post('/comment/{comment}/likes',[LikesController::class,'commentStore'])->name('likes.comment.store');
    });

    /**
     * Chat room
     */
    Route::prefix('c')->group(function (){
        Route::get('message/{chat}',[MessagesController::class,'index'])->name('message.index');
        Route::post('message/{chat}',[MessagesController::class,'store'])->name('messages.store');
    });

});


