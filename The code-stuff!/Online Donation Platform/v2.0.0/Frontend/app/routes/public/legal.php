<?php


/*
 #	legal.php
 #
 #	This file contains routes that are used to display legal pages.
*/




// Terms of service page
Route::get('/legal/terms-of-service', function(Request $request) {

	// Return view
	return view('public/legal/terms-of-service');

})->name('public-legal-terms');




// Privacy policy page
Route::get('/legal/privacy-policy', function(Request $request) {

	// Return view
	return view('public/legal/privacy-policy');

})->name('public-legal-privacy');




// Cookies information page
Route::get('/legal/cookies-policy', function(Request $request) {

	// Return view
	return view('public/legal/cookies');

})->name('public-legal-cookies');




// Charities terms page
Route::get('/legal/terms-for-charities', function(Request $request) {

	// Return view
	return view('public/legal/terms-for-charities');

})->name('public-legal-terms_for_charities');




// Fees information page
Route::get('/fees', function(Request $request) {

	// Return view
	return view('public/legal/fees');

})->name('public-fees');
