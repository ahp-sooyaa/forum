<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Auth::routes(['verify' => true]);

/**
 * thread routes
 */
Route::resource('threads', 'ThreadsController')->except(['show', 'destroy']);
Route::get('threads/{channel:slug}', 'ThreadsController@index');
Route::get('threads/{channel}/{thread:slug}', 'ThreadsController@show');
Route::delete('threads/{channel}/{thread:slug}', 'ThreadsController@destroy');

/**
 * thread's replies routes
 */
Route::resource('threads.replies', 'RepliesController')->except(['store', 'index']);
Route::get('threads/{channel}/{thread:slug}/replies', 'RepliesController@index');
Route::post('threads/{channel}/{thread:slug}/replies', 'RepliesController@store');

/**
 * best replies routes
 */
Route::post('replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');

/**
 * thread's subscription routes
 */
Route::post('threads/{channel}/{thread:slug}/subscriptions', 'ThreadsSubscriptionController@store');
Route::delete('threads/{channel}/{thread:slug}/subscriptions', 'ThreadsSubscriptionController@destroy');

/**
 * notification routes
 */
Route::delete('profiles/{user:name}/notifications/{notification}', 'NotificationsController@destroy');
Route::get('profiles/{user:name}/notifications', 'NotificationsController@index');

/**
 * favorite replies routes
 */
Route::post('replies/{reply}/favorite', 'FavoritesController@store')->name('favorites.store');
Route::delete('replies/{reply}/favorite', 'FavoritesController@destroy')->name('favorites.destroy');

/**
 * reply routes
 */
Route::resource('replies', 'RepliesController');
// Route::patch('replies/{reply}', 'RepliesController@update')->name('replies.update');
// Route::delete('replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');

/**
 * profile routes
 */
Route::get('profiles/{user:name}', 'ProfilesController@show')->name('profile');

Route::get('/api/users', 'Api\UsersController@index');
