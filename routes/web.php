<?php

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

Auth::routes();

/*Route::get('/home', 'HomeController@index')->name('home');
Route::get('/threads','ThreadController@index');
Route::post('/threads','ThreadController@store');
Route::get('/threads/{thread}','ThreadController@show');*/

//Route::resource('threads','ThreadsController');

Route::get('/threads', 'ThreadController@index')->name('threads.index');

Route::get('/threads/create', 'ThreadController@create')->name('threads.create');

Route::get('/threads/{thread}', 'ThreadController@show')->name('threads.show');

Route::post('/threads', 'ThreadController@store')->name('threads.store');

Route::get('/threads/{thread}/edit', 'ThreadController@edit')->name('threads.edit');

Route::patch('/threads/{thread}', 'ThreadController@update')->name('threads.update');

Route::delete('/threads/{thread}', 'ThreadController@destroy')->name('threads.destroy');



Route::post('/threads/{thread}/replies','ReplyController@store');