<?php

namespace App\Services\JoinRequest;

use App\Models\JoinChatRequest;
use App\Models\JoinRequest;

class JoinRequestService
{
    public static function handle($data)
    {
        JoinRequest::updateOrCreate([
            'chat_id' => $data->chat->id
        ], [
            'name' => $data->chat->title,
            'chat_id' => $data->chat->id
        ]);

        JoinChatRequest::updateOrCreate(
            [
                'user_id' => $data->user_chat_id,
                'chat_id' => $data->chat->id
            ],
            [
                'user_id' => $data->user_chat_id,
                'chat_id' => $data->chat->id
            ],
        );
    }
}