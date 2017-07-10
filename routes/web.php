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
Auth::routes();

Route::bind('chat', function($chat) {
	return \App\Models\Chat::findOrFail($chat);
});


Route::get('/', 'HomeController@index');

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/add', 'MessageController@saveUpdates');

Route::get('/chat/{chat}/delete', 'ChatController@delete')->middleware('auth');
Route::get('/chat/{chat}/deactivate', 'ChatController@deactivate')->middleware('auth');

Route::get('/chat', 'ChatController@index')->middleware('auth');
Route::get('/chat/{chat}', 'ChatController@show')->middleware('auth');


Route::post('chat/{chat_id}/send/', 'MessageController@postSendMessage');
Route::get('get-updates',   'TelegramController@getUpdates');


