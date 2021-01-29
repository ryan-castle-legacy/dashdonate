<?php


/*
 #	onboarding.php
 #
 #	This file contains routes that are used during charity account onboarding.
*/




// Include controller for onboarding
use \App\Http\Controllers\DashDonate_Charities_Onboarding as Logic;
use \App\Http\Controllers\DashDonate as API;




// Initial charity onboarding landing page
Route::get('/for-charities/', function(Request $request) {

	// Return view
	return view('charities/onboarding/landing');

})->name('charities-onboarding-landing');




// First stage of charity onboarding:
//	- Capturing the charity's goals
Route::get('/for-charities/get-started', function(Request $request) {

	// Return view
	return view('charities/onboarding/goals', ['goals' => Logic::onboardingGoals()]);

})->name('charities-onboarding-get_started');




// Submission of first stage of charity onboarding:
//	- Capturing the charity's goals
Route::post('/for-charities/get-started', 'DashDonate_Charities_Onboarding@getStarted')
	->name('charities-onboarding-get_started');




// Handles charity onboarding:
// - Captures charity registration number
Route::get('/for-charities/onboarding', function(Request $request) {

	// Return view
	return view('charities/onboarding/charity_registration_number');

})->middleware('auth', 'verified_user')->name('charities-onboarding-capture_details');




// Handles charity onboarding:
// - Captures charity details
Route::post('/for-charities/onboarding', 'DashDonate_Charities_Onboarding@captureDetails')
	->middleware('auth', 'verified_user')
	->name('charities-onboarding-capture_details');




// Handles charity onboarding after inital record creation"
// - Captures staff and basic representative data
Route::get('/for-charities/onboarding/{charity_slug}/{optional?}', function(Request $request, $charity_slug, $optional = null) {
	// Get charity record - This will reveal tasks to complete
	$charity = API::getCharityBySlug($charity_slug);
	// Check if representative is needed for the charity
	if (@$charity->needs_representative == true) {
		// Switch optional route parameter
		switch ($optional) {
			case 'invite':
				// Return view to invite a representative
				return view('charities/onboarding/invite_representative', ['charity' => $charity]);
			break;
			case 'representative':
				// Get charity trustees
				$trustees = API::getCharityTrustees($charity->charity_registration_number);
				// Return view to collect representative details
				return view('charities/onboarding/representative_details', ['charity' => $charity, 'trustees' => $trustees]);
			break;
			default:
				// Return view to give options about setting up a representative
				return view('charities/onboarding/representative_choice', ['charity' => $charity]);
			break;
		}
	}
	// Switch errors
	switch ($charity) {
		case 'not_found':
			// Send to 404 page
			return Redirect::route('error-404');
		break;
	}
	echo '<pre>';
	var_dump($charity);
	return;
	// Send to home page
	return Redirect::route('home');
})->middleware('auth', 'verified_user', 'charitystaffonly:all')->name('charities-onboarding-confirm_details');




// Handles form to confirm trustee ID, and displays next form to confirm representative details
Route::post('/for-charities/onboarding/{charity_slug}/representative', 'DashDonate_Charities_Onboarding@captureCheckRepresentativeDetails')->middleware('auth', 'verified_user', 'charitystaffonly:all')->name('charities-onboarding-confirm_details_representative');




// Displays form to take trustee personal details
Route::get('/for-charities/onboarding/{charity_slug}/personal/{trustee_id}', function(Request $request, $charity_slug, $trustee_id) {

	// Get charity record
	$charity = API::getCharityBySlug($charity_slug);
	// Handle validation that we can capture representative details
	$trustee = API::validateCharityTrustee($charity_slug, $trustee_id);
	// Return view to collect representative personal details
	return view('charities/onboarding/representative_details_personal', ['charity' => $charity, 'trustee' => $trustee]);

})->middleware('auth', 'verified_user', 'charitystaffonly:all')->name('charities-onboarding-collect_representative_personal');




// Handles form to take trustee personal details, and displays next form to upload ID documents
Route::post('/for-charities/onboarding/{charity_slug}/representative-personal', 'DashDonate_Charities_Onboarding@captureRepresentativePersonalDetails')->middleware('auth', 'verified_user', 'charitystaffonly:all')->name('charities-onboarding-representative_details_personal');




// Sends an email to invite someone to represent a charity
Route::post('/for-charities/onboarding/{charity_slug}', 'DashDonate_Charities_Onboarding@inviteRepresentative')->middleware('auth', 'verified_user', 'charitystaffonly:all')->name('charities-onboarding-invite_representative');
