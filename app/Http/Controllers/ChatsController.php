<?php

namespace App\Http\Controllers;

use App\Events\NewChat;
use App\Events\NewMessage;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $chats = auth()->user()->chats()->with('users')->latest('created_at')->get();

        return view('chats.index',compact('chats'));
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
