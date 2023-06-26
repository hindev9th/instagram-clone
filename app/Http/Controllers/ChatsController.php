<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
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
        $chats = [];
        $chats1 = auth()->user()->chats()->with('profile.user')->get();
        $chats2 = auth()->user()->profile->chats()->with('user.profile')->get();
        $chats = $chats1->merge($chats2);

        return view('chats.index',compact('chats'));
    }


    public function create(User $user)
    {
        $chatExist1 = auth()->user()->chats()->where('profile_id',$user->profile->id)->get();
        $chatExist2 = auth()->user()->profile->chats()->where('user_id',$user->id)->get();

        if (count($chatExist1) === 0 && count($chatExist2) === 0){
            $chat = new Chat();
            $chat->user_id = auth()->user()->id;
            $chat->profile_id = $user->profile->id;
            $chat->save();
        }

        return redirect(route('chat.index'));
    }
}
