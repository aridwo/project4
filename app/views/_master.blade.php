<!DOCTYPE html>
<html>
<head>

	<title>@yield('title','Mood Bank')</title>
	<meta charset='utf-8'>

	<link rel='stylesheet' href='/style.css' type='text/css'>
	<h2><a href='/'>Mood Bank</a></h2>



	@yield('head')


</head>
<body>

	@if(Session::get('flash_message'))
		<div class='flash-message'>{{ Session::get('flash_message') }}</div>
	@endif


	<nav>
		<ul>
		@if(Auth::check())
			<li><a href='/logout'>Log out</a></li>
			<li><a href='/image'>All Images</a></li>
			<li><a href='/image/create'>Add Image</a></li>
			
		@else
			<li><a href='/signup'>Sign up</a> or <a href='/login'>Log in</a></li>
		@endif
		</ul>
	</nav>
	
	

	@yield('content')
	

	
	@yield('/body')



</body>
</html>





