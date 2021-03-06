<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Scripts -->
    <script src="{{ mix('/js/user/app.js') }}" defer></script>
    <!-- Style -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <!-- fontawesome -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
    @include('user.layouts.header')
    <main class="main">
        {{-- 正常系フラッシュ --}}
        @if (session('flash_message'))
            <div class="flash-container">
                <div class="container">
                    <span class="text">{{ session('flash_message') }}</span>
                    <button type="button" class="close-flash">×</button>
                </div>
            </div>
        @endif
        {{-- 異常系フラッシュ --}}
        @if (session('error_message'))
            <div class="flash-container">
                <div class="container -error">
                    <span class="text">{{ session('flash_message') }}</span>
                    <button type="button" class="close-flash">×</button>
                </div>
            </div>
        @endif
        {{-- content --}}
        @yield('content')
    </main>
    @include('user.layouts.footer')
</body>
</html>
