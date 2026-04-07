<?php

namespace App\Events;

use App\Models\Message;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast  // ← Importante: implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $conversation;
    public $user;

    public function __construct(Message $message, Conversation $conversation, User $user)
    {
        $this->message = $message;
        $this->conversation = $conversation;
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('user.' . $this->message->recipient_id),
            new PrivateChannel('conversation.' . $this->conversation->id),
        ];
    }

    public function broadcastAs()
    {
        return 'MessageSent';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'message' => $this->message->message,
            'user_id' => $this->message->user_id,
            'recipient_id' => $this->message->recipient_id,
            'created_at' => $this->message->created_at,
            'fromUser' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ]
        ];
    }
}