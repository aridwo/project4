@extends('_master')


@section('title')
	All the moods
@stop


@section('content')

	<h2>moods</h2>


	<a href='/mood/create'>+ Add a new mood</a>

	<br><br>

	@foreach($moods as $mood)

		<div>
			<a href='/mood/{{ $mood->id }}'>{{ $mood->name }}</a>
		</div>

	@endforeach

@stop