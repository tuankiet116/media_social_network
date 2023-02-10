<?php

namespace Modules\User\Events\VideoChat;

use App\Models\User;
use App\Models\VideoChat;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Incomming implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $videoChat;
    public $caller;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(VideoChat $videoChat, User $caller)
    {
        $this->videoChat = $videoChat;
        $this->caller = $caller;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('video-chat-incomming.' . $this->videoChat->receiver);
    }

    public function broadCastAs()
    {
        return 'incomming';
    }
}
