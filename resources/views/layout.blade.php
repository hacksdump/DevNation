<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <title> Devnation | @yield('title') </title>
    @yield('header-tags')
</head>
<body>
<header class="navbar shadow">
    <div class="container">
        <a href="/" class="site-name nav-link text-white">DevNation</a>
        @if (Auth::check())
            <div class="btn-group">
                <a class="btn text-white" href="/user/{{ Auth::user()->username }}">
                    @if(Auth::user()->avatar)
                        <img class="avatar" src="{{Auth::user()->avatar}}">
                    @else
                        <span class="avatar">{{Auth::user()->name}}</span>
                    @endif
                    <span id="name">
                        {{ strtok(Auth::user()->name, ' ') }}
                    </span>
                </a>
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
<script>
    $(window).scroll(function (event) {
        let scroll = $(window).scrollTop();
        if(scroll > 100){
            $('header.navbar').addClass('scrolled');
        }
        else{
            $('header.navbar').removeClass('scrolled');
        }
    });
</script>
</body>
</html>
