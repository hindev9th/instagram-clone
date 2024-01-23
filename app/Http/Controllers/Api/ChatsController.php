<?php

namespace App\Http\Controllers\Api;

use App\Events\DeleteChatRoom;
use App\Http\Controllers\Controller;
use App\Events\NewChat;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
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

        return [
            'id' => $chat->id,
            'name' => $chat->name,
            'created_at' => $chat->created_at,
            'updated_at' => $chat->updated_at,
            'users' => $chat->users,
        ];
    }

    public function showSingle(Request $request)
    {
        $userIds = $request['ids'];
        $userIds[] = auth()->id();

        $chat = Chat::getRoomByUser($userIds)->first();
        return ['id' => $chat->id ?? null];
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
        broadcast(new DeleteChatRoom($chat))->toOthers();
        return $chat->delete();
    }
}
