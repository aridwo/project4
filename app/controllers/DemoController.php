<?php

class DemoController extends BaseController {

	public function __construct() {

		# Make sure BaseController construct gets called
		parent::__construct();

	}

	/**
	* Used for testing cron scheduling
	*
	* @return String
	*/
	public function pingLogFile() {

		Log::info('Pinged log file');

		return 'Pinged log file';

	}


	/**
	* Quick way to demonstrate sending a welcome email
	*/
	public function newUserWelcomeEmail() {

		# Add a new user
		$user = new User;
		$user->email      = 'mail'.rand(10,100).'@susanbuck.net';
		$user->first_name = 'Sam';
		$user->last_name  = 'Seaborn';
		$user->password   = Hash::make('foobar1234');
		$user->save();

		# Log in
		Auth::login($user);

		$user->sendWelcomeEmail();

		return $user.'<br> Email Sent';

	}


	/**
	* CSRF Example
	* @return View
	*/
	public function csrf() {

		return View::make('demo_csrf');

	}

	public function jsVars() {

		# Bind a variable called 'foo'
		JavaScript::put(['foo' => 'bar']);

		# Bind a variable called 'bar'
		JavaScript::put(['email' => Auth::user()->email]);

		return View::make('demo_jsVars');

	}

	public function crudCreate() {

		# Instantiate the book model
		$book = new Book();

		$book->title = 'The Great Gatsby';
		$book->author = 'F. Scott Fitzgerald';
		$book->published = 1925;
		$book->cover = 'http://imagesbn.com....';
		$book->purchase_link = 'http://amazon...';

		# Magic: Eloquent
		$book->save();

		return "Added a new row";

	}


	public function crudRead() {

		# Magic: Eloquent
		$books = Book::all();

		# Debugging
		foreach($books as $book) {
			echo $book->title."<br>";
		}

	}


	public function crudUpdate() {

		# Get a book to update
		$book = Book::first();

		# Update the author
		$book->author = 'Foobar';

		# Save the changes
		$book->save();

		echo "This book has been updated";

	}


	public function crudDelete() {

		# Get a book to delete
		$book = Book::first();

		# Delete the book
		$book->delete();

		echo "This book has been deleted";
	}


	public function collections() {

		$collection = Book::all();

		//echo Pre::render($collection);

		# The many faces of a Eloquent Collection object...

		# Treat it like a string:
		echo $collection;

		# Treat it like an array:
		//foreach($collection as $book) {
		//	echo $book['title']."<br>";
		//}

		# Treat it like an object:
		//foreach($collection as $book) {
		// echo $book->title."<br>";
		//}

	}

	public function queryWithoutConstraints() {

		$books = Book::find(1);

		//$books = Book::first();

		//$books = Book::all();

		Book::pretty_debug($books);
	}


	public function queryWithConstraints() {

		$books = Book::where('published','>',1960)->first();

		//$books = Book::where('published','>',1960)->get();

		//$books = Book::where('published','>',1960)->orWhere('title', 'LIKE', '%gatsby')->get();

		//$books = Book::whereRaw('title LIKE "%gatsby" OR title LIKE "%bell%"')->get();

		Book::pretty_debug($books);

	}

	public function queryResponsibility() {

		# Scenario: You have a view that needs to display a table of all the books, so you run this query:
		$books = Book::orderBy('title')->get();

		# Then, you need to display the first book that was added to the table
		# There are two ways you can do this...

		# Query the database again
		$first_book = Book::orderBy('title')->first();

		# Or query the existing collection
		//$first_book = $books->first();

		echo $first_book->title;

	}

	public function queryWithOrder() {

		$books = Book::where('published', '>', 1950)->
		orderBy('title','desc')
		->get();

		Book::pretty_debug($books);
	}


	public function queryRelationshipsAuthor() {

		# Get the first book as an example
		$book = Book::orderBy('title')->first();

		# Get the author from this book using the "author" dynamic property
		# "author" corresponds to the the relationship method defined in the Book model
		$author = $book->author;

		# Print book info
		echo $book->title." was written by ".$author->name."<br>";

		# FYI: You could also access the author name like this:
		//$book->author->name;


	}

	public function queryRelationsipsTags() {

		# Get the first book as an example
		$book = Book::orderBy('title')->first();

		# Get the tags from this book using the "tags" dynamic property
		# "tags" corresponds to the the relationship method defined in the Book model
		$tags = $book->tags;

		# Print results
		echo "The tags for <strong>".$book->title."</strong> are: <br>";
		foreach($tags as $tag) {
		echo $tag->name."<br>";
		}

	}

	public function queryEagerLoadingAuthors() {

		# Without eager loading (4 queries)
		$books = Book::orderBy('title')->get();

		# With eager loading (2 queries)
		//$books = Book::with('author')->orderBy('title')->get();

		foreach($books as $book) {
			echo $book->author->name.' wrote '.$book->title.'<br>';
		}
	}

	public function queryEagerLoadingTagsAndAuthors() {


		# Without eager loading (7 Queries)
		$books = Book::orderBy('title')->get();

		# With eager loading (3 Queries)
		//$books = Book::with('author','tags')->orderBy('title')->get();

		# Print results
		foreach($books as $book) {
			echo $book->title.' by '.$book->author->name.'<br>';
		foreach($book->tags as $tag) echo $tag->name.", ";
			echo "<br><br>";
		}

	}


	public function getSimpleAjax() {

		 return View::make('ajax-example');
	}


	public function postSimpleAjax() {

		$data = var_dump($_POST);

   		$data .= '<br>Your name reversed is '.strrev($_POST['name']);

    	return $data;
	}
}