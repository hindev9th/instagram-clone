<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();


/**
 * Follow
 */
Route::post('/follow/{user}', 'FollowsController@store');

/**
 * Profile
 */
Route::middleware('auth')->prefix('/profile')->group(function (){
    Route::get('/{user:username}', 'ProfilesController@index')->name('profile.index');
    Route::get('/{user:username}/edit', 'ProfilesController@edit')->name('profile.edit');
    Route::patch('/{user:username}', 'ProfilesController@update')->name('profile.update');
});

/**
 * Post
 */
Route::middleware('auth')->prefix('/')->group(function () {
    Route::get('/', 'PostsController@index')->name('post.index');
    Route::post('/p', 'PostsController@store')->name('post.store');
    Route::get('/p/{post}', 'PostsController@show')->name('post.show');
    Route::delete('/p/d/{post}','PostsController@destroy')->name('post.destroy');
    /**
     * Comments
     */
    Route::post('/p/{post}/comment}','CommentsController@store')->name('comment.store');
    /**
     * Likes post
     */
    Route::post('/p/{post}/like','LikesController@store')->name('like.store');
});


/**
 * Chat room
 */
Route::middleware('auth')->prefix('c')->group(function (){
    Route::get('','ChatsController@index')->name('chat.index');
    Route::post('','ChatsController@store')->name('chat.store');
    Route::get('message/{chat}','MessagesController@index')->name('message.index');
    Route::post('message/{chat}','MessagesController@store')->name('messages.store');
});

