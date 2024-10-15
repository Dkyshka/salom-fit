@extends('web.layouts.app')

@section('content')

    <div class="wrapper">
        <header class="header">
            <div class="header__container">
            </div>
        </header>
        <main class="page">

            <section class="pay">
                <div class="pay__container">

                    <a href="{{ route('tariffs') }}" class="page__back _icon-back"></a>

                    <div class="pay__top">
                        <h1 class="pay__title title">Оплата</h1>
                        <p class="pay__text">{{ $plan->name }} — <b>{{ $plan->price ? number_format($plan->price, 0, '', ' ') : '' }}</b>
                        </p>
                    </div>

                    <div id="errors"></div>

                    <form action="{{ route('payment_store', $plan->id) }}" class="pay__form form-pay">
                        @csrf
                        <div class="form-pay__card card" style="border: none">
                            <input type="hidden" id="plan" value="{{ $plan->id }}">
                            <div class="card__top">
                                <input id="CardNumber" autocomplete="off" type="text" required placeholder="0000 0000 0000 0000" inputmode="numeric" class="input">
                                <div id="CardType" class="card__bank"></div>
                            </div>
                            <div class="card__bottom" style="align-items: center">
                                <div class="card__day">
                                    <input id="expiryDate" required autocomplete="off" type="text" placeholder="ММ/ГГ" inputmode="numeric" class="input">
                                </div>

                                <div class="card__day">
                                    <label for="remember" style="cursor: pointer">Запомнить карту</label>
                                    <input id="remember" type="checkbox" placeholder="ММ/ГГ" style="cursor: pointer">
                                </div>
                            </div>
                        </div>

                        <div class="pay__bottom">
                            <button id="payButton" class="form-pay__button button">Оплатить</button>
                        </div>

                        <!-- Information text -->
                        <div class="pay__top">
                            <p class="pay__text">To’lovlar faqatgina UzCard va Humo kartalari orqali amalga oshiriladi.<br />
                                Xavfsizlik maqsadida sizning bank kartangiz ma’lumotlari PayMe xizmatining serverlarida saqlanadi.<br />
                            </p>
                            <a style="color: #0a6aa1;" class="pay__text" target="_blank" href="https://cdn.payme.uz/terms/main.html?target=_blank">Payme ofertasi</a>
                        </div>

                        <!-- Logo and Powered by text -->
                        <div class="logo-container" style="width: 30%;">
                            <img style="width: 100%; margin-bottom: 20px;" src="{{ asset('assets/img/payme.png') }}" alt="Payme Logo">
                            <div class="pay__text" style="font-size: 14px;">Powered by Payme</div>
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