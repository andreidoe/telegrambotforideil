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


	//Checks and writes messages to the DB
	public function saveUpdates() {

		$updates = Telegram::getUpdates();

		//Iterating through updates and checking if 'chat' or 'message' record exists in DB
		//If not, then write it into DB
		foreach ($updates as $update) {
			$username = $update['message']['from']['first_name'] 
				. " " . $update['message']['from']['last_name'];
			$user_id = $update['message']['from']['id'];
			
			$chat = new Chat;
			$message = new Message; 

			if (!Message::where('id', '=', $update['message']['message_id'])->exists()) {
				if (Chat::where('user_id', '=', $user_id)->where('status', '=', 1)->exists()) {
					$message->id = $update['message']['message_id'];
					$message->username = $username;
					$message->date = date('Y-m-d H:i:s', $update['message']['date']);
					$message->text = $update['message']['text'];
					$message->chat_id = Chat::where('user_id', '=', $user_id)->where('status', '=', 1)->value('id');				
					$message->save(); 
					
				} else if (!Chat::where('user_id', '=', $user_id)->where('status', '=', 1)->exists()
						&& Chat::where('user_id', '=', $user_id)->where('status', '!=', 3)) {
					$chat->username = $username;
					$chat->user_id = $user_id;
					$chat->save();	

					$message->id = $update['message']['message_id'];
					$message->username = $username;
					$message->date = date('Y-m-d H:i:s', $update['message']['date']);
					$message->text = $update['message']['text'];
					$message->chat_id = $chat->id;
					$message->save(); 
				}
			}
	}
	return redirect()->back();
}


	//Returns chat messages
	public function getMessages($chatId) {

		if (Message::where('chat_id', '=', $chatId)->exists() 
			&& Chat::where('id', '=', $chatId)->where('status', '!=', 3)->exists()) {
			$messages = Message::where('chat_id', '=', $chatId)->get(); 
		} else {
			return "404";
		}
		
		return view('messages', ['messages' => $messages, 'chatId' => $chatId]);
	}


	//Send messages
	public function postSendMessage(Request $request, $chatId)
    {
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
            'chat_id' => $chatId,
            'text' => $request->get('message')
        ]);


        $message = new Message;
			$message->id = $response->getMessageId();
			$message->username = 'admin';
			$message->date = date('Y-m-d H:i:s', $response->getDate());			
			$message->text = $request->message;
			$message->chat_id = $chatId;
			$message->save(); 



        return redirect()->back()
            ->with('status', 'success')
            ->with('message', 'Message sent');
    }

}