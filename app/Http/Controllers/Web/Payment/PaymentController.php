<?php

namespace App\Http\Controllers\Web\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Plan;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function payment(Request $request, ?Plan $plan)
    {
        return view('web.payment', compact('plan'));
    }

    /**
     * Создание карты и сохранение токена
     */
    public function store(PaymentRequest $paymentRequest, ?Plan $plan)
    {
        $user = auth()->user();

        $paymentRequest->merge([
            'expiry_date' => str_replace('/', '', $paymentRequest->expiry_date),
        ]);

        $data = [
            'id' => $user->id,
            'method' => 'cards.create',
            'params' => [
                'card' => [
                    'number' => $paymentRequest->card_number,
                    'expire' => $paymentRequest->expiry_date,
                ],
                'save' => (bool)$paymentRequest->remember,
                'customer' => $user->phone
            ]
        ];

        return $this->sendPayme($data);
    }

    /**
     * Получение кода потверждения
     */
    public function getVerifyCode()
    {

    }
    
    public function sendPayme(array $data = [])
    {
        $response = Http::withHeaders([
            'X-Auth' => env('PAYME_ID_SUBSCRIBE'),
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'application/json',
        ])->post(env('PAYME_URL_SUBSCRIBE'), $data);

        // Проверяем, успешен ли запрос
        if ($response->successful()) {
            $result = $response->json();

            if (isset($result['error'])) {
                Log::build([
                    'driver' => 'single',
                    'path' => storage_path('logs/subscribe.log'),
                ])->info(json_encode($result['error'], JSON_UNESCAPED_UNICODE));

                return response()->json([
                    'error' => $result['error']['message'],
                ], $response->status());

            }

            return response()->json($response->json());
        }

        return response()->json([
            'error' => 'Произошла ошибка при отправке запроса',
        ], $response->status());
    }
}
