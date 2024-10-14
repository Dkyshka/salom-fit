<?php

namespace App\Actions;

use App\Models\JoinRequest;
use App\Models\Setting;
use App\Services\JoinRequest\JoinRequestService;
use App\Services\MessageReplaceBrService;
use App\Services\TelegramCallbackService;
use App\Services\TelegramContactService;
use App\Services\TelegramMessageService;
use App\Services\TelegramSendingService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TelegramRouteAction
{
    public Setting $setting;

    public function __construct()
    {
        $this->setting = Setting::first();
    }

    /**
     * Обработка событий пользователя
     *
     * @param Object $data
     * @return void
     */
    public function handle(Object $data): void
    {
        try {
            $callback = $data?->callback_query ?? null;
            $chat_id = $callback ? $callback->from->id : ($data->message?->chat?->id ?? null);
            $message = $data?->message?->text ?? null;
            $contacts = $data?->message?->contact?->phone_number ?? null;
            $join = $data?->chat_join_request ?? null;
            $chat_id = $chat_id ? $chat_id : ($join?->from?->id ?? null);

            if ($message) {
                (new TelegramMessageService($chat_id))->message($message);
            } elseif($contacts) {
                (new TelegramContactService($chat_id))->process($contacts);
            } elseif($callback) {
                (new TelegramCallbackService($chat_id))->process($callback->data, $callback->id, $callback->message->message_id);
            } elseif($join) {
                JoinRequestService::handle($join);
            }

        } catch (\Exception $e) {
            Log::error('Ошибка в обработке сообщения' . $e->getMessage());
        }
    }
}