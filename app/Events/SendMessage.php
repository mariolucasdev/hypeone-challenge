<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage implements ShouldBroadcast
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Message Data to Send
     * [content]
     * [chat_id]
     * [username]
     *
     * @var array
     */
    public object $message;

    /**
     * Create a new event instance.
     */
    public function __construct(object $message)
    {
        $this->message = $message;
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'message.created';
    }

    /**
     * Default data strucute to send
     *
     * @return void
     */
    public function broadcastWith()
    {
        return [
            'content' => $this->message->content,
            'username' => $this->message->username,
            'chatId' => $this->message->chat_id,
            'createdAt' => $this->message->created_at,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('chat.' . $this->message->chat_id);
    }
}
