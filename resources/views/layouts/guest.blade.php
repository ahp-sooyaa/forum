<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta 
      name="description" 
      content="A forum built with laravel, vuejs, tailwindcss and so much more :) .">

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

      if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark')
      } else {
        document.documentElement.classList.remove('dark')
      }
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor/tribute.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

        <main class="min-h-screen bg-light-primary dark:bg-dark-primary">
            @yield('content')
        </main>

        <v-flash-noti message="{{ session('flash') }}"/>
    </div>
</body>
</html>
