<?php

namespace Modules\User\Events;

use App\Models\UserNotification;
use BeyondCode\LaravelWebSockets\WebSockets\Channels\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class NotificationEvent implements ShouldBroadcast, ShouldQueue
{
    use SerializesModels;

    private $notification;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UserNotification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('user_notification')
        ];
    }
}
