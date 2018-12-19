@extends('layout')
@section('title')
    Home
    @stop
@section('content')
    <h1>Top questions</h1>
    @include('components.posts_list')

@stop
