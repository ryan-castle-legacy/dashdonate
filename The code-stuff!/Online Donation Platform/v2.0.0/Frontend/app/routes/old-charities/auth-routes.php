<?php


use \App\Http\Controllers\DashDonate as API;




// Landing page for charities
Route::get('/charities', function() {

	return view('charities/landing');

})->name('charities-landing');




// Login page for charities
Route::get('/charities/login', function() {

	return view('charities/login');

})->name('charities-login');




// Register page for charities
Route::get('/charities/register', function() {
	return view('charities/register');
})->name('charities-register');




// Register page for charities - submit
Route::post('/charities/register', function() {
	// Get data from form
	$data = Request::all();
	// Check if user is logged in
	if (Auth::check()) {
		// Send user to next stage of registration process (charity details)
		return Redirect::route('charities-register_details')->withCookie(cookie('charity_preregister_info', json_encode($data), 45000));
	} else {
		// Redirect to the staff register page (with cookies set for the charity registration form)
		return Redirect::route('charities-register_staff')->withCookie(cookie('charity_preregister_info', json_encode($data), 45000))->withCookie(cookie('original_action', route('charities-register_details'), 45000));
	}
})->name('charities-register');




// Register page for staff of charities
Route::get('/charities/register/staff', function() {
	if (@Auth::check()) {
		return Redirect::route('charities-register_details');
	}
	return view('charities/register-staff');
})->name('charities-register_staff');




// Page for logged in staff to continue the registration of a charity
Route::get('/charities/register/details/{charity_id?}', function($charity_id = 0) {
	// Check if charity was set
	if ($charity_id == 0) {
		// Check if charity application ID is set
		if (Cookie::has('charity_preregister_info')) {
			// Get preregister info
			$data = json_decode(Cookie::get('charity_preregister_info'));
			// Create charity application in DB
			$application_id = API::create_charity_application($data->charity_name, $data->charity_reg);
			// Check application ID was created
			if ($application_id === false) {
				// Send user to initial application page
				return Redirect::route('charities-register');
			} else {
				if ($application_id == 'already_registered') {
					// Send user to initial application page
					return Redirect::route('charities-register');
				} else {
					// Refresh to application page
					return Redirect::route('charities-register_details', ['charity_id' => $application_id]);
				}
			}
		} else {
			// Send user to initial application page
			return Redirect::route('charities-register');
		}
	} else {
		// Check if charity cookie is set
		if (Cookie::has('charity_preregister_info')) {
			// Redirect back to this page and remove cookie
			return Redirect::route('charities-register_details', ['charity_id' => $charity_id])->withCookie(Cookie::forget('charity_preregister_info'));
		}
		// Get charity application
		$application = API::get_charity_application($charity_id, Auth::user()->id);
		// Check if charity ID exists
		if (@$application && $application->id == $charity_id) {
			return view('charities/register-details', ['details' => $application]);
		} else {
			// Send user to initial application page
			return Redirect::route('charities-register');
		}
	}
})->middleware('auth')->name('charities-register_details');




// Details page for charities - submit
Route::post('/charities/register/details/', function() {
	// Get data from form
	$data = Request::all();

	// Validate and check details



	// Update record
	$update = API::update_charity_application($data, Auth::user()->id, Request::ip());
	// Check if update was made
	if ($update) {
		// Send user to charity homepage
		return Redirect::route('charities-dashboard', ['charity_id' => $data['charity_id']]);
	}
	// Return back to form
	return Redirect::back()->with(['form_error' => 'Something went wrong']);

})->middleware('auth')->name('charities-register_details_submit');
