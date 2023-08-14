<?php

use App\Http\Controllers\Api\ChatsController;
use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\LikesController;
use App\Http\Controllers\Api\MessagesController;
use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\Api\ProfilesController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FollowsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
        Route::get('/',[UserController::class,'auth'])->name('user.auth');
        Route::get('/suggested',[UserController::class,'suggested'])->name('user.suggested');
        Route::get('/search/{search}',[UserController::class,'search']);

    });

    Route::prefix('/profiles')->group(function (){
        Route::get('/{user:username}',[ProfilesController::class,'index'])->name('profiles.index');
        Route::get('/posts/{user:username}',[ProfilesController::class,'posts'])->name('profiles.posts');
        Route::get('/edit',[ProfilesController::class,'edit'])->name('profiles.edit');
        Route::patch('/',[ProfilesController::class,'update'])->name('profiles.update');
    });

    // Follow
    Route::prefix('/follows')->group(function (){
        Route::post('/{user:username}', [FollowsController::class,'store'])->name('follow.store');
        Route::get('/{user:username}/followers',[FollowsController::class,'followers'])->name('follow.followers');
        Route::get('/{user:username}/following',[FollowsController::class,'following'])->name('follow.following');
    });

    // Post
    Route::prefix('/posts')->group(function (){
        Route::get('/suggested', [PostsController::class,'suggested'])->name('post.suggested');
        Route::get('/old', [PostsController::class,'olds'])->name('post.olds');
        Route::get('/', [PostsController::class,'index'])->name('post.index');
        Route::post('/', [PostsController::class,'store'])->name('post.store');
        Route::get('/{post}', [PostsController::class,'show'])->name('post.show');
        Route::patch('/{post}',[PostsController::class,'update'])->name('post.update');
        Route::delete('/{post}',[PostsController::class,'destroy'])->name('post.destroy');
    });

    Route::prefix('/comments')->group(function (){
        Route::get('/{post}',[CommentsController::class,'index']);
        Route::get('/{comment}/replies',[CommentsController::class,'loadReplies']);
        Route::post('/{post}',[CommentsController::class,'store']);
        Route::patch('/{comment}',[CommentsController::class,'update']);
        Route::delete('/{comment}',[CommentsController::class,'destroy']);

    });
    Route::prefix('/likes')->group(function (){

        // Likes post
        Route::get('/post/{post}',[LikesController::class,'index'])->name('likes.index');
        Route::post('/post/{post}',[LikesController::class,'store'])->name('likes.store');

        // Likes Comment
        Route::get('/comment/{comment}',[LikesController::class,'loadUserLikeComment'])->name('likes.comment.index');
        Route::post('/comment/{comment}',[LikesController::class,'commentStore'])->name('likes.comment.store');
    });


    /**
     * Chat room
     */
    Route::prefix('/chats')->group(function (){
        Route::get('/',[ChatsController::class,'index']);
        Route::post('/',[ChatsController::class,'store']);
        Route::get('/{chat}',[ChatsController::class,'show']);
        Route::put('/{chat}',[ChatsController::class,'update']);
        Route::patch('/{chat}',[ChatsController::class,'leave']);
        Route::delete('/{chat}',[ChatsController::class,'destroy']);
    });

    Route::prefix('/messages')->group(function (){
        Route::get('/{chat}',[MessagesController::class,'index'])->name('message.index');
        Route::post('/',[MessagesController::class,'store'])->name('messages.store');
    });

});


