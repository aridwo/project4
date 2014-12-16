@extends('_master')

@section('title')
	Images
@stop

@section('content')

	@if($query)
		<h4>{{{ $query }}} images:</h4>
	@endif

	<div style="float:right;">{{ Form::open(array('url' => '/image', 'method' => 'GET')) }}

		{{ Form::label('query','Search:') }}

		{{ Form::text('query'); }}

		{{ Form::submit('>>'); }}

	{{ Form::close() }}</div>

	@if(sizeof($images) == 0)
		No results
	@else

		@foreach($images as $image)
			<section class='image'>

				

				<p>
					<img src='{{ $image['photo'] }}'>
					
				<br>
				<strong>{{ $image['title'] }}</strong><br>
					Photo by {{ $image['author']['name'] }} 
				<br>
					Mood(s): @foreach($image['moods'] as $mood)
						<span class='mood'>{{{ $mood->name }}}</span>
					@endforeach<br>
					<a href='/image/edit/{{$image['id']}}'>Edit Image</a>
				</p>
</section>
		@endforeach

	@endif

@stop







