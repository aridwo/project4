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