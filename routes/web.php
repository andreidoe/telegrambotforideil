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

Route::get('/', 'HomeController@index');

Route::get('/admin', function () {
    return view('admin');
});


Route::get('/chat', 'ChatController@getChats');
Route::get('/chat/{id}/activate', 'ChatController@activate');
Route::get('/chat/{id}/deactivate', 'ChatController@deactivate');
Route::get('/chat/{id}/delete', 'ChatController@delete');

Route::get('/add', 'MessageController@saveUpdates');
Route::get('/chat/{id}', 'MessageController@getMessages');
Route::post('chat/{id}/send', 'MessageController@postSendMessage');

Route::get('get-updates',   'TelegramController@getUpdates');


