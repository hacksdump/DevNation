@extends('layout')

@section('title')
    Register
@stop

@section('content')
    <div class="form-group auth-screen col-lg-6 card">
        <h1 class="modal-header">Register</h1>
    {!! Form::open(['url' => 'register']) !!}

    <!-- if there are login errors, show them here -->
        <div class="row">
            {!! Form::label('name', 'Name', ['class' => 'control-label col-lg-3']) !!}
            {!! Form::text('name', '', ['class' => 'form-control col-lg-8']) !!}
        </div>

        <div class="row">
            {!! Form::label('username', 'Username', ['class' => 'control-label col-lg-3']) !!}
            {!! Form::text('username', '', ['class' => 'form-control col-lg-8']) !!}
        </div>
        <p class="alert-danger">{{ $errors->first('username') }}</p>

        <div class="row">
            {!! Form::label('email', 'Email', ['class' => 'control-label col-lg-3']) !!}
            {!! Form::email('email', '', ['class' => 'form-control col-lg-8']) !!}
        </div>
        <p class="alert-danger">{{ $errors->first('email') }}</p>

        <div class="row">
            {!! Form::label('password', 'Password', ['class' => 'control-label col-lg-3']) !!}
            {!! Form::password('password', ['class' => 'form-control col-lg-8']) !!}
        </div>
        <p class="alert-danger">{{ $errors->first('password') }}</p>
        <div class="row">
            <div class="col-7"><span>Already have an account?</span> <a href="/login">Login</a></div>
            {!! Form::submit('Submit', ['class' => 'form-control btn btn-sm btn-success col-lg-4']) !!}
            <a class="col-3" href="/redirect/google"><img src="{{asset('images/google-sign-in.png')}}" alt="Google sign up"></a>
        </div>
        {!! Form::close() !!}
    </div>

@stop
