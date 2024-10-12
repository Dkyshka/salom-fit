<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserWebRegisterRequest extends FormRequest
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
            'name' => ['required', 'min:5'],
            'phone' => ['required', 'unique:users', 'regex:/^998\d{9}$/'],
            'password' => ['required', 'min:5']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите логин',
            'name.min' => 'Логин должен быть больше 5 символов',
            'phone.required' => 'Введите телефон',
            'phone.unique' => 'Телефон уже занят',
            'phone.regex' => 'Неккоректный номер телефона',
            'password.required' => 'Введите пароль',
            'password.min' => 'Пароль должен быть больше 5 символов',
        ];
    }
}
