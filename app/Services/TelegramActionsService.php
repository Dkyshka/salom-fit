<?php

namespace App\Services;

use App\Actions\CheckLocaleMessageAction;
use App\Actions\UserUpdateStepAction;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class TelegramActionsService
{
    public function __construct(public User $user, public Setting $setting)
    {
    }

    public function main()
    {
        (new UserUpdateStepAction())->update($this->user, 'main');

        $message = MessageReplaceBrService::replacing($this->setting->markup?->greetings);

        if (!$this->user->confirm_offer) {

            $keyboard = [
                [
                    [
                        'text' => '📑 Ommaviy oferta',
                        'url' => url('files/oferta.pdf'),
                    ],
                ],
                [
                    [
                        'text' => 'Oferta shartlariga roziman',
                        'callback_data' => 'offer_success',
                    ]
                ]
            ];

        } else {

//            $keyboard = [
//                [
//                    [
//                        'text' => "Kanalga obuna bo'lish",
//                        'url' => env('TELEGRAM_BOT_CHANNEL_INVITE_PROD')
//                    ]
//                ],
//                [
//                    [
//                        'text' => 'Shaxsiy hisob',
//                        'web_app' => [
//                            'url' => "https://jahoncommunitybot.uz/telegram"
//                        ]
//                    ]
//                ],
//                [
//                    [
//                        'text' => '💳 Tariflar',
//                        'callback_data' => 'action_tariff'
//                    ],
//                ],
//                [
//                    [
//                        'text' => "🤵 Menejer bilan bog'lanish",
//                        'url' => $this->setting->markup?->manager,
//                    ]
//                ],
//                [
//                    [
//                        'text' => "🔎 Kanal haqida batafsil",
//                        'callback_data' => 'action_about',
//                    ]
//                ]
//            ];

            $keyboard = [
                [
                    [
                        'text' => 'Salomfit kurslar',
                        'callback_data' => 'action_courses'
                    ],
                ],
//            [
//                [
//                    'text' => "Erkak community",
//                    'callback_data' => 'action_tariff'
//                ]
//            ],
                [
                    [
                        'text' => "🤵 Menejer bilan bog'lanish",
                        'url' => $this->setting->markup?->manager,
                    ]
                ],
            ];

        }



        (new TelegramSendingService())->sendInlineKeyboard($this->user->chat_id, $message, $keyboard);
    }
}