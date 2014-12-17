@extends('_master')

@section('title')
	Add a new image
@stop

@section('content')

	<h4>Add a new image</h4>

	{{ Form::open(array('url' => '/image/create')) }}

		<p>{{ Form::label('title','Title:') }}
		{{ Form::text('title'); }}

		{{ Form::label('author_id', 'Photographer:') }}
		{{ Form::select('author_id', $authors); }}

		

		{{ Form::label('photo','URL of Photograph:') }}
		{{ Form::text('photo'); }}

		
		{{ Form::label('mood','Select mood(s) of photo:') }}
		@foreach($moods as $id => $mood)
			{{ Form::checkbox('moods[]', $id); }} {{ $mood }}
		@endforeach</p>
	

		{{ Form::submit('Add'); }}

	{{ Form::close() }}

@stop
