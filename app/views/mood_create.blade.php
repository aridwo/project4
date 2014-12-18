@extends('_master')

@section('title')
	Create a new mood
@stop


@section('content')

	<h1>Create a mood</h1>

	{{ Form::open(array('action' => 'moodController@store')) }}

		<div>
			{{ Form::label('name','mood Name') }}
			{{ Form::text('name') }}
		</div>

		<br><br>
		{{ Form::submit('Add mood') }}

	{{ Form::close() }}

@stop