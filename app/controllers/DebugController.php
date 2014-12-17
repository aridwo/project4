<?php

class DebugController extends BaseController {

	/**
	*
	*/
	public function __construct() {

		# Make sure BaseController construct gets called
		parent::__construct();

	}

	/**
	* Special method that gets triggered if the user enters a URL for a method that does not exist
	*
	* @return String
	*/
	public function missingMethod($parameters = array()) {

		return 'Method "'.$parameters[0].'" not found';

	}

	/**
	* http://localhost/debug/index
	*
	* @return String
	*/
	public function getIndex() {

		echo '<pre>';

		echo '<h4>environment.php</h4>';
		$path   = base_path().'/environment.php';

		try {
			$contents = 'Contents: '.File::getRequire($path);
			$exists = 'Yes';
		}
		catch (Exception $e) {
			$exists = 'No. Defaulting to `production`';
			$contents = '';
		}

		echo "Checking for: ".$path.'<br>';
		echo 'Exists: '.$exists.'<br>';
		echo $contents;
		echo '<br>';

		echo '<h4>Environment</h4>';
		echo App::environment().'</h4>';

		echo '<h4>Debugging?</h4>';
		if(Config::get('app.debug')) echo "Yes"; else echo "No";

		echo '<h4>Database Config</h4>';
		print_r(Config::get('database.connections.mysql'));

		echo '<h4>Test Database Connection</h4>';
		try {
			$results = DB::select('SHOW DATABASES;');
			echo '<strong style="background-color:green; padding:5px;">Connection confirmed</strong>';
			echo "<br><br>Your Databases:<br><br>";
			print_r($results);
		}
		catch (Exception $e) {
			echo '<strong style="background-color:crimson; padding:5px;">Caught exception: ', $e->getMessage(), "</strong>\n";
		}

		echo '</pre>';

	}


	/**
	* Trigger an error to test debug display settings
	* http://localhost/debug/trigger-error
	*
	* @return Exception
	*/
	public function getTriggerError() {

		# Class Foobar should not exist, so this should create an error
		$foo = new Foobar;

	}


	/**
	* Print all available routes
	* http://localhost/debug/routes
	*
	* @return String
	*/
	public function getRoutes() {

		$routeCollection = Route::getRoutes();

		foreach ($routeCollection as $value) {
	    	echo "<a href='/".$value->getPath()."' target='_blank'>".$value->getPath()."</a><br>";
		}

	}


	/**
	* http://localhost/debug/images-json
	*
	* @return String
	*/
	public function getImagesJson() {

		# Old school way of getting images using the Library class and images.json
		# We've since updated this method with the Image model class and `images` table

		# Instantiating an object of the Library class
		$library = new Library(app_path().'/database/images.json');

		# Get the images
		$images = $library->getImages();

		# Debug
		return Pre::render($images, 'Images');
	}


	
	/*
	* Test to make sure we can connect to MySQL
	*
	* @return String
	*/
	public function getMysqlTest() {

	    # Print environment
	    echo 'Environment: '.App::environment().'<br>';

	    # Use the DB component to select all the databases
	    $results = DB::select('SHOW DATABASES;');

	    # If the "Pre" package is not installed, you should output using print_r instead
	    echo Pre::render($results);

	}

	/**
	* Outputs Session and Cookie data in various forms.
	* Used to understand how Sessions and Cookies are working
	*/
	public function getSessionsAndCookies() {
		 # Log in check
	    if(Auth::check())
	        echo "You are logged in: ".Auth::user();
	    else
	        echo "You are not logged in.";
	    echo "<br><br>";

	    # Cookies
	    echo "<h4>Your Raw, encrypted Cookies</h4>";
	    echo Paste\Pre::render($_COOKIE,'');

	    # Decrypted cookies
	    echo "<h4>Your Decrypted Cookies</h4>";
	    echo Paste\Pre::render(Cookie::get(),'');
	    echo "<br><br>";

	    # All Session files
	    echo "<h4>All Session Files</h4>";
	    $files = File::files(app_path().'/storage/sessions');

	    foreach($files as $file) {
	        if(strstr($file,Cookie::get('laravel_session'))) {
	            echo "<div style='background-color:yellow'><strong>YOUR SESSION FILE:</strong><br>";
	        }
	        else {
	            echo "<div>";
	        }
	        echo "<strong>".$file."</strong>:<br>".File::get($file)."<br>";
	        echo "</div><br>";
	    }

	    echo "<br><br>";

	    # Your Session Data
	    $data = Session::all();
	    echo "<h4>Your Session Data</h4>";
	    echo Paste\Pre::render($data,'Session data');
	    echo "<br><br>";

	    # Token
	    echo "<h4>Your CSRF Token</h4>";
	    echo Form::token();
	    echo "<script>document.querySelector('[name=_token]').type='text'</script>";
	    echo "<br><br>";
	}

}