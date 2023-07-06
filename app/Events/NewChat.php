<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channels = [];
        foreach ($this->chat->users as $user){
            $channel = 'user.'.$user->id;
            array_push($channels, new PrivateChannel($channel));
        }
        return $channels;
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->chat->id,
            'name' => $this->chat->name,
            'created_at' => $this->chat->created_at,
            'updated_at' => $this->chat->updated_at,
            'users' => $this->chat->users,
        ];
    }
}
