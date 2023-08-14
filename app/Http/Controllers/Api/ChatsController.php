<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Events\NewChat;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatsController extends Controller
{

    public function index()
    {
        return auth()->user()->chats()->with('users')->latest('created_at')->paginate(10);
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

    public function show($chatId)
    {
        return auth()->user()->chats->where('id',$chatId)->load('users')->first();
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

    public function leave(Chat $chat)
    {
        return DB::table("chat_user")
            ->where('chat_id', $chat->id)
            ->where('user_id', auth()->id())
            ->update([
                "deleted_at" => DB::raw('Now()'),
            ]);
    }

    public function destroy(Chat $chat)
    {
        return $chat->delete();
    }
}
