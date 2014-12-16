@extends('_master')

@section('title')
	Log in
@stop

@section('content')

<h4>Account Signup</h4>

{{ Form::open(array('url' => '/login')) }}

    {{ Form::label('email') }}
    {{ Form::text('email') }}

    {{ Form::label('password') }}
    {{ Form::password('password') }}

    {{ Form::submit('Submit') }}

{{ Form::close() }}

@stop