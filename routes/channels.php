<?php

use App\Models\Post;
use App\Models\VideoChat;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('9a2fadf0-c697-4b83-ba75-89873b996845.{userId}', function ($user, $userId) {
    Log::info('Channel Auth User Notification', [
        'user_id' => $userId,
        'user' => $user,
        'result' => $user->id == $userId
    ]);
    return $user->id == $userId;
});

Broadcast::channel('fd25b0f2-fdaa-4c67-a8d4-f09c48e6790a.{userId}', function ($user, $userId) {
    Log::info('Channel Auth User Message', [
        'user_id' => $userId,
        'user' => $user,
        'result' => $user->id == $userId
    ]);
    return $user->id == $userId;
});

Broadcast::channel('presence-video-channel.{uuid}', function ($user, $uuid) {
    $videoChat = VideoChat::where('uuid', $uuid)
        ->where('caller', '!=', 'receiver')
        ->orWhere([
            'caller' => $user->id,
            'receiver' => $user->id
        ])->first();
    if ($videoChat) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    return false;
});

Broadcast::channel('video-chat-incomming.{user_id}', function ($user, $user_id) {
    return (int)$user->id === (int)$user_id;
});
