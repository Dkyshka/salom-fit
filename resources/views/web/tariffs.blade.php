@extends('web.layouts.app')

@section('content')
    <div class="wrapper">
        <header class="header">
            <div class="header__container">
            </div>
        </header>
        <main class="page">

            <section class="tarif">
                <div class="tarif__container">

                    <a href="{{ route('cabinet') }}" class="page__back _icon-back"></a>

                    <div class="tarif__top">
                        <h1 class="tarif__title title">Тарифы</h1>
                    </div>

                    <div class="tarif__items">
                        @foreach($tariffs as $item)
                        <div class="tarif__item item-tarif">
                            <h4 class="item-tarif__title">{{ $item->name }} - {{ $item->price ? number_format($item->price, 0, '', ' ') : '' }}</h4>
                            <div class="item-tarif__description">{{ $item->description }}</div>
                            <a href="{{ route('payment', $item->id) }}" class="item-tarif__buy button">Оформить</a>
                        </div>
                        @endforeach
                    </div>

                </div>
            </section>

        </main>
        <footer class="footer">
            <div class="footer__container">
            </div>
        </footer>
    </div>
@endsection