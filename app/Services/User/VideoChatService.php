<?php

namespace App\Services\User;

use App\Models\VideoChat;
use Modules\User\Events\VideoChat\Incomming;
use Illuminate\Support\Str;

class VideoChatService
{
    public function call($data)
    {
        $videoChat = VideoChat::create([
            'caller' => auth()->id(),
            'receiver' => $data['to'],
            'uuid' => Str::uuid()
        ]);
        Incomming::dispatch($videoChat, auth()->user());
        return $videoChat;
    }

    public function accept($data)
    {
        $userId = auth()->id();
        $videoChat = VideoChat::where([
            'uuid' => $data['uuid']
        ])->orWhere([
            'caller' => $userId,
            'receiver' => $userId,
        ]);
        $videoChat->is_accepted = true;
        $videoChat->save();
        return $videoChat;
    }

    public function decline($data)
    {
        $userId = auth()->id();
        $videoChat = VideoChat::where([
            'uuid' => $data['uuid']
        ])->orWhere([
            'caller' => $userId,
            'receiver' => $userId,
        ]);
        $videoChat->is_accepted = false;
        $videoChat->save();
        return $videoChat;
    }

    public function startVideoChat()
    {

    }
}
