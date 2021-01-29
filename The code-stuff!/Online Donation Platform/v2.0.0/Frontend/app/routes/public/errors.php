<?php


/*
 #	errors.php
 #
 #	This file contains routes for error pages
*/




// Error page for 403 errors
Route::get('/error/403', function(Request $request) {

	// Return view
	return view('public/errors/403');

})->name('error-403');




// Error page for 404 errors
Route::get('/error/404', function(Request $request) {

	// Return view
	return view('public/errors/404');

})->name('error-404');
