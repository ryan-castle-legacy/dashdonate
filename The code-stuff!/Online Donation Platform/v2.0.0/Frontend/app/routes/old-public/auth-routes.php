<?php


// Landing page for public
Route::get('/', function() {

	return view('public/landing');

})->name('public-landing');




// Login page for public
Route::get('/login', function() {

	return 'Public login';

})->name('public-login');




// Register page for public
Route::get('/register', function() {

	return 'Public register';

})->name('public-register');




// Register page for public
Route::get('/dashboard', function() {

	// Check if there is an original action set
	if (@Cookie::has('original_action')) {
		// Redirect user to original action and clear cookie
		return Redirect::to(Cookie::get('original_action'))->withCookie(Cookie::forget('original_action'));
	}

	return view('public/dashboard');

})->middleware('auth')->name('public-dashboard');
