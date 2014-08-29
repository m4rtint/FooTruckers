<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*
| Home page
*/
Route::get('/', array(
	'as' => 'home',
	'uses' => 'HomeController@home'
));


/*View for Table*/
Route::get('/table', array(
	'as' => 'table',
	'uses' => 'HomeController@getTable'
));

/*
| Authenticated group
*/
Route::group(array('before' => 'auth'), function() { //auth is found in filters.php

	/*
	| Log out (GET)
	*/
	Route::get('/account/logout', array(
		'as' => 'account-logout',
		'uses' => 'AccountController@getLogOut'
	));
});


/*
| Unauthenticated group
*/
Route::group(array('before' => 'guest'), function() {

	/*
	| Cross Site Request Forgery protection group
	*/
	Route::group(array('before' => 'csrf'), function() {

		/*
		| Register (create) Account (POST)
		*/
		Route::post('/account/register', array(
			'as' => 'account-register-post',
			'uses' => 'AccountController@postRegister'
		));


		/*
		| Log-in Account (POST)
		*/
		Route::post('/account/login', array(
			'as' => 'account-login-post',
			'uses' => 'AccountController@postLogin'
		));

	});


	/*
	| Log-in Account (GET)
	*/
	Route::get('/account/login', array(
		'as' => 'account-login',
		'uses' => 'AccountController@getLogin'
	));



	/*
	| Register (create) Account (GET)
	*/
	Route::get('/account/register', array(
		'as' => 'account-register',
		'uses' => 'AccountController@getRegister'
	));

});

Route::get('/vendor/vendormap', array(
	'as' => 'vendor-vendormap',
	'uses' => 'VendorController@loadXMLmap'
));

