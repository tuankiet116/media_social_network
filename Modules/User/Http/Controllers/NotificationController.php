<?php

namespace Modules\User\Http\Controllers;

use App\Services\User\NotificationService;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NotificationController extends Controller
{
    use ApiResponse;
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getNotifications(Request $request)
    {
        $offset = $request->query('offset') ?? 0;
        $result = $this->notificationService->getNotifications($offset);
        return $this->responseData($result);
    }

    public function getCountUnread() {
        $count = $this->notificationService->countUnreadNotifications();
        return $this->responseData(['count' => $count]);
    }

    public function markReadAllNotifications()
    {
        $result = $this->notificationService->markReadAll();
        return $this->responseData($result);
    }

    public function markReadNotification(Request $request, $id)
    {
        $result = $this->notificationService->markRead($id);
        return $this->responseData($result);
    }
}
