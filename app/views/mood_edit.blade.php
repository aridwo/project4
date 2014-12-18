@extends('_master')

@section('title')
	Edit Mood
@stop


@section('content')

	{{ Form::model($mood, ['method' => 'put', 'action' => ['MoodController@update', $mood->id]]) }}

		<h2>Update: {{ $mood->name }}</h2>

		<div class='form-group'>
			{{ Form::label('name', 'Mood Name') }}
			{{ Form::text('name') }}
		</div>

		{{ Form::submit('Update') }}

	{{ Form::close() }}


	{{---- DELETE -----}}
	{{ Form::open(['method' => 'DELETE', 'action' => ['MoodController@destroy', $mood->id]]) }}
		<a href='javascript:void(0)' onClick='parentNode.submit();return false;'>Delete</a>
	{{ Form::close() }}

@stop