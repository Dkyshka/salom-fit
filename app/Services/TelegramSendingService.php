<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TelegramSendingService
{
    protected string $token;
    protected string $key_location;

    public function __construct()
    {
        $this->token = env('TELEGRAM_BOT_TOKEN_DEV');
    }

    public function sendMessage(int $chat_id, string $message): void
    {
        $data = [
            "chat_id" => $chat_id,
            "text" => $message,
            "parse_mode" => "html"
        ];

        $this->sendRequest('/sendMessage', $data);
    }

    public function replyMessage(int $chat_id, int $message_id, string $message): void
    {
        $data = [
            "chat_id" => $chat_id,
            "text" => $message,
            "parse_mode" => "html",
            "reply_to_message_id" => $message_id
        ];

        $this->sendRequest('/sendMessage', $data);
    }
//
    public function removeMessage($chat_id, int $messageId)
    {
        $data = [
            "chat_id" => $chat_id,
            "message_id" => $messageId
        ];

        $this->sendRequest('/deleteMessage', $data);
    }

    public function sendInlineKeyboard(int $chat_id, string $message, array $keyboard)
    {
        $data = [
            "chat_id" => $chat_id,
            "text" => $message,
            "parse_mode" => "html",
            'protect_content' => true,
            'reply_markup' => json_encode([
                'inline_keyboard' => $keyboard,
            ]),
        ];

        $this->sendRequest('/sendMessage', $data);
    }

    public function sendKeyboard(int $chat_id, string $message, array $keyboard)
    {
        $data = [
            "chat_id" => $chat_id,
            "text" => $message,
            "parse_mode" => "html",

            'reply_markup' => json_encode([
                'keyboard' => $keyboard,
                'one_time_keyboard' => false, // отключить скрытие меню
                'resize_keyboard' => true, // отключить адаптацию кнопок по высоте
            ]),
        ];

        $this->sendRequest('/sendMessage', $data);
    }

    public function sendVideo(int $chat_id, string $video_path, string $caption = '', array $keyboard = [])
    {
        $data = [
            'chat_id' => $chat_id,
            'supports_streaming' => true,
//            'video' => 'BAACAgIAAxkBAAIDfmbzy9LH9nRylSdTc8RktuqSwGxBAALYYAACB36YSxB-geKsJigfNgQ', // путь к видеофайлу или URL
            'video' => $video_path, // путь к видеофайлу или URL
            'caption' => $caption,
            'parse_mode' => 'html', // если требуется форматирование
            'reply_markup' => json_encode([
                'inline_keyboard' => $keyboard,
            ])
        ];

        $this->sendRequest('/sendVideo', $data);
    }


    public function sendPhoto(int $chat_id, string $caption, string $image, array $keyboard = [])
    {
//        $data = [
//            "chat_id" => $chat_id,
//            'caption' => $caption,
//            'photo' => $image,
//            'reply_markup' => json_encode([
//                'inline_keyboard' => $keyboard,
//            ]),
//
//        ];
//
//        $this->sendRequest('/sendPhoto', $data);


        // Подготовка данных для запроса
        $data = [
            'chat_id' => $chat_id,
            'caption' => $caption,
            'photo' => curl_file_create($image), // Путь к файлу
            'reply_markup' => json_encode([
                'inline_keyboard' => $keyboard,
            ]),
        ];

        // Инициализация cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot' . $this->token . '/sendPhoto');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // Выполнение запроса и закрытие cURL
        $response = curl_exec($ch);

        // Проверка на ошибки cURL
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            // Логирование ошибки, если что-то пошло не так
            Log::error('Ошибка cURL: ' . $error_msg);
        }

        curl_close($ch);

        // Логирование ответа Telegram API
        Log::info('Ответ Telegram: ' . $response);

        return $response;
    }
//
//    public function sendFile()
//    {
//        $data = [
//            "chat_id" => self::CHAT_ID,
//            'caption' => 'Это Хасбик',
//            'document' => curl_file_create(storage_path('app/public/hasbik.jpg')),
////            'protect_content' => true, // Запрещает сохранение и пересылку
//        ];
//
//        $ch = curl_init("https://api.telegram.org/bot" . self::TOKEN . "/sendDocument");
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_HEADER, false);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        $result = curl_exec($ch);
//        curl_close($ch);
//
//    }
//
    public function sendPhone(int $chat_id, string $message, array $keyboard)
    {
        $data = [
            "chat_id" => $chat_id,
            "text" => $message,
            "parse_mode" => "html",

            'reply_markup' => json_encode([
                'keyboard' => $keyboard,
                'one_time_keyboard' => false,
                'resize_keyboard' => true,
            ]),
        ];

        $this->sendRequest('/sendMessage', $data);
    }


//    public static function editMessageReplyMarkup($chat_id, string $message_id, $keyboard)
//    {
//        $data = [
//            'chat_id' => $chat_id,
//            'message_id' => $message_id,
//            'reply_markup' => json_encode([
//                'inline_keyboard' => $keyboard,
//            ]),
//        ];
//
//        $ch = curl_init("https://api.telegram.org/bot" . self::TOKEN . "/editMessageReplyMarkup");
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_HEADER, false);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        $result = curl_exec($ch);
//        curl_close($ch);
//
//        return json_decode($result);
//    }

    // Метод для одобрения динамического
    public function approveJoinForeverRequest($user_id, $chat_id)
    {
        $data = [
            'chat_id' => $chat_id,
            'user_id' => $user_id,
        ];

        $this->sendRequest('/approveChatJoinRequest', $data);
    }

    // Метод для одобрения запроса на вступление
    public function approveJoinRequest($user_id)
    {
        $privateChat = env('TELEGRAM_BOT_CHANNEL_PROD');

        $data = [
            'chat_id' => $privateChat,
            'user_id' => $user_id,
        ];

        $this->sendRequest('/approveChatJoinRequest', $data);
    }

    public function getChatMember(int $chat_id, int $user_id)
    {
        $data = [
            'chat_id' => $chat_id, // ID канала или группы
            'user_id' => $user_id,
        ];

        try {
            $response = Http::post('https://api.telegram.org/bot'.$this->token.'/getChatMember', $data)->throw();
            // Получаем тело ответа как массив
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Непредвиденная ошибка: ' . $e->getMessage());
        }

        return null;
    }

    // Метод для отклонения запроса на вступление
    public function declineJoinRequest($chat_id, $user_id)
    {
        $privateChat = env('TELEGRAM_BOT_CHANNEL');

        $data = [
            'chat_id' => $privateChat,
            'user_id' => $user_id,
        ];
        $this->sendRequest('/declineChatJoinRequest', $data);
    }



    public function answerCallback($chat_id, int $callback_id, string $msg)
    {
        $data = [
            "chat_id" => $chat_id,
            "callback_query_id" => $callback_id,
            "text" => $msg
        ];

        $this->sendRequest('/answerCallbackQuery', $data);
    }

    public function sendRequest(string $url, array $data): void
    {
        try {
            Http::post('https://api.telegram.org/bot'.$this->token.$url, $data)->throw();
        } catch (\Exception $e) {
            Log::error('Непредвиденная ошибка: ' . $e->getMessage());
        }
    }


}