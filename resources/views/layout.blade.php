<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <title> Devnation | @yield('title') </title>
    @yield('header-tags')
</head>
<body>
<header class="navbar bg-secondary">
    <div class="container">
        <a href="/" class="site-name nav-link text-white">DevNation</a>
        @if (Auth::check())
            <div class="btn-group">
                <a class="btn text-white" href="/user/{{ Auth::user()->username }}">{{ Auth::user()->name }}</a>
                <a class="btn btn-outline-success" href="/ask">Ask Dev</a>
            </div>
        @else
            <div class="btn-group">
                <a href="/login" class="btn btn-link text-white">Login</a>
                <a href="/register" class="btn btn-success text-white">Register</a>
            </div>
        @endif
    </div>

</header>
<main>
    @yield('content', 'Problem loading content')
</main>
</body>
</html>
