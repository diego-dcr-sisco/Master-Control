<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Siscoerp') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- STYLES -->
    <link rel="stylesheet" href="{{ asset('styles/app.min.css') }}">

    <!-- CDN -->
    @include('links.cdn')
</head>

<body class="m-0 d-flex flex-column" style="height: 100vh;">
    @auth
        @include('layouts.header')
        <div class="d-flex flex-column flex-md-row flex-grow-1" style="overflow: hidden;">
            <!-- Navbar primero en móvil, luego a la izquierda en desktop -->
            <div class="order-md-1 col-sm-auto col-lg-1.5 p-0 shadow" style="background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);">
                @unless (request()->is('/dashboard/*'))
                    @include('layouts.navbar')
                @endunless
            </div>
            <main class="order-md-2 col-md p-0" style="overflow-y: auto;">
                @yield('content')
            </main>
        </div>
    @else
        <main class="flex-grow-1">
            @yield('login')
        </main>
    @endauth

    <script src="{{ asset('js/login.min.js') }}"></script>
</body>

</html>
