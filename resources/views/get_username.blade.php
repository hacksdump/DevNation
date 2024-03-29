@extends('layout')

@section('title')
    Register | Finalising
@stop

@section('content')
    <div class="form-group auth-screen col-lg-6 card">
        <h1 class="modal-header">Hello {{ strtok($name, ' ') }}</h1>
        <p>Just enter a new username and password and you are ready to go.</p>
    {!! Form::open(['url' => '/register/username']) !!}

    <!-- if there are login errors, show them here -->

        <div class="row">
            {!! Form::label('username', 'Username', ['class' => 'control-label col-lg-3']) !!}
            {!! Form::text('username', '', ['class' => 'form-control col-lg-8']) !!}
        </div>
        <p class="alert-danger">{{ $errors->first('username') }}</p>

        <div class="row">
            {!! Form::label('password', 'Password', ['class' => 'control-label col-lg-3']) !!}
            {!! Form::password('password', ['class' => 'form-control col-lg-8']) !!}
        </div>
        <p class="alert-danger">{{ $errors->first('password') }}</p>

        <div class="row">
            {!! Form::submit('Submit', ['class' => 'form-control btn btn-sm btn-success col-lg-4']) !!}
        </div>
        {!! Form::close() !!}
    </div>

@stop
