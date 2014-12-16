@extends('_master')

@section('title')
	Log in
@stop

@section('content')
<h4>Create Account</h4>

@foreach($errors->all() as $message)
	<div class='error'>{{ $message }}</div>
@endforeach

{{ Form::open(array('url' => '/signup')) }}

 	{{ Form::label('First Name') }}
    {{ Form::text('first_name') }}

    {{ Form::label('Last Name') }}
    {{ Form::text('last_name') }}

    {{ Form::label('email') }}
    {{ Form::text('email') }}

    {{ Form::label('password') }}
    {{ Form::password('password') }}
  

    {{ Form::submit('Submit') }}

{{ Form::close() }}
@stop