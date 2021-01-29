<?php


/*
 #	landing.php
 #
 #	This file contains routes relating to the public information pages
*/




// Terms of service page
Route::get('/', function(Request $request) {

	// Return view
	return view('public/onboarding/landing');

})->name('public-landing');
