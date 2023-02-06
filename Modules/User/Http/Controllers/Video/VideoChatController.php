<?php

namespace Modules\User\Http\Controllers\Video;

use App\Services\User\VideoChatService;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Events\VideoChat\StartVideoChat;

class VideoChatController extends Controller
{
    use ApiResponse;
    private $videoChatService;

    public function __construct(VideoChatService $videoChatService)
    {
        $this->videoChatService = $videoChatService;
    }

    public function callUser(Request $request)
    {
        $data = $request->all();
        $result = $this->videoChatService->call($data);
        return $this->responseData($result);
    }

    public function acceptCall(Request $request)
    {
        $data['signal'] = $request->signal;
        $data['to'] = $request->to;
        $data['type'] = 'callAccepted';
        broadcast(new StartVideoChat($data))->toOthers();
    }
}
