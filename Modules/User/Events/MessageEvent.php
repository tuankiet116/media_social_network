<?php

namespace Modules\User\Events;

use App\Models\Message;
use App\Models\User;
use App\Models\UserMessage;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $message;
    public $userMessage;
    public $userSendMessage;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message, UserMessage $userMessage, User $userSend)
    {
        $this->message = $message;
        $this->userMessage = $userMessage;
        $this->userSendMessage = $userSend;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('fd25b0f2-fdaa-4c67-a8d4-f09c48e6790a.' . $this->message->receiver);
    }

    public function broadcastAs() {
        return 'message';
    }
}
