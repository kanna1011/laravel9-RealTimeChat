<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Real Time Chat App</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.0/dist/echo.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @vite('resources/js/app.js')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-container">
            <a href="/">
                <img src="{{ asset('storage/logo.png') }}" alt="ロゴ" class="header-logo">
                <p class="header-message">全国の犬猫ペットの里親募集マッチングサイト</p>
            </a>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <p>&copy; {{ date('Y') }} Real Time Chat App</p>
    </footer>
</body>
</html>
