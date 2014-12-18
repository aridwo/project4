<?php

class MoodController extends \BaseController {


	/**
	*
	*/
	public function __construct() {

		parent::__construct();

		# Only logged in users are allowed here
		$this->beforeFilter('auth');

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		$moods = Mood::all();
		return View::make('mood_index')->with('moods',$moods);

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		return View::make('mood_create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {

		$mood = new Mood;
		$mood->name = Input::get('name');
		$mood->save();

		return Redirect::action('MoodController@index')->with('flash_message','Your mood been added.');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {

		try {
			$mood = Mood::findOrFail($id);
		}
		catch(Exception $e) {
			return Redirect::to('/mood')->with('flash_message', 'Mood not found');
		}

		return View::make('mood_show')->with('mood', $mood);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id) {

		try {
			$mood = Mood::findOrFail($id);
		}
		catch(Exception $e) {
			return Redirect::to('/mood')->with('flash_message', 'Mood not found');
		}

		# Pass with the $mood object so we can do model binding on the form
		return View::make('mood_edit')->with('mood', $mood);

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {

		try {
			$mood = Mood::findOrFail($id);
		}
		catch(Exception $e) {
			return Redirect::to('/mood')->with('flash_message', 'Mood not found');
		}

		$mood->name = Input::get('name');
		$mood->save();

		return Redirect::action('MoodController@index')->with('flash_message','Your mood has been saved.');

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {

		try {
			$mood = Mood::findOrFail($id);
		}
		catch(Exception $e) {
			return Redirect::to('/mood')->with('flash_message', 'Mood not found');
		}

		Mood::destroy($id);

		return Redirect::action('MoodController@index')->with('flash_message','Your mood has been deleted.');

	}

}