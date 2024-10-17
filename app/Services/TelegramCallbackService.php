<?php

namespace App\Services;

use App\Models\JoinChatRequest;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class TelegramCallbackService
{
    public User $user;
    public Setting $setting;

    public function __construct(public int $chat_id)
    {
        $this->user = User::where('chat_id', $this->chat_id)->first();
        $this->setting = Setting::first();
    }

    public function process(string $callback, string $callback_id, $message_id)
    {
        if ($callback === 'offer_success') {

            if (!$this->user->confirm_offer) {

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

                (new TelegramSendingService())
                    ->sendVideo($this->user->chat_id, url('files/videos/lesson.mp4'), '', $keyboard);
            }

            $this->user->update([
                'confirm_offer' => true
            ]);

            // Подтверждаем обработку callback
            (new TelegramSendingService())->answerCallback($this->user->chat_id, $callback_id, '✅');

            (new TelegramSendingService())->removeMessage($this->user->chat_id, $message_id);
        }


        if ($callback === 'action_tariff') {

            (new TelegramSendingService())->answerCallback($this->user->chat_id, $callback_id, '✅');

            (new TelegramSendingService())->removeMessage($this->user->chat_id, $message_id);

            $message = MessageReplaceBrService::replacing($this->setting->markup?->tariff_description);

            $plans = \App\Models\Plan::all();
            $keyboard = [];

            foreach ($plans as $plan) {
                $keyboard[] = [
                    [
                        'text' => $plan->name, // Выводим название тарифа
                        'callback_data' => 'tariff_' . $plan->id // Указываем callback_data с ID тарифа
                    ]
                ];
            }

            $keyboard[] = [
                [
                    'text' => '⬅ Orqaga', // Текст кнопки
                    'callback_data' => 'go_back' // callback_data для обработки кнопки "Назад"
                ]
            ];

            (new TelegramSendingService())
                ->sendInlineKeyboard($this->user->chat_id, $message, $keyboard);
        }

        if ($callback === 'action_courses') {
            (new TelegramSendingService())->answerCallback($this->user->chat_id, $callback_id, '✅');

            (new TelegramSendingService())->removeMessage($this->user->chat_id, $message_id);

            $message = MessageReplaceBrService::replacing($this->setting->markup?->products_description);

            $products = \App\Models\Product::all();
            $keyboard = [];

            foreach ($products as $product) {
                $keyboard[] = [
                    [
                        'text' => $product->name, // Выводим название продукта
                        'callback_data' => 'product_' . $product->id // Указываем callback_data с ID продукта
                    ]
                ];
            }

            $keyboard[] = [
                [
                    'text' => '⬅ Orqaga', // Текст кнопки
                    'callback_data' => 'go_back' // callback_data для обработки кнопки "Назад"
                ]
            ];

            (new TelegramSendingService())
                ->sendInlineKeyboard($this->user->chat_id, $message, $keyboard);

        }

//        if ($callback === 'action_about') {
//            (new TelegramSendingService())->answerCallback($this->user->chat_id, $callback_id, '✅');
//
//            (new TelegramSendingService())->removeMessage($this->user->chat_id, $message_id);
//
//            $keyboard = [
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
//                        'text' => '⬅ Orqaga', // Текст кнопки
//                        'callback_data' => 'go_back' // callback_data для обработки кнопки "Назад"
//                    ]
//                ]
//            ];
//
//            $message = MessageReplaceBrService::replacing($this->setting->markup?->about);
//
//            (new TelegramSendingService())
//                ->sendInlineKeyboard($this->user->chat_id, $message, $keyboard);
//        }


        // Callback tariff
        if (str_starts_with($callback, 'tariff_')) {

            (new TelegramSendingService())->answerCallback($this->user->chat_id, $callback_id, '✅');

            // Получаем ID тарифа из callback_data
            $tariff_id = (int)str_replace('tariff_', '', $callback);

            // Получаем тариф по ID
            $tariff = \App\Models\Plan::find($tariff_id);

            if ($tariff) {

                (new TelegramSendingService())->removeMessage($this->user->chat_id, $message_id);

                $message = MessageReplaceBrService::replacing($this->setting->markup?->payment);

                $keyboard = [
                    [
                        [
                            'text' => 'Karta orqali to`lov (Powered by Payme)',
                            'web_app' => [
                                // Тут меняем домен
                                'url' => "https://poddomen.jahoncommunitybot.uz/checkout/$tariff->id/".$this->user->id
                            ]
                        ],
                    ],
                    [
                        [
                            'text' => "🤵 Menejer bilan bog'lanish",
                            'url' => $this->setting->markup?->manager,
                        ]
                    ],
                    [
                        [
                            'text' => '⬅ Orqaga',
                            'callback_data' => 'action_tariff'
                        ]
                    ]
                ];

                (new TelegramSendingService())
                    ->sendInlineKeyboard($this->user->chat_id, $message, $keyboard);

            } else {
                (new TelegramSendingService())->sendMessage($this->user->chat_id, 'Tarif qanday?');
            }

        }

        // Callback product
        if (str_starts_with($callback, 'product_')) {

            (new TelegramSendingService())->answerCallback($this->user->chat_id, $callback_id, '✅');

            (new TelegramSendingService())->removeMessage($this->user->chat_id, $message_id);

            // Получаем ID продукта из callback_data
            $product_id = (int)str_replace('product_', '', $callback);

            // Получаем продукт по ID
            $product = \App\Models\Product::find($product_id);

            if ($product) {

                (new TelegramSendingService())->removeMessage($this->user->chat_id, $message_id);

                $message = MessageReplaceBrService::replacing($product?->description);

                $requestChat = JoinChatRequest::where('user_id', $this->user->chat_id)
                    ->where('chat_id', $product->chat->chat_id)
                    ->first();

                $keyboard = [
                    [
                        [
                            'text' => "Kanalga obuna bo'lish",
                            'url' => $product->chat->link  // Ссылка на приглашение в канал
                        ]
                    ],
                ];

                // Проверяем, существует ли запрос на присоединение
                if (!$requestChat) {
                    // Если запроса нет, добавляем кнопку подтверждения
                    $keyboard[] = [
                        [
                            'text' => "Obuna boʻlishni tasdiqlang",
                            'callback_data' => "confirm_$product->id"  // `callback_data` для дальнейшего взаимодействия
                        ]
                    ];
                }

                // Добавляем кнопку "⬅ Orqaga"
                $keyboard[] = [
                    [
                        'text' => '⬅ Orqaga',
                        'callback_data' => 'action_courses'
                    ]
                ];

//                $keyboard = [
//                    [
//                        [
//                            'text' => "Kanalga obuna bo'lish",
//                            'url' => $product->chat->link  // Ссылка на приглашение в канал
//                        ]
//                    ],
//                    [
//                        [
//                            'text' => "Obuna boʻlishni tasdiqlang",
//                            'callback_data' => "confirm_$product->id"  // `callback_data` для дальнейшего взаимодействия
//                        ]
//                    ],
//                    [
//                        [
//                            'text' => '⬅ Orqaga',
//                            'callback_data' => 'action_courses'
//                        ]
//                    ]
//                ];


                if ($product?->video) {
                    (new TelegramSendingService())
                        ->sendVideo($this->user->chat_id, $product->video, $message, $keyboard);
                } else if($product->picture()) {
                    (new TelegramSendingService())
                        ->sendPhoto($this->user->chat_id, $message, $product->picture()?->orig, $keyboard);
                } else {
                    (new TelegramSendingService())
                        ->sendInlineKeyboard($this->user->chat_id, $message, $keyboard);
                }


            } else {
                (new TelegramSendingService())->sendMessage($this->user->chat_id, 'Product qanday?');
            }

        }

        if (str_starts_with($callback, 'confirm_')) {

            (new TelegramSendingService())->answerCallback($this->user->chat_id, $callback_id, '✅');

            (new TelegramSendingService())->removeMessage($this->user->chat_id, $message_id);

            // Получаем ID продукта из callback_data
            $product_id = (int)str_replace('confirm_', '', $callback);

            // Получаем продукт по ID
            $product = \App\Models\Product::find($product_id);

            if ($product) {

                $requestChat = JoinChatRequest::where('user_id', $this->user->chat_id)
                    ->where('chat_id', $product->chat->chat_id)
                    ->first();

                if (!$requestChat) {

                    $message = "Qo'shilish uchun arizangizni yuboring";

                    $keyboard = [
                        [
                            [
                                'text' => "Kanalga obuna bo'lish",
                                'url' => $product->chat->link  // Ссылка на приглашение в канал
                            ]
                        ],
                        [
                            [
                                'text' => "Obuna boʻlishni tasdiqlang",
                                'callback_data' => "confirm_$product->id"  // `callback_data` для дальнейшего взаимодействия
                            ]
                        ],
                        [
                            [
                                'text' => '⬅ Orqaga',
                                'callback_data' => 'action_courses'
                            ]
                        ]
                    ];

                } else {

                    $message = MessageReplaceBrService::replacing($product?->description);

                    $keyboard = [
                        [
                            [
                                'text' => 'Karta orqali to`lov (Powered by Payme)',
                                'web_app' => [
                                    // Тут меняем домен
                                    'url' => "https://poddomen.jahoncommunitybot.uz/checkout/$product->id/" . $this->user->id
                                ]
                            ],
                        ],
                        [
                            [
                                'text' => "🤵 Menejer bilan bog'lanish",
                                'url' => $this->setting->markup?->manager,
                            ]
                        ],
                        [
                            [
                                'text' => '⬅ Orqaga',
                                'callback_data' => 'action_courses'
                            ]
                        ]
                    ];

                }

                if ($product?->video) {
                    (new TelegramSendingService())
                        ->sendVideo($this->user->chat_id, url('/').'/'. $product->video, $message, $keyboard);
                } else if($product->picture()) {
                    (new TelegramSendingService())
                        ->sendPhoto($this->user->chat_id, $message, url('/').'/'. $product->picture()?->orig, $keyboard);
                } else {
                    (new TelegramSendingService())
                        ->sendInlineKeyboard($this->user->chat_id, $message, $keyboard);
                }
            } else {
                (new TelegramSendingService())->sendMessage($this->user->chat_id, 'Product qanday?');
            }
        }

        // Back
        if ($callback === 'go_back') {
            (new TelegramSendingService())->answerCallback($this->user->chat_id, $callback_id, '✅');

            (new TelegramSendingService())->removeMessage($this->user->chat_id, $message_id);

            (new TelegramActionsService($this->user, $this->setting))->main();
        }
    }
}