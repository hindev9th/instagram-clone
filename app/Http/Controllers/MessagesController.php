<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index(Chat $chat)
    {
        return $chat->messages;
    }

    public function store(Chat $chat)
    {
        $user = auth()->user();

        $message = $chat->messages()->create([
            'user_id' => $user->id,
            'message' => \request('message'),
        ]);

        broadcast(new NewMessage($message))->toOthers();

        return $message;
    }
}
