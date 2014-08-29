<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function home()
	{
		//echo $user = User::find(0)->username;
		//echo $vendor = Vendor::find(1)->name;
		return View::make('home');
	}
	
	public function getTable() {
		return View::make('viewTable');
	}

}