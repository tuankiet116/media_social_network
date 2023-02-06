<?php

namespace App\Services\User;

use App\Models\VideoChat;
use Modules\User\Events\VideoChat\Incomming;

class VideoChatService
{
    public function call($data)
    {
        $videoChat = VideoChat::create([
            'caller' => auth()->id(),
            'receiver' => $data['to']
        ]);

        Incomming::dispatch($videoChat);
        return $videoChat;
    }

    public function answer($data)
    {
        if ($data['decline']) {

        } else if ($data['accept']) {
        }
    }

    public function startVideoChat() {
        
    }
}
