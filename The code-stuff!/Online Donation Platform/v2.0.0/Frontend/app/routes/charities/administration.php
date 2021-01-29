<?php


/*
 #	administration.php
 #
 #	This file contains routes relating to the charities administrators
*/




// Include controllers
use \App\Http\Controllers\DashDonate_Charities_Onboarding as Logic;
use \App\Http\Controllers\DashDonate as API;




// Handle staff invites
Route::get('/invite/charity/{invite_token}', 'DashDonate_Charities_Onboarding@handleRepresentativeInvite')->name('charities-invite');




// Handle response to charity invite
Route::post('/invite/charity/{invite_token}/respond', 'DashDonate_Charities_Onboarding@handleRepresentativeInviteResponse')->name('charities-invite-response');




// Return view to ask user to logout of current user and register a new profile for the invite
Route::get('/invite/charity/action/logout', function() {

	// Return view
	return view('charities/onboarding/invite_please_logout');

})->name('charities-invite-logout');




// Return view to ask user to logout of current user and signin to another account
Route::get('/invite/charity/action/logout-existing', function() {

	// Return view
	return view('charities/onboarding/invite_please_logout_existing');

})->name('charities-invite-logout_existing');




// Return view to register a new profile for the invite
Route::get('/invite/charity/action/register', function() {

	// Return view
	return view('charities/onboarding/invite_please_register');

})->name('charities-invite-register');




// Return view to notify user that the invite has expired
Route::get('/invite/charity/action/expired', function() {

	// Return view
	return view('charities/onboarding/invite_expired');

})->name('charities-invite-expired');




// Displays form to take trustee ID documents
Route::get('/dashboard/charities/{charity_slug}/identification/', function(Request $request, $charity_slug) {

	// Get charity record
	$charity = API::getCharityBySlug($charity_slug, Auth::user()->id);

	// Check if ID does not need action
	if ($charity->needs_representative_id == false) {
		// Redirect back to dashboard
		return Redirect::route('charities-dashboard', ['charity_slug' => $charity_slug]);
	}

	// Return view
	return view('charities/administration/representative_identity', [
		'charity' 				=> $charity,
		'proof_of_id_types' 	=> Logic::typesOfIdentityDocument(),
	]);

})->middleware('auth', 'verified_user', 'verified_charity', 'charitystaffonly:representative')->name('charities-onboarding-collect_representative_id');




// Submits ID documents to stripe
Route::post('/dashboard/charities/{charity_slug}/identification/', 'DashDonate_Charities_Onboarding@submitIdentificationForRepresentative')->middleware('auth', 'verified_user', 'verified_charity', 'charitystaffonly:representative')->name('charities-onboarding-representative_identity');




// Displays form to take charity bank details
Route::get('/dashboard/charities/{charity_slug}/bank-account/', function(Request $request, $charity_slug) {

	// Get charity record
	$charity = API::getCharityBySlug($charity_slug, Auth::user()->id);

	// Check if bank account does not need action
	if ($charity->needs_bank_account == false) {
		// Redirect back to dashboard
		return Redirect::route('charities-dashboard', ['charity_slug' => $charity_slug]);
	}

	// Return view
	return view('charities/administration/bank_account', ['charity' => $charity]);

})->middleware('auth', 'verified_user', 'verified_charity', 'charitystaffonly:representative')->name('charities-administration-collect_bank_account');




// Collect charity bank details
Route::post('/dashboard/charities/{charity_slug}/bank-account/', 'DashDonate_Charities_Onboarding@captureCharityBankDetails')->middleware('auth', 'verified_user', 'verified_charity', 'charitystaffonly:representative')->name('charities-administration-collect_bank_account');










// Displays form to take proof of registered address documents
Route::get('/dashboard/charities/{charity_slug}/registered-address/', function(Request $request, $charity_slug) {

	// Get charity record
	$charity = API::getCharityBySlug($charity_slug, Auth::user()->id);

	// Check if registered address does not need action
	if ($charity->needs_charity_proof_of_address == false) {
		// Redirect back to dashboard
		return Redirect::route('charities-dashboard', ['charity_slug' => $charity_slug]);
	}

	// Return view
	return view('charities/administration/proof_of_registered_address', [
		'charity' 				=> $charity,
		'proof_of_id_types' 	=> Logic::typesOfIdentityDocument(),
	]);

})->middleware('auth', 'verified_user', 'verified_charity', 'charitystaffonly:representative')->name('charities-onboarding-collect_registered_address');




// Submits ID documents to stripe
Route::post('/dashboard/charities/{charity_slug}/registered-address/', 'DashDonate_Charities_Onboarding@submitRegisteredAddressDocument')->middleware('auth', 'verified_user', 'verified_charity', 'charitystaffonly:representative')->name('charities-onboarding-registered_address');
