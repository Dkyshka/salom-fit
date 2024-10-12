<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatAdminRequest extends FormRequest
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
            'name' => 'required',
            'link' => 'required',
            'chat_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Введите имя',
            'link.required' => 'Введите ссылку',
            'chat_id.required' => 'Введите CHAT ID',
        ];
    }
}
