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

Route::get('/add', 'MessageController@saveUpdates');


Route::get('chat', function() {
	$chats = App\Models\Chat::where('status', '!=', 3)->get();
	return view('chats', ['chats' => $chats]);
})->middleware('auth');


Route::get('/chat/{id}/deactivate', function($id) {
	$chat = Chat::where('id', '=', $chatId)->update(['status' => 0]);
	return redirect()->back();
})->middleware('auth');


Route::get('/chat/{id}/delete', function($id) {
	$chat = Chat::where('id', '=', $chatId)->update(['status' => 3]);
	return redirect()->back();
})->middleware('auth');


Route::get('chat/{id}', function ($id){
	$chat = App\Models\Chat::find($id)->messages()->get();
	return view('messages', ['messages' => $chat, 'chat_id' => $id]);
})->middleware('auth');


Route::post('chat/{chat_id}/send/', 'MessageController@postSendMessage');
Route::get('get-updates',   'TelegramController@getUpdates');


