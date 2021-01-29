<?php


/*
 #	account.php
 #
 #	This file contains routes relating to user account management
*/




// Include controller for onboarding
use \App\Http\Controllers\DashDonate as API;




// User account settings page
Route::get('/account/', function(Request $request) {

	// Get user's billing data from API
	$billing = API::getUserBillingSettings(Auth::user()->id);

	// Return view
	return view('public/account/account', ['billing' => $billing]);

})->middleware('auth', 'verified_user')->name('public-account');



// Update user's account settings - firstname and lastname
Route::post('/account/update', function(Request $request) {

	// Update the user's account details
	$update = API::updateUserAccountDetails(Auth::user()->id, Request::all());

	// Check for success
	if ($update) {
		// Return success
		return Redirect::back()->with(['success' => 'Your account settings have been updated.']);
	}
	// Return error message
	return Redirect::back()->withErrors(['error' => 'Something went wrong, please try again.']);

})->middleware('auth', 'verified_user')->name('public-account-update_details');
