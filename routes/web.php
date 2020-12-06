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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Auth::routes();

/**
 * thread routes
 */
Route::resource('threads', 'ThreadsController')->except(['show']);
Route::get('threads/{channel:slug}', 'ThreadsController@index');
Route::get('threads/{channel}/{thread}', 'ThreadsController@show');

/**
 * thread's replies routes
 */
Route::resource('threads.replies', 'RepliesController')->except(['store']);
Route::post('threads/{channel}/{thread}/replies', 'RepliesController@store');
