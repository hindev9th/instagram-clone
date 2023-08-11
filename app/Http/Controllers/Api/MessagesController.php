<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Events\NewMessage;
use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index($chatId)
    {
        $chat = auth()->user()->chats->where('id',$chatId)->first();

        return Message::where('chat_id',$chat->id)->latest()->paginate(10);
    }

    public function store(Request $request)
    {
        $message = auth()->user()->messages()->create($request->all());

        broadcast(new NewMessage($message))->toOthers();

        return $message;
    }
}
