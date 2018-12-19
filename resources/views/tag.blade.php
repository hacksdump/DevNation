@extends('layout')

@section('title')
    {{ ucfirst($tag) }}
    @stop


@section('content')
        <div class="container col-8">
            <h1> {{ $tag }}</h1>
            @include('components.posts_list')
        </div>

@stop
