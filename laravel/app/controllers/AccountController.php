<?php
class AccountController extends BaseController {

	public function getLogin() {

		return View::make('account.loginPage');
	}

	public function postLogin() {
		$validator = Validator::make(Input::all(),
			array(
				'username' 		=> 'required|max:20|min:3',
				'password' 		=> 'required'
			)
		);

		if($validator->fails()) {
			//Redirect to Login page
			return Redirect::route('account-login')  // take user back to login page
				->withErrors($validator) //take errors declared in $validator along with route
				->withInput();  //put input back into the form 
		}
		else {
			//Attempt user login
			$auth = Auth::attempt(array(
				'username' 		=> Input::get('username'),
				'password' 		=> Input::get('password'),
				'active'		=> 1
			));

			if($auth) {
				// Return to intended page
				return Redirect::intended('/');
			} else {
				return Redirect::route('account-login')
					->with('global', 'Username/ password is incorrect.');		
			}
		}
		return Redirect::route('account-login')
				->with('global', 'There was a problem logging you in.');
	}


	/*
	|	Get the Log out View
	*/
	public function getLogOut() {

		// Call static logout method on Auth
		Auth::logout();
		return Redirect::route('home');
	}

	/*
	| Return the View for registering new accounts
	*/
	public function getRegister() {

		return View::make('account.registerPage');
	}

	/*
	| Submit the info after fillout the register form
	*/
	public function postRegister() {
		$validator = Validator::make(Input::all(), //Gives us ALL input we have
			array(
				'username' 			=> 'required|max:20|min:3|unique:users', //validate with unique username in users table
				'password' 			=> 'required|min:6',
				'password_again' 	=> 'required|same:password' //must match password
			)
		); 

		if($validator->fails()) {
			return Redirect::route('account-register') //redirect to registerPage
					->withErrors($validator)  //take errors declared in $validator along with route
					->withInput(); //put input back into the form 
		} else {
			// Create account
			$username 	= Input::get('username');
			$password 	= Input::get('password');

			// Creating user in the User DB model
			$user = User::create(array(
					'username' 	=> $username,
					'password' 	=> Hash::make($password), // 60-character hash in database table
					'active' 	=> 1 
			));
			
			// Create user's favorite list table username_vendors
			$con=mysqli_connect("","footrux_noms","pL2-#PZgKI79", "footrux_vendors");
			$sql = "CREATE TABLE ".
					$username.
					"_vendors( ".
					"id INT NOT NULL AUTO_INCREMENT, ".
					"name VARCHAR(60) NOT NULL, ".
					"address VARCHAR(80) NOT NULL, ".
					"lat FLOAT NOT NULL, ". 
					"lng FLOAT NOT NULL, ".
					"rating INT NOT NULL DEFAULT '0', ". 
					"fav TINYINT(1) NOT NULL DEFAULT '0', ".
					"PRIMARY KEY (id)); ";
			mysqli_query($con, $sql);
			mysqli_close($con);
			
			if($user) {
				return Redirect::route('home')
					->with('global', 'Your account has been created.'); //global variable indicate account is created
			}
		}
	}


}