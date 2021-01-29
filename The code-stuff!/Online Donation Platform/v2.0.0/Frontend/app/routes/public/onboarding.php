<?php


/*
 #	onboarding.php
 #
 #	This file contains routes that are used during user account onboarding.
*/




// Include controller for onboarding
use \App\Http\Controllers\DashDonate as API;




// Initial donor onboarding landing page
Route::get('/for-donors/', function(Request $request) {

	// Return view
	return view('public/onboarding/for_donors');

})->name('public-onboarding-landing');




// About DashDonate.org page
Route::get('/our-story/', function(Request $request) {

	// Return view
	return view('public/onboarding/our_story');

})->name('public-onboarding-our_story');


// Redirect
Route::get('/about', function(Request $request) {
	// Redirect
	return Redirect::route('public-onboarding-our_story');
});




// Capture user email address
Route::get('/register', function(Request $request) {

	// Return view
	return view('public/onboarding/capture_email');

})->middleware('must_be_guest')->name('public-onboarding-register');




// Submit to registration controller
Route::post('/register', 'Auth\RegisterController@register')->middleware('must_be_guest')->name('public-onboarding-register');




// Re-send verification email
Route::get('/register/resent-verification', function() {

	// Send API request to confirm user as verified
	$send = API::sendEmailToConfirm(Auth::user()->email, true);

	// Send user to user dashboard
	return Redirect::route('verify_email')->with(['success' => 'We have sent you another email verification code.']);

})->middleware('auth')->name('public-onboarding-register_resend');
