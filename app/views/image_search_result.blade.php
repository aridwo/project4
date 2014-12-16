<section>
	<img class='cover' src='{{ $image['cover'] }}'>

	<h4>{{ $image['title'] }}</h4>

	<p>
	{{ $image['author']->name }} {{ $image['published'] }}
	</p>

	<p>
		@foreach($image['moods'] as $mood)
			{{ $mood->name }}
		@endforeach
	</p>

	
	<br>
	<a href='/image/edit/{{ $image->id }}'>Edit</a>
</section>