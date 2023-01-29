<?php

namespace App\Services\User;

use App\Models\Message;
use App\Models\User;
use App\Models\UserMessage;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\User\Events\MessageEvent;

class MessageService
{
    public function sendMessage(int $to, string $message)
    {
        DB::beginTransaction();
        try {
            $userId = auth()->id();
            $chatSender = UserMessage::where('user_receive_id', $to)->first();
            $chatReceiver = UserMessage::where('user_id', $userId)->first();
            $userSendMessage = User::where('id', $userId)->first();

            if (!$chatSender) {
                $chatSender = self::addUserToChatList($userId, $to);
            } else {
                $chatSender->last_time_message = now();
                $chatSender->save();
            }

            if (!$chatReceiver) {
                $chatReceiver = self::addUserToChatList($to, $userId);
            } else {
                $chatReceiver->last_time_message = now();
                $chatReceiver->save();
            }

            $message = Message::create([
                'sender' => $userId,
                'receiver' => $to,
                'message' => $message
            ]);
            MessageEvent::dispatch($message, $chatReceiver, $userSendMessage);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
        return $message;
    }

    public function listChat(int $offset = 0)
    {
        $userId = auth()->id();
        $list = UserMessage::with('userReceive')->where('user_id', $userId)
            ->orderBy('last_time_message', 'DESC')->limit(LIMIT_CHAT_LIST)->offset($offset)->get();
        $newOffset = count($list) == LIMIT_CHAT_LIST ? $offset + LIMIT_CHAT_LIST : NULL;
        return array(
            'chat_list' => $list,
            'offset' => $newOffset
        );
    }

    public function getMessages($receiver, $offset = 0)
    {
        $userId = auth()->id();
        $messages = Message::where([
            'sender' => $userId,
            'receiver' => $receiver
        ])->orWhere([
            'sender' => $receiver,
            'receiver' => $userId
        ])->orderBy('created_at', 'DESC')
            ->limit(LIMIT_CHAT_MESSAGE)->offset($offset)->get();
        $newOffset = count($messages) == LIMIT_CHAT_MESSAGE ? $offset += LIMIT_CHAT_MESSAGE : null;
        $result = array(
            'messages' => $messages,
            'offset' => $newOffset
        );
        return $result;
    }

    public function markReadChat($idChat)
    {
        $userId = auth()->id();
        $chat = UserMessage::where([
            'id' => $idChat,
            'user_id' => $userId
        ])->first();
        $chat->read = READ_MESSAGE;
        $chat->save();
        return true;
    }

    public function getUnreadChat() {
        $userId = auth()->id();
        return UserMessage::where([
            'user_id' => $userId,
            'read' => UNREAD_MESSAGE
        ])->get();
    }

    function addUserToChatList($id, $to)
    {
        return UserMessage::create([
            'user_id' => $id,
            'user_receive_id' => $to,
            'last_time_message' => now()
        ]);
    }
}
