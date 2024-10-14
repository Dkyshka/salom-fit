<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'card' => preg_replace('/\s+/', '', $this->card),
            'card_date' => preg_replace('/\s+/', '', $this->card_date), // Убираем пробелы
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'card' => ['required', 'regex:/^\d{16}$/'], // Регулярка для проверки 16 цифр
            'card_date' => [
                'required',
                'regex:/^(0[1-9]|1[0-2])\/?([0-9]{2})$/', // Формат ММ/ГГ
                function ($attribute, $value, $fail) {
                    // Проверка корректности месяца и года
                    [$month, $year] = explode('/', $value);

                    // Текущая дата
                    $currentYear = now()->format('y');
                    $currentMonth = now()->format('m');

                    // Проверка на прошлую дату
                    if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth)) {
                        $fail('Дата истечения срока не может быть в прошлом.');
                    }
                }
            ],
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
