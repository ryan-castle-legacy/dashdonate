<?php


require_once 'ajax/ajax.php';
require_once 'charities/routes.php';
require_once 'public/routes.php';
require_once 'admin/routes.php';
require_once 'widgets/widgets.php';
require_once 'widgets/widgets-2.php';


// require_once 'new/public/routes.php';



// Include auth routes
// Auth::routes();




// Include DashDonate API
use \App\Http\Controllers\DashDonate as API;
use Carbon\Carbon;




// Control where users go when sent 'home'
Route::get('/home', function() {
	// Check if user is signed in
	if (Auth::check()) {
		// Check if user is not verified
	 	if (Auth::user()->is_email_confirmed == false) {
			// Send to verification page
			return Redirect::route('verify_email');
		}
		// Check if there is an original action set
		if (@Cookie::has('original_action')) {
			// Redirect user to original action and clear cookie
			return Redirect::to(Cookie::get('original_action'))->withCookie(Cookie::forget('original_action'));
		}
		// Send to dashboard and reset cookies
		return Redirect::route('public-dashboard')
			->withCookie(Cookie::forget('original_action'))
			->withCookie(Cookie::forget('register_email'))
			->withCookie(Cookie::forget('login_email'))
			->withCookie(Cookie::forget('goals_list'));
	} else {
		// Check if there is an original action set
		if (@Cookie::has('original_action')) {
			// Redirect user to original action and clear cookie
			return Redirect::to(Cookie::get('original_action'))->withCookie(Cookie::forget('original_action'));
		}
		// Send to public landing and reset cookies
		return Redirect::route('public-landing')
			->withCookie(Cookie::forget('original_action'))
			->withCookie(Cookie::forget('register_email'))
			->withCookie(Cookie::forget('login_email'))
			->withCookie(Cookie::forget('goals_list'));
	}
})->name('home');




// Display login form
Route::get('/login', function(Request $request) {

	// Return view
	return view('public/auth/login');

})->name('login')->middleware('must_be_guest');




// Manage users logging in
Route::post('/login', 'Auth\LoginController@login')->name('login')->middleware('must_be_guest');




// Manage users logging out
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');




// Display password reset request form
Route::get('/forgot-password', function(Request $request) {

	// Return view
	return view('public/auth/forgot-password');

})->name('forgot-password')->middleware('must_be_guest');




// Handle password reset submission
Route::post('/forgot-password', 'DashDonate_Users@forgotPassword')->name('forgot-password')->middleware('must_be_guest');;




// Display password reset form
Route::get('/reset-password/{token}', function(Request $request, $token) {

	// Check if token is valid
	if (API::getResetPasswordToken($token)) {
		// Return reset view
		return view('public/auth/reset-password', ['token' => $token]);
	} else {
		// Send to expired page
		return Redirect::route('forgot-password-expired', ['token' => $token]);
	}

})->middleware('must_be_guest');




// Submit new password to database
Route::post('/reset-password/{token}', function(Request $request, $token) {

	// Reset password
	$reset = API::resetPasswordViaToken($token, Request::get('password'));
	// Check if successful
	if ($reset) {

		// Log user in
		Auth::login(App\User::where('email', $reset)->first());
		// Send to homepage
		return Redirect::route('home');
	} else {
		// Return that the request expired
		return Redirect::route('forgot-password-expired', ['token' => $token]);
	}

})->name('reset-password-new')->middleware('must_be_guest');




// Display password reset request form
Route::get('/reset-password/{token}/expired', function(Request $request) {

	// Return view
	return view('public/auth/reset-password-expired');

})->name('forgot-password-expired')->middleware('must_be_guest');




// Display password set form
Route::get('/set-password/', function(Request $request) {

	// Return reset view
	return view('public/auth/set-password');

})->middleware('auth')->name('set_user_password');




// Submit new password to database
Route::post('/set-password/', function(Request $request) {

	// Reset password
	$reset = API::resetPasswordViaForced(Request::get('password'), Auth::user()->id);
	// Check if successful
	if ($reset) {
		// // Log user in
		// Auth::login(App\User::where('email', $reset)->first());
		// Send to homepage
		return Redirect::route('home');
	} else {

		var_dump($reset);
		return;
		// Return that the request expired
		return Redirect::route('set_user_password');
	}

})->name('set-password-new')->middleware('auth');




// Display login form
Route::get('/dashboard/verify-email', function(Request $request) {

	// Return view
	return view('public/auth/verify-email');

})->middleware('auth')->name('verify_email');




