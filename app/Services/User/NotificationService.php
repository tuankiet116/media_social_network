<?php

namespace App\Services\User;

use App\Models\UserNotification;

class NotificationService
{
    public function getNotifications($offset)
    {
        $userId = auth()->id();
        $notifiations = UserNotification::with('userSender', 'communitySender')
            ->where('user_id', $userId)->orderBy('created_at', 'DESC')
            ->limit(LIMIT)->offset($offset)->get();
        $newOffset = null;
        if (count($notifiations) == LIMIT) {
            $newOffset = count($notifiations) + $offset;
        }
        return [
            'notifications' => $notifiations,
            'offset' => $newOffset
        ];
    }

    public function countUnreadNotifications()
    {
        $userId = auth()->id();
        $count = UserNotification::where([
            'user_id' => $userId,
            'read_all' => NOTIFICATION_UNREAD
        ])->count();
        return $count;
    }

    public function markRead(int $notificationId)
    {
        $userId = auth()->id();
        $notifiation = UserNotification::where([
            'id' => $notificationId,
            'user_id' => $userId
        ])->first();
        if ($notifiation) {
            $notifiation->read = NOTIFICATION_READ;
            $notifiation->save();
        }
        return true;
    }

    public function markReadAll()
    {
        $userId = auth()->id();
        $notifiations = UserNotification::where([
            'user_id' => $userId,
            'read_all' => NOTIFICATION_UNREAD
        ])->update([
            'read_all' => NOTIFICATION_READ
        ]);
        return true;
    }
}
