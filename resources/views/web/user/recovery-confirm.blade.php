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

                    <a href="#" class="page__back _icon-back"></a>

                    <div class="auth__top">
                        <h1 class="auth__title title">Придумайте пароль</h1>
                        <div class="auth__text">Введите пароль</div>
                    </div>

                    <form action="#" class="auth__form form-auth">
                        <div class="form-auth__body">
                            <div class="form-auth__groop">
                                <label for="inp1" class="form-auth__title">Пароль</label>
                                <input id="inp1" autocomplete="off" type="text" name="form[]" placeholder="Ваш пароль" class="form-auth__input input">
                            </div>
                        </div>

                        <div class="auth__bottom">
                            <button class="form-auth__button button">Подвертдить</button>
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