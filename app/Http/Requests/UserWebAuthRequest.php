<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserWebAuthRequest extends FormRequest
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
            'phone' => preg_replace('/[\s+]+/', '', $this->phone),
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
            'phone' => ['required', 'exists:users,phone', 'regex:/^998\d{9}$/'],
            'password' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'Введите телефон',
            'phone.regex' => 'Неккоректный номер телефона',
            'phone.exists' => 'Такого пользователя не существует',
            'password.required' => 'Введите пароль',
        ];
    }
}
