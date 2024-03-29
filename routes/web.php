<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Auth::routes(['verify' => true]);

Route::get('threads/search', 'SearchController@show');
/**
 * thread routes
 */
Route::resource('threads', 'ThreadsController')->except(['update', 'show', 'destroy']);
Route::get('threads/{channel:slug}', 'ThreadsController@index');
Route::get('threads/{channel}/{thread:slug}', 'ThreadsController@show')->name('threads.show');
Route::patch('threads/{channel}/{thread:slug}', 'ThreadsController@update')->name('threads.update');
Route::delete('threads/{channel}/{thread:slug}', 'ThreadsController@destroy')->name('threads.destroy');

Route::post('locked-threads/{thread:slug}', 'LockedThreadsController@store')->name('locked-thread.store');
Route::delete('locked-threads/{thread:slug}', 'LockedThreadsController@destroy')->name('locked-thread.destroy');

/**
 * thread's replies routes
 */
// Route::resource('threads.replies', 'RepliesController')->except(['store', 'index']);
Route::get('threads/{channel}/{thread:slug}/replies', 'RepliesController@index')->name('replies.index');
Route::post('threads/{channel}/{thread:slug}/replies', 'RepliesController@store')->name('replies.store');
Route::patch('replies/{reply}', 'RepliesController@update')->name('replies.update');
Route::delete('replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');

/**
 * best replies routes
 */
Route::post('replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');

/**
 * thread's subscription routes
 */
Route::post('threads/{channel}/{thread:slug}/subscriptions', 'ThreadsSubscriptionController@store')->name('subscriptions.store');
Route::delete('threads/{channel}/{thread:slug}/subscriptions', 'ThreadsSubscriptionController@destroy')->name('subscriptions.destroy');

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
 * profile routes
 */
Route::get('profiles/{user:name}', 'ProfilesController@show')->name('profile');

Route::get('/api/users', 'Api\UsersController@index');
