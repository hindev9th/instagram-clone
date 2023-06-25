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
Route::get('/profile/{user:username}', 'ProfilesController@index')->name('profile.index');
Route::get('/profile/{user:username}/edit', 'ProfilesController@edit')->name('profile.edit');
Route::patch('/profile/{user:username}', 'ProfilesController@update')->name('profile.update');

/**
 * Post
 */
Route::get('/', 'PostsController@index')->name('post.index');
Route::get('/p/create', 'PostsController@create')->name('post.create');
Route::post('/p', 'PostsController@store')->name('post.store');
Route::get('/p/{post}', 'PostsController@show')->name('post.show');
/**
 * Comments
 */
Route::post('/p/{post}/comment}','CommentsController@store')->name('comment.store');
/**
 * Likes post
 */
Route::post('/p/{post}/like','LikesController@store')->name('like.store');

Route::prefix('c')->group(function (){
    Route::get('','ChatsController@index')->name('chat.index');
    Route::get('message','ChatsController@fetch')->name('chat.fetch');
    Route::post('message','ChatsController@send')->name('chat.send');
});

