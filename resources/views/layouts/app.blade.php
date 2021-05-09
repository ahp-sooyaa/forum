<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta 
      name="description" 
      content="A forum built with laravel, vuejs, tailwindcss and so much more :) .">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Forum') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('/js/manifest.js')}}" defer></script>
    <script src="{{ mix('/js/vendor.js')}}" defer></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script>
      window.App = {!!json_encode([
        'signIn' => Auth::check(),
        'user' => Auth::user()
      ])!!};
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor/tribute.css') }}" rel="stylesheet">

    @yield('head')
</head>
<body>
    <div id="app">
        <v-navbar :channels="{{$channels}}"></v-navbar>

        <main class="p-4 min-h-screen bg-light-primary dark:bg-dark-primary">
            @yield('content')
        </main>

        <footer class="h-48 bg-light-secondary dark:bg-dark-secondary">hi</footer>
        <v-flash-noti message="{{ session('flash') }}"/>
    </div>
</body>
</html>