// Display login form
Route::post('/dashboard/verify-email', function(Request $request) {
	// Check if user has already passed verification
	if (@Auth::user()->is_email_confirmed === true) {
		// Send user to 'home' route
		return Redirect::route('home');
	} else {
		// Get the code that was entered
		$code = Request::get('code');
		// Check if the code entered was correct
		if ($code === Auth::user()->email_confirm_code) {
			// Send API request to confirm user as verified
			API::confirmUserEmail(Auth::user()->id);
			// Send user to 'home' route
			return Redirect::route('home');
		}
	}
	// Return user back to confirmation to try again
	return Redirect::back()->withErrors(['code' => 'The code you entered was not correct.']);
})->middleware('auth')->name('verify_email');












//
// // Function to calculate donation fees
// function calculateFees($amount, $log = false) {
// 	// Parse amount
// 	$amount = intval($amount);
// 	// Get fee information
// 	$fee_string = explode('|', env('MIN_FEE_FORMULA_PHP'));
// 	// Get fees from env string
// 	$fees_items = array(
// 		'stripe_percentage'		=> floatval($fee_string[0]),
// 		'stripe_pounds'			=> floatval($fee_string[1]),
// 		'dashdonate_pounds'		=> floatval($fee_string[2]),
// 	);
//
// 	$fees = $amount;
// 	// if ($log) { echo 'f-am:'.var_dump($fees).'<br/>'; }
//
// 	// if ($log) { echo '==S%:'.var_dump($fees_items['stripe_percentage']).'<br/>'; }
//
//
// 	// // Calculate fees and turn into pence
// 	// var fees = (((amount + fees_items.stripe_pounds + fees_items.dashdonate_pounds) / fees_items.stripe_percentage) * 100);
// 	// // Ceil sub-pence and divide back down to pence
// 	// fees = (Math.ceil(fees) / 100);
// 	// // Calculate minimum fee (take away donation amount from total calculated above)
// 	// fees = (fees - amount);
// 	// // Return fees
// 	// return fees.toFixed(2);
//
// 	$fees = $fees + ($fees_items['dashdonate_pounds'] * 100);
// 	if ($log) { echo '+ Dash £:&nbsp;&nbsp; '; var_dump($fees); echo '<br/>'; }
//
// 	$fees = $fees + ($fees_items['stripe_pounds'] * 100);
// 	if ($log) { echo '+ Stripe £:&nbsp; '; var_dump($fees); echo '<br/>'; }
//
// 	$fees = floor($fees / $fees_items['stripe_percentage']);
// 	if ($log) { echo '+ Stripe %:&nbsp; '; var_dump($fees); '<br/>'; }
//
// 	// Remove original amount from fees calculation
// 	$fees = $fees - $amount;
//
// 	// Return fees
// 	return intval($fees);
// }
//
//
// // Display login form
// Route::get('/x', function(Request $request) {
//
// 	$tests = array(1, 20, 10);
//
// 	foreach ($tests as $test) {
//
// 		$test = intval(floatval($test) * 100);
//
// 		echo 'Amount: '; var_dump($test); echo '<br/>';
//
// 		echo '<br/>';
// 		$fees = calculateFees($test, true);
// 		echo '<br/><br/>Fees: '; var_dump($fees); echo '<br/>';
//
// 		echo '<br/>';
// 		echo 'Tot to take: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; var_dump($test); echo '<br/>';
// 		echo 'Tot to charity:&nbsp; '; var_dump($test - calculateFees($test)); echo '<br/>';
// 		echo '<hr/>';
// 	}
//
// });








// Route::get('/old-widget', function(Request $request) {
//
// 	// Get charity record
// 	$charity = API::getCharityBySlug('teenage-cancer-trust');
// 	// Return view
// 	return view('temp', ['public_seo' => true, 'charity' => $charity]);
//
// });//->middleware('auth', 'must_be_admin');
//
// Route::get('/new-widget', function(Request $request) {
//
// 	// Get charity record
// 	$charity = API::getCharityBySlug('teenage-cancer-trust');
// 	// Return view
// 	return view('temp-2', ['public_seo' => true, 'charity' => $charity]);
//
// });//->middleware('auth', 'must_be_admin');

// Route::get('/new-widget-raw', function(Request $request) {
//
// 	// Get charity record
// 	$charity = API::getCharityBySlug('teenage-cancer-trust');
// 	// Return view
// 	return view('temp-2-raw', ['public_seo' => true, 'charity' => $charity]);
//
// });//->middleware('auth', 'must_be_admin');












Route::get('/xx', function(Request $request) {

	$data = API::xx();

	echo '<pre>';
	var_dump($data);
	return;

});
