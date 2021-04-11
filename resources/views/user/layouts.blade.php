<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <!-- Scripts -->
  <script src="{{ mix('/js/user/app.js') }}" defer></script>
  <script src="{{ config('app.asset_url') }}/js/user/app.js" defer></script>
  <!-- Style -->
  <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
  <script src="{{ config('app.asset_url') }}/css/app.css" defer></script>
  <!-- fontawesome -->
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
    @include('user.layouts.header')
    <main class="main">
      @yield('content')
    </main>
    @include('user.layouts.footer')
</body>
</html>
