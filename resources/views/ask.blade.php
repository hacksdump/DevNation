@extends('layout')

@section('content')
    {!! Form::open(['url' => 'ask']) !!}
    {!! Form::textarea('query', '', ['class' => 'form-control']) !!}
    {!! Form::submit('Submit', ['class' => 'form-control']) !!}
    {!! Form::close() !!}
@stop
