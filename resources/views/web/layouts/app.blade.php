<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Jahon Chef community bot</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
{{--    <link rel="stylesheet" href="https://a505-146-158-19-144.ngrok-free.app/assets/css/style.css">--}}
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <script>
        let tg = window?.Telegram.WebApp?.initData;
    </script>
{{--    @vite(['resources/css/app.css', 'resources/js/app.js'])--}}
</head>
<body>
        @yield('content')
</body>

{{--<script>--}}
{{--    // Получаем ссылку на кнопку--}}
{{--    document.getElementById('closeButton')?.addEventListener('click', function(event) {--}}
{{--        event.preventDefault(); // Отключаем стандартное поведение кнопки--}}

{{--        // Закрываем веб-приложение в Telegram--}}
{{--        if (window?.Telegram?.WebApp) {--}}
{{--            window.Telegram.WebApp.close();--}}
{{--        } else {--}}
{{--            console.log('Telegram WebApp API не поддерживается.');--}}
{{--        }--}}
{{--    });--}}
{{--</script>--}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
{{--<script src="https://a505-146-158-19-144.ngrok-free.app/assets/js/app.js"></script>--}}
</html>