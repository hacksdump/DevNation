@extends('layout')

@section('content')
    @if ($user)
        <div class="container col-lg-4">
            <div class="card">
                <div class="card-body">
                <div>
                    {{ $user['name'] }}
                </div>
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
        </div>
        <div class="container col-8">
            @include('components.posts_list')
        </div>

    @else
        Not found
    @endif

@stop
