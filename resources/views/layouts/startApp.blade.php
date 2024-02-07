<!doctype html>
<html lang="fa">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}
    <link rel="icon" href="{{ url('favicon.ico') }}">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/sass/starting.scss', 'resources/js/starting.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <div class="starting__container">
        <a class="text-decoration-none" href="{{ route('root') }}">
            <section class="logo__container mb-4">
                <img class="logo" src="{{ url('images/fav__icon.png') }}" alt="liquidMusic">
                <h1 class="logo__title text__color__secondary">Liquid Music</h1>
            </section>
        </a>
        @yield('content')
    </div>
</body>

</html>
