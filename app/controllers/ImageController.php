<?php

class ImageController extends \BaseController {


	/**
	*
	*/
	public function __construct() {

		# Make sure BaseController construct gets called
		parent::__construct();

		$this->beforeFilter('auth', array('except' => ['getIndex','getDigest']));

	}


	/**
	* Used as an example for something you might want to set up a cron job for
	*/
	public function getDigest() {

		$images = Image::getImagesAddedInTheLast24Hours();

		$users = User::all();

		$recipients = Image::sendDigests($users,$images);

		$results = 'Image digest sent to: '.$recipients;

		Log::info($results);

		return $results;

	}


	/**
	* Process the searchform
	* @return View
	*/
	public function getSearch() {

		return View::make('image_search');

	}


	/**
	* Display all images
	* @return View
	*/
	public function getIndex() {

		# Format and Query are passed as Query Strings
		$format = Input::get('format', 'html');

		$query  = Input::get('query');

		$images = Image::search($query);

		# Decide on output method...
		# Default - HTML
		if($format == 'html') {
			return View::make('image_index')
				->with('images', $images)
				->with('query', $query);
		}
		

	}


	/**
	* Show the "Add a image form"
	* @return View
	*/
	public function getCreate() {

		$authors = Author::getIdNamePair();

		$moods = Mood::getIdNamePair();

    	return View::make('image_add')
    		->with('authors',$authors)
    		->with('moods',$moods);

	}


	/**
	* Process the "Add a image form"
	* @return Redirect
	*/
	public function postCreate() {

		# Instantiate the image model
		$image = new Image();

		$image->fill(Input::except('moods'));

		# Note this save happens before we enter any moods (next step)
		$image->save();

		foreach(Input::get('moods') as $mood) {

			# This enters a new row in the image_mood table
			$image->moods()->save(Mood::find($mood));

		}

		return Redirect::action('ImageController@getIndex')->with('flash_message','Your image has been added.');

	}


	/**
	* Show the "Edit a image form"
	* @return View
	*/
	public function getEdit($id) {

		try {

			# Get all the authors (used in the author drop down)
			$authors = Author::getIdNamePair();

			# Get this image and all of its associated moods
		    $image    = Image::with('moods')->findOrFail($id);

		    # Get all the moods (not just the ones associated with this image)
		    $moods    = Mood::getIdNamePair();
		}
		catch(exception $e) {
		    return Redirect::to('/image')->with('flash_message', 'Image not found');
		}

    	return View::make('image_edit')
    		->with('image', $image)
    		->with('authors', $authors)
    		->with('moods', $moods);

	}


	/**
	* Process the "Edit a image form"
	* @return Redirect
	*/
	public function postEdit() {

		try {
	        $image = Image::with('moods')->findOrFail(Input::get('id'));
	    }
	    catch(exception $e) {
	        return Redirect::to('/image')->with('flash_message', 'Image not found');
	    }

	    try {
		    # http://laravel.com/docs/4.2/eloquent#mass-assignment
		    $image->fill(Input::except('moods'));
		    $image->save();

		    # Update moods associated with this image
		    if(!isset($_POST['moods'])) $_POST['moods'] = array();
		    $image->updateMoods($_POST['moods']);

		   	return Redirect::action('ImageController@getIndex')->with('flash_message','Your changes have been saved.');

		}
		catch(exception $e) {
	        return Redirect::to('/image')->with('flash_message', 'Issue saving changes.');
	    }

	}


	/**
	* Process image deletion
	*
	* @return Redirect
	*/
	public function postDelete() {

		try {
	        $image = Image::findOrFail(Input::get('id'));
	    }
	    catch(exception $e) {
	        return Redirect::to('/image/')->with('flash_message', 'Could not delete image - not found.');
	    }

	    Image::destroy(Input::get('id'));

	    return Redirect::to('/image/')->with('flash_message', 'Image deleted.');

	}


	/**
	* Process a image search
	* Called w/ Ajax
	*/
	public function postSearch() {

		if(Request::ajax()) {

			$query  = Input::get('query');

			# We're demoing two possible return formats: JSON or HTML
			$format = Input::get('format');

			# Do the actual query
	        $images  = Image::search($query);

	        # If the request is for JSON, just send the images back as JSON
	        if($format == 'json') {
		        return Response::json($images);
	        }
	        # Otherwise, loop through the results building the HTML View we'll return
	        elseif($format == 'html') {

		        $results = '';
				foreach($images as $image) {
					# Created a "stub" of a view called image_search_result.php; all it is is a stub of code to display a image
					# For each image, we'll add a new stub to the results
					$results .= View::make('image_search_result')->with('image', $image)->render();
				}

				# Return the HTML/View to JavaScript...
				return $results;
			}
		}
	}



}