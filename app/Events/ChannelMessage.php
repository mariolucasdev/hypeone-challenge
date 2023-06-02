<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChannelMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Intance Chat Model
     *
     * @var Chat
     */
    public Chat $chat;

    /**
     * Message Data
     *
     * @var array
     */
    public array $data;

    /**
     * Create a new event instance.
     */
    public function __construct(int $chatId, array $data)
    {
        $this->chat = Chat::find($chatId);
        $this->data = $data;
    }

    /**
     * Data to send
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'content' => $this->data['content'],
            'username' => $this->data['username'],
            'chatId' => $this->chat->chatId,
            'createdAt' => $this->data['createdAt'],
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('chat.' . $this->chat->id);
    }
}
