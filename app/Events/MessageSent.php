<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Broadcast trên channel chat với id_customer và id_staff
        return [
            new Channel('chat.' . $this->message->id_customer . '.' . $this->message->id_user),
        ];
    }

    /**
     * Optionally define the data to be broadcasted.
     */
    public function broadcastWith()
    {
        return [
            'message' => $this->message->content,
            'id_customer' => $this->message->id_customer,
            'id_staff' => $this->message->id_user,
            'timestamp' => $this->message->created_at->toDateTimeString(),
        ];
    }
}
