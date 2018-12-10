@extends('layout')

@section('content')
    <div class="container">
    {!! Form::open(['url' => 'ask']) !!}
    {!! Form::textarea('query', '', ['class' => 'form-control']) !!}
    {!! Form::submit('Submit', ['class' => 'form-control']) !!}
    {!! Form::close() !!}
    </div>
@stop
