<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Events\NewMessage;
use App\Models\Chat;

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
