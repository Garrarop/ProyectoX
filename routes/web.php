<?php

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

Route::view('/', 'welcome')->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Statuses routes
Route::get('statuses', 'StatusesController@index')->name('statuses.index');

Route::post('statuses', 'StatusesController@store')->name('statuses.store')->middleware('auth');

// Statuses Likes routes
Route::post('statuses/{status}/likes', 'StatusLikesController@store')->name('statuses.likes.store')->middleware('auth');
Route::delete('statuses/{status}/likes', 'StatusLikesController@destroy')->name('statuses.likes.destroy')->middleware('auth');

// Statuses Comments routes
Route::post('statuses/{status}/comments', 'StatusCommentsController@store')->name('statuses.comments.store')->middleware('auth');

// Comments Likes routers
Route::post('comments/{comment}/likes', 'CommentLikesController@store')->name('comments.likes.store')->middleware('auth');
Route::delete('comments/{comment}/likes', 'CommentLikesController@destroy')->name('comments.likes.destroy')->middleware('auth');

// User routes

Route::get('@{user}', 'UsersController@Show')->name('users.show');

// Users statuses routes
Route::get('user/{user}/statuses', 'UsersStatusController@index')->name('users.statuses.index');

// Friendships routes
Route::post('friendships/{recipient}', 'FriendshipsController@store')->name('friendships.store')->middleware('auth');
Route::delete('friendships/{recipient}', 'FriendshipsController@destroy')->name('friendships.destroy')->middleware('auth');

// Request Friendship routes
Route::post('accept-friendships/{sender}', 'AcceptFriendshipsController@store')->name('accept-friendships.store')->middleware('auth');
Route::delete('accept-friendships/{sender}', 'AcceptFriendshipsController@destroy')->name('accept-friendships.destroy')->middleware('auth');
