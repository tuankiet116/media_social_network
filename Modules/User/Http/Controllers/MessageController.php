<?php

namespace Modules\User\Http\Controllers;

use App\Services\User\MessageService;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MessageController extends Controller
{
    use ApiResponse;

    private $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function message(Request $request)
    {
        $to = $request->get('to');
        $message = $request->get('message');
        $message = $this->messageService->sendMessage($to, $message);
        return $this->responseData($message);
    }

    public function getListChat(Request $request)
    {
        $offset = $request->query('offset');
        $result = $this->messageService->listChat($offset);
        return $this->responseData($result);
    }

    public function getMessages(Request $request, int $receiver)
    {
        $offset = $request->query('offset');
        $result = $this->messageService->getMessages($receiver, $offset);
        return $this->responseData($result);
    }

    public function markReadChat(Request $request)
    {
        $idChat = $request->get('id_chat');
        $result = $this->messageService->markReadChat($idChat);
        return $this->responseData($result);
    }

    public function getUnreadChat() {
        $result = $this->messageService->getUnreadChat();
        return $this->responseData($result);
    }
}
