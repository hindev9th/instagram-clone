<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index(Chat $chat)
    {
        return Message::where('chat_id',$chat->id)->get();
    }

    public function store(Chat $chat)
    {
        $user = auth()->user();

        $message = new Message();
        $message->chat_id = $chat->id;
        $message->user_id = $user->id;
        $message->message = \request()->input('message');
        $message->save();

        broadcast(new MessageSent($chat,$user, $message))->toOthers();

        return $message;
    }
}
