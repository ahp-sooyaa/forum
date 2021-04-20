<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Forum') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
      window.App = {!!json_encode([
        'signIn' => Auth::check(),
        'user' => Auth::user()
      ])!!};
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor/tribute.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <v-navbar :channels="{{$channels}}"></v-navbar>

        <main class="p-4 min-h-screen bg-gray-900">
            @yield('content')
        </main>

        <footer class="h-48 bg-gray-800">hi</footer>
        <v-flash-noti message="{{ session('flash') }}"/>
    </div>
</body>
</html>
