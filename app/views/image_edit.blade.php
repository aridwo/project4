@extends('_master')

@section('title')
	Edit
@stop

@section('head')

@stop

@section('content')

	<h4>Edit '{{{ $image['title'] }}}'</h4>

	{{---- EDIT -----}}
	{{ Form::open(array('url' => '/image/edit')) }}

		{{ Form::hidden('id',$image['id']); }}

		<p>Adjust mood(s):
@foreach($moods as $id => $mood)
				{{ Form::checkbox('moods[]', $id, $image->moods->contains($id)); }} {{ $mood }}
				
			@endforeach
		

		{{ Form::submit('Update'); }}

	{{ Form::close() }}

	


@stop