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


/**
* Debug
* (Implicit Routing)
*/
Route::controller('debug', 'DebugController');


/**
* Tag
* (Implicit RESTful Routing)
*/
Route::resource('tag', 'TagController');


/**
* Demos
* (Explicit Routing)
*/
Route::get('/demo/ping-log-file', 'DemoController@pingLogFile');
Route::get('/demo/new-user-welcome-email', 'DemoController@newUserWelcomeEmail');
Route::get('/demo/csrf-example', 'DemoController@csrf');
Route::get('/demo/collections', 'DemoController@collections');
Route::get('/demo/js-vars', 'DemoController@jsVars');

Route::get('/demo/crud-create', 'DemoController@crudCreate');
Route::get('/demo/crud-read', 'DemoController@crudRead');
Route::get('/demo/crud-update', 'DemoController@crudUpdate');
Route::get('/demo/crud-delete', 'DemoController@crudDelete');

Route::get('/demo/collections', 'DemoController@collections');
Route::get('/demo/query-without-constraints', 'DemoController@queryWithoutConstraints');
Route::get('/demo/query-with-constraints', 'DemoController@queryWithConstraints');
Route::get('/demo/query-responsibility', 'DemoController@queryResponsibility');
Route::get('/demo/query-with-order', 'DemoController@queryWithOrder');

Route::get('/demo/query-relationships-author', 'DemoController@queryRelationshipsAuthor');
Route::get('/demo/query-relationships-tags', 'DemoController@queryRelationshipstags');
Route::get('/demo/query-eager-loading-authors', 'DemoController@queryEagerLoadingAuthors');
Route::get('/demo/query-eager-loading-tags-and-authors', 'DemoController@queryEagerLoadingTagsAndAuthors');

Route::get('/demo/simple-ajax', 'DemoController@getSimpleAjax');
Route::post('/demo/simple-ajax', 'DemoController@postSimpleAjax');


