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
                        <h1 class="auth__title title">Регистрация</h1>
                        <div class="auth__text">Введите личные данные</div>
                    </div>

                    <form action="{{ route('auth_register') }}" class="auth__form form-auth" method="POST">
                        @csrf
                        <div class="form-auth__body">
                            <div class="form-auth__groop">
                                <label for="name" class="form-auth__title">Логин</label>
                                <input id="name" autocomplete="off" type="text" name="name" placeholder="Jhon" class="form-auth__input input">
                                @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-auth__groop">
                                <label for="phone" class="form-auth__title">Номер телефона</label>
                                <input id="phone" autocomplete="off" type="text" name="phone" placeholder="+998 99 999 99 99" class="form-auth__input input">
                                @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-auth__groop">
                                <label for="inp1" class="form-auth__title">Пароль</label>
                                <input id="inp1" autocomplete="off" type="password" name="password" placeholder="Ваш пароль" class="form-auth__input input">
                                @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="auth__bottom">

                            <a href="{{ route('login') }}" class="form-auth__link active">Уже есть аккаунт?</a>

                            <button class="form-auth__button button">Зарегистрироваться</button>
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