@extends('layout')

@section('title')
    {{ Auth::user()->username }}
    @stop

@section('content')
    @if ($user)
            <div class="card">
                <div class="card-body">
                    <img class="avatar" src="{{ $user['avatar'] }}">
                <div>
                    {{ $user['name'] }}
                </div>
                <div>
                    {{ $user['username'] }}
                </div>
                    <div>{{$stats['posts_count']}} questions asked</div>
                    <div>{{$stats['answers_count']}} questions answered</div>
                    <a class="btn btn-success" href="/">Home</a>
                @if($user['self'])
                    <a class="btn btn-danger" href="/logout">Logout</a>
                    @endif
                </div>
            </div>
            <div>
                <h3>
                    Posts by @if ($user['self']) you @else {{ $user['name'] }} @endif
                </h3>
            </div>
        <div class="container col-8">
            @include('components.posts_list')
        </div>

    @else
        Not found
    @endif

@stop
