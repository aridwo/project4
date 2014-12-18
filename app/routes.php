<?php

/*
Note there are no before=>csrf filters in here - it's being handled in the BaseController
*/




Route::get('/classes', function() {

	echo Paste\Pre::render(get_declared_classes(),'');

});

/**
* Index
*/
Route::get('/', 'IndexController@getIndex');


/**
* User
* (Explicit Routing)
*/
Route::get('/signup','UserController@getSignup' );
Route::get('/login', 'UserController@getLogin' );
Route::post('/signup', 'UserController@postSignup' );
Route::post('/login', 'UserController@postLogin' );
Route::get('/logout', 'UserController@getLogout' );


/**
* Image
* (Explicit Routing)
*/
Route::get('/image', 'ImageController@getIndex');

Route::get('/image/edit/{id}', 'ImageController@getEdit');
Route::post('/image/edit', 'ImageController@postEdit');

Route::get('/image/create', 'ImageController@getCreate');
Route::post('/image/create', 'ImageController@postCreate');

Route::post('/image/delete', 'ImageController@postDelete');

Route::get('/image/digest', 'ImageController@getDigest');

## Ajax examples
Route::get('/image/search', 'ImageController@getSearch');
Route::post('/image/search', 'ImageController@postSearch');


/**
* Debug
* (Implicit Routing)
*/
Route::controller('debug', 'DebugController');


Route::get('/debug', function() {

    echo '<pre>';

    echo '<h1>environment.php</h1>';
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

    echo '<h1>Environment</h1>';
    echo App::environment().'</h1>';

    echo '<h1>Debugging?</h1>';
    if(Config::get('app.debug')) echo "Yes"; else echo "No";

    echo '<h1>Database Config</h1>';
    print_r(Config::get('database.connections.mysql'));

    echo '<h1>Test Database Connection</h1>';
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

});

Route::get('/get-environment',function() {

    echo "Environment: ".App::environment();

});

Route::get('/trigger-error',function() {

    # Class Foobar should not exist, so this should create an error
    $foo = new Foobar;

});