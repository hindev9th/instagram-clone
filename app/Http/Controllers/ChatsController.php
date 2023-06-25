<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('chats.index');
    }


    public function fetch()
    {
        return Message::with('user')->get();
    }

    public function send()
    {
        $user = auth()->user();
        $message = $user->messages()->create([
           'message' => \request()->input('message'),
        ]);

        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message sent'];
    }
}
