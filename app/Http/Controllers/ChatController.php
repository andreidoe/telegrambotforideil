<?php

namespace App\Http\Controllers;

use App\Models\Chat;


class ChatController extends Controller {

	public function __construct() {
	        $this->middleware('auth');
	    }


	public function deactivate($chatId) {
		$chat = Chat::where('id', '=', $chatId)->update(['status' => 0]);

		return redirect()->back();
	}

	public function delete($chatId) {
		$chat = Chat::where('id', '=', $chatId)->update(['status' => 3]);

		return redirect()->back();
	}
}