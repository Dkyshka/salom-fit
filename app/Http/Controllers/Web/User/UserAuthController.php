<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserWebAuthRequest;
use App\Http\Requests\UserWebRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function auth(UserWebAuthRequest $userWebAuthRequest): \Illuminate\Http\RedirectResponse
    {
        if (Auth::attempt($userWebAuthRequest->validated())) {
            $userWebAuthRequest->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'phone' => 'Неверный номер или пароль',
        ])->onlyInput('phone');
    }

    public function register(UserWebRegisterRequest $userWebRegisterRequest)
    {
        // Создание нового пользователя
        $user = User::create([
            'name' => $userWebRegisterRequest->name,
            'phone' => $userWebRegisterRequest->phone,
            'password' => $userWebRegisterRequest->password,
            'in_auth' => true,
        ]);

        // Авторизация пользователя
        Auth::login($user);

        // Возврат успешного ответа или редирект
        return redirect(route('cabinet'));
    }
}
