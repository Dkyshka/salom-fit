@extends('web.layouts.app')

@section('content')
    <div class="wrapper">
        <header class="header">
            <div class="header__container">
            </div>
        </header>
        <main class="page">

            <section class="auth">
                <div class="auth__container">

                    <a href="{{ url()->previous() }}" class="page__back _icon-back"></a>

                    <div class="auth__top">
                        <h1 class="auth__title title">Авторизоваться</h1>
                        <div class="auth__text">Введите личные данные</div>
                    </div>

                    <form action="{{ route('auth') }}" class="auth__form form-auth" method="POST">
                        @csrf
                        <div class="form-auth__body">
                            <div class="form-auth__groop">
                                <label for="phone" class="form-auth__title">Номер телефона</label>
                                <input id="phone" autocomplete="off" type="text" name="phone" placeholder="+998 99 999 99 99" class="form-auth__input input" value="{{ old('phone') }}">
                                @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-auth__groop">
                                <label for="password" class="form-auth__title">Пароль</label>
                                <input id="password" autocomplete="off" type="password" name="password" placeholder="Ваш пароль" class="form-auth__input input">
                                @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="auth__bottom">
                            <div class="form-auth__link active">Нет аккаунта? <a href="{{ route('register') }}">Пройдите регистрацию</a> </div>
                            <button class="form-auth__button button">Войти</button>
                        </div>

                    </form>


                </div>
            </section>

        </main>
        <footer class="footer">
            <div class="footer__container">
            </div>
        </footer>
    </div>
@endsection