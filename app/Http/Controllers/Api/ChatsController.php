<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Events\NewChat;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatsController extends Controller
{

    public function index()
    {
        return auth()->user()->chats()->with('users')->latest('created_at')->get();
    }


    public function store()
    {
        $chat = Chat::create([
            'name' => null,
        ]);

        $users = collect(\request('users'));
        $users->push(auth()->user()->id);

        $chat->users()->attach($users);

        broadcast(new NewChat($chat))->toOthers();

        return $chat->load('users');
    }

    /**
     * update name of chat room
     *
     * @param Request $request
     * @param Chat $chat
     * @return Chat
     */
    public function update(Request $request,Chat $chat){
        $chat->update($request->all());
        return $chat;
    }
}
