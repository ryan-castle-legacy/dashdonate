<?php


/*
 #	public.php
 #
 #	This file contains routes that display charity data to the public.
*/




// Include controller for onboarding
use \App\Http\Controllers\DashDonate as API;




// Charity public homepage
Route::get('/charities/{charity_slug}', function(Request $request, $charity_slug) {

	// Check if user is logged in
	if (Auth::check()) {
		// Get charity record
		$charity = API::getCharityBySlug($charity_slug, Auth::user()->id);
	} else {
		// Get charity record
		$charity = API::getCharityBySlug($charity_slug);
	}

	// Check if charity was found
	if ($charity && @$charity->slug) {

		// Check if charity should not be public
		if (!$charity->is_activated_for_public)	{
			// Send to 404 error as charity should not be public
			return Redirect::route('error-404');
		}

		// Return view
		return view('charities/public/homepage', ['public_seo' => true, 'charity' => $charity]);

	} else {
		// Return not found
		return Redirect::route('error-404');
	}

})->name('charities-public-homepage');
