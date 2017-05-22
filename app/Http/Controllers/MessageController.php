<?php

namespace App\Http\Controllers;

use Telegram\Bot\Laravel\Facades\Telegram; 
use App\Models\Message;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller {

	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(App\Models\Chat $chat) {
    	return $chat->id;
    }

	//Checks and add messages to the DB
	/* 	Chat statuses:
		status '0' - deactivated
		status '1' - active
		status '3' - deleted
	*/
	public function saveUpdates() {

		$updates = Telegram::getUpdates();

		foreach ($updates as $update) {
			if (!Message::where('id', '=', array_get($update, 'message.message_id'))->exists()) {
				
				if (Chat::where('user_id', '=', array_get($update, 'message.from.id'))->where('status', '=', 1)->exists()) {
					$storeMessage = $this->storeMessage($update);
				} else {
					$chat = new Chat;
					$chat->username = array_get($update, 'message.from.first_name')." ".array_get($update, 'message.from.last_name');
					$chat->user_id = array_get($update, 'message.from.id');
					$chat->save();	

					$storeMessage = $this->storeMessage($update);
				}
			}
		}
		return redirect()->back();
	}

	public function storeMessage($update) {
    	$message = new Message;
	    $user_id = array_get($update, 'message.chat.id');

		$message->id = array_get($update, 'message.message_id');
		$message->username = array_get($update, 'message.from.first_name')." ".array_get($update, 'message.from.last_name');
		$message->date = array_get($update, 'message.date');
		$message->text = array_get($update, 'message.text');
		$message->chat_id = Chat::where('user_id', '=', $user_id)->where('status', '=', 1)->value('id');
		$message->user_id = $user_id;
		$message->save();	
    }


	//Send messages
	public function postSendMessage(Request $request, $chat_id) {	
    	$user_id = Chat::where('id', '=', $chat_id)->value('user_id');
    	
        $rules = [
            'message' => 'required'
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            return redirect()->back()
                ->with('status', 'danger')
                ->with('message', 'Message is required');
        }

        $response = Telegram::sendMessage([
            'chat_id' => $user_id,
            'text' => $request->get('message')
        ]);

        $storeMessage = $this->storeMessage(['message' => $response]);

        return redirect()->back()
            ->with('status', 'success')
            ->with('message', 'Message sent');
    }
}
