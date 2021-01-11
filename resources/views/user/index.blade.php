<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'Reserve.System') }}</title>
  
  <!-- Scripts -->
  <script type="text/javascript" src="{{ asset('/js/app.js') }}" defer></script>
  <!-- Style -->
  <link type="text/css" href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app"></div>
</body>
</html>
