<?php

namespace App\Listeners;

use App\Events\NotificationPost;
use App\Services\User\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotification implements ShouldQueue
{
    private $notificationService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handleSendNotificationPost(NotificationPost $event)
    {
        dd($event);
    }

    public function subscribe($events) {
        $events->listen(
            NotificationPost::class,
            [SendNotification::class, 'handleSendNotificationPost']
        );
    }
}
