@extends('_master')


@section('title')
	View mood
@stop


@section('content')

	<h2>mood: {{ $mood->name }}</h2>

	<div>
	Created: {{ $mood->created_at }}
	</div>

	<div>
	Last Updated: {{ $mood->updated_at }}
	</div>

	{{---- Edit ----}}
	<a href='/mood/{{ $mood->id }}/edit'>Edit</a>

	{{---- Delete -----}}
	{{ Form::open(['method' => 'DELETE', 'action' => ['moodController@destroy', $mood->id]]) }}
		<a href='javascript:void(0)' onClick='parentNode.submit();return false;'>Delete</a>
	{{ Form::close() }}

@stop