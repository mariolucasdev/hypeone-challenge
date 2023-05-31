<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class channelChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;

    public string $user;

    public string $chatId;

    /**
     * Create a new event instance.
     */
    public function __construct(string $message, string $user, string $chatId)
    {
        $this->message = $message;
        $this->user = $user;
        $this->chatId = $chatId;
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'user' => $this->user,
            'chatId' => $chatId
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('chat'),
        ];
    }
}
