<?php

class IndexController extends BaseController {

	/**
	*
	*/
	public function __construct() {

		parent::__construct();

	}

	/**
	*
	*/
	public function getIndex() {

		return View::make('index');

}

}