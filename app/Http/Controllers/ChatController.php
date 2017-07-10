<?php

namespace App\Http\Controllers;

use App\Models\Chat;


class ChatController extends Controller {

	public function __construct() {
	        $this->middleware('auth');
	}

	public function index() {
		$chats = Chat::where('status', '!=', 3)->with('messages')->get();
		return view('chats', ['chats' => $chats]);
	}

	public function show(Chat $chat) {

		return view('messages', ['messages' => $chat->messages, 'chat_id' => $chat->chat_id]);
	}


	public function deactivate(Chat $chat) {
		$chat->update(['status' => 0]);

		return redirect()->back();
	}

	public function delete(Chat $chat) {
		$chat->update(['status' => 3]);

		return redirect()->back();
	}
}