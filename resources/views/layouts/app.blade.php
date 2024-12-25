
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'kadai_002') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Styles -->
    <link href="{{ asset('css/kadai_002.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/aca0c0e746.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="app">
    @component('components.header')
    @endcomponent
        <main class="py-4 mb-5">
            @yield('content')
        </main>
        @component('components.footer')
        @endcomponent
    </div>
</body>
</html>