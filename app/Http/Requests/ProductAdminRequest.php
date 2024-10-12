<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'video' => ['nullable', 'mimes:mp4,avi,mkv', 'max:10240'], // до 10 МБ
            'picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // Картинка не более 2мб
            'chat_id' => ['required', 'exists:chats,id'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Введите имя',
            'price.required' => 'Введите цену',
            'description.required' => 'Введите описание',
            'chat_id.required' => 'Выберете чат',
            'chat_id.exists' => 'Такого чата нет',
        ];
    }
}
