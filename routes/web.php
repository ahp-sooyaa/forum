<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Auth::routes();

/**
 * thread routes
 */
Route::resource('threads', 'ThreadsController')->except(['show', 'destroy']);
Route::get('threads/{channel:slug}', 'ThreadsController@index');
Route::get('threads/{channel}/{thread}', 'ThreadsController@show');
Route::delete('threads/{channel}/{thread}', 'ThreadsController@destroy');

/**
 * thread's replies routes
 */
Route::resource('threads.replies', 'RepliesController')->except(['store', 'index']);
Route::get('threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::post('threads/{channel}/{thread}/replies', 'RepliesController@store');

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
Route::get('profiles/{user:name}', 'ProfilesController@show');
