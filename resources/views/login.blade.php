@extends('layout')

@section('title')
    Login
@stop

@section('content')
    <div class="auth-screen form-group col-lg-6 card">
    <h1 class="modal-header">Login</h1>
    {!! Form::open(['url' => 'login']) !!}
        <div class="row">
        {!! Form::label('username', 'Username or e-mail', ['class' => 'control-label col-lg-3']) !!}
        {!! Form::text('username', '', ['class' => 'form-control col-lg-8', 'required' => 'required']) !!}
        </div>
        {{ $errors->first('username') }}

        <div class="row">
        {!! Form::label('password', 'Password', ['class' => 'control-label col-lg-3']) !!}
        {!! Form::password('password', ['class' => 'form-control col-lg-8', 'required' => 'required']) !!}
        </div>
        {{ $errors->first('password') }}

        <div class="row">
            <div class="col-7"><span>Don't have an account yet?</span> <a href="/register">Register</a></div>
            {!! Form::submit('Submit', ['class' => 'form-control btn btn-sm btn-success col-lg-4']) !!}
        </div>
    {!! Form::close() !!}
        <a href="/redirect/google"><img src="{{asset('images/google-sign-in.png')}}" alt="Google sign in"></a>
    </div>


@stop
