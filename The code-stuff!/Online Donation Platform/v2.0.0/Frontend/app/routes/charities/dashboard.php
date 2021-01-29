<?php


/*
 #	dashboard.php
 #
 #	This file contains routes relating to the charities dashboard
*/




// Include controller
use \App\Http\Controllers\DashDonate as API;




// Dashboard main page
Route::get('/dashboard/charities/{charity_slug}', function(Request $request, $charity_slug) {

	// Get charity record
	$charity = API::getCharityBySlug($charity_slug, Auth::user()->id);

	// Check if charity was not found
	if (!$charity && gettype($charity) != 'object') {
		// Return 404
		return Redirect::route('error-404');
	}

	// Default value
	$hasNotice = false;
	// Check if notice needs displaying
	if (Session::has('success') 									||
		Session::has('error') 										||
		$charity->needs_representative_id == true					||
		$charity->representative_id_pending == true					||
		$charity->needs_bank_account == true						||
		$charity->bank_account_needs_verified == true				||
		$charity->needs_charity_proof_of_address == true			||
		$charity->needs_charity_proof_of_address_pending == true	||
		$charity->needs_details_review == true						||
		$charity->needs_staff_added == true)
	{
		$hasNotice = true;
	}

	// Return view
	return view('charities/dashboard-new/dashboard', ['hasNotice' => $hasNotice, 'navSection' => 'home', 'needsFooter' => false, 'charity' => $charity]);

})->middleware('auth', 'verified_user', 'verified_charity', 'charitystaffonly:all')->name('charities-dashboard');




// Donations data page
Route::get('/dashboard/charities/{charity_slug}/donations', function(Request $request, $charity_slug) {

	// Get charity record
	$charity = API::getCharityBySlug($charity_slug, Auth::user()->id);

	// echo '<pre>';
	// var_dump($charity);
	// return;

	// Check if charity was not found
	if (!$charity && gettype($charity) != 'object') {
		// Return 404
		return Redirect::route('error-404');
	}

	// Return view
	return view('charities/dashboard-new/donations', ['navSection' => 'donations', 'needsFooter' => false, 'charity' => $charity, 'dateWeekdays' => API::getDateWeekdays()]);

})->middleware('auth', 'verified_user', 'verified_charity', 'charitystaffonly:all')->name('charities-dashboard-donations');




// Audience data page
Route::get('/dashboard/charities/{charity_slug}/audience', function(Request $request, $charity_slug) {

	// Get charity record
	$charity = API::getCharityBySlug($charity_slug, Auth::user()->id);

	// var_dump($charity);
	// return;

	// Check if charity was not found
	if (!$charity && gettype($charity) != 'object') {
		// Return 404
		return Redirect::route('error-404');
	}




	// Return view
	return view('charities/dashboard-new/audience', ['navSection' => 'audience', 'needsFooter' => false, 'charity' => $charity, 'dateWeekdays' => API::getDateWeekdays()]);

})->middleware('auth', 'verified_user', 'verified_charity', 'charitystaffonly:all')->name('charities-dashboard-audience');




// // Fundraisers listing page
// Route::get('/dashboard/charities-new/{charity_slug}/fundraisers', function(Request $request, $charity_slug) {
//
// 	// Get charity record
// 	$charity = API::getCharityBySlug($charity_slug, Auth::user()->id);
//
// 	// Check if charity was not found
// 	if (!$charity && gettype($charity) != 'object') {
// 		// Return 404
// 		return Redirect::route('error-404');
// 	}
//
// 	// Return view
// 	return view('charities/dashboard-new/fundraisers', ['navSection' => 'fundraisers', 'needsFooter' => false, 'charity' => $charity]);
//
// })->middleware('auth', 'verified_user', 'verified_charity', 'charitystaffonly:all')->name('charities-dashboard-fundraisers');




// Dashboard charity about page - For editing charity info
Route::get('/dashboard/charities/{charity_slug}/about', function(Request $request, $charity_slug) {

	// Get charity record
	$charity = API::getCharityBySlug($charity_slug, Auth::user()->id);

	// Check if charity was not found
	if (!$charity && gettype($charity) != 'object') {
		// Return 404
		return Redirect::route('error-404');
	}

	// Default value
	$hasNotice = false;
	// Check if notice needs displaying
	if (Session::has('success') 				||
		Session::has('error') 					||
		$charity->needs_details_review == true)
	{
		$hasNotice = true;
	}

	// Return view
	return view('charities/dashboard-new/about', ['hasNotice' => $hasNotice, 'navSection' => 'charityInfo', 'needsFooter' => false, 'charity' => $charity]);

})->middleware('auth', 'verified_user', 'verified_charity', 'charitystaffonly:all')->name('charities-dashboard-about');




// Dashboard charity staff page - For editing charity staff
Route::get('/dashboard/charities/{charity_slug}/staff', function(Request $request, $charity_slug) {

	// Get charity record
	$charity = API::getCharityBySlug($charity_slug, Auth::user()->id);

	// Check if charity was not found
	if (!$charity && gettype($charity) != 'object') {
		// Return 404
		return Redirect::route('error-404');
	}

	// Default value
	$hasNotice = false;
	// Check if notice needs displaying
	if (Session::has('success') 				||
		Session::has('error') 					||
		Session::has('email') 					||
		$charity->needs_staff_added == true)
	{
		$hasNotice = true;
	}

	// Return view
	return view('charities/dashboard-new/staff', ['hasNotice' => $hasNotice, 'navSection' => 'staff', 'needsFooter' => false, 'charity' => $charity]);

})->middleware('auth', 'verified_user', 'verified_charity', 'charitystaffonly:all')->name('charities-dashboard-staff');















































// // Dashboard main page
// Route::get('/dashboard/charities/{charity_slug}', function(Request $request, $charity_slug) {
//
// 	// Get charity record
// 	$charity = API::getCharityBySlug($charity_slug, Auth::user()->id);
//
// 	// Check if charity was not found
// 	if (!$charity && gettype($charity) != 'object') {
// 		// Return 404
// 		return Redirect::route('error-404');
// 	}
//
// 	// Return view
// 	return view('charities/dashboard/dashboard', ['charity' => $charity]);
//
// })->middleware('auth', 'verified_user', 'verified_charity', 'charitystaffonly:all')->name('charities-dashboard');




// // Dashboard donations list
// Route::get('/dashboard/charities/{charity_slug}/donations', function(Request $request, $charity_slug) {
//
// 	// Get charity record
// 	$charity = API::getCharityBySlug($charity_slug, Auth::user()->id, true);
//
// 	// Check if charity was not found
// 	if (!$charity && gettype($charity) != 'object') {
// 		// Return 404
// 		return Redirect::route('error-404');
// 	}
//
// 	// List of days
// 	$dateDays = array('1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th', '12th', '13th', '14th', '15th', '16th', '17th', '18th', '19th', '20th', '21st', '22nd', '23rd', '24th', '25th', '26th', '27th', '28th');
// 	// List of weekdays
// 	$dateWeekdays = array('Sunday', 'Monday', 'Tueday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
//
// 	// echo '<pre>';
// 	// var_dump($charity);
// 	// return;
//
// 	// Return view
// 	return view('charities/dashboard/donations', ['charity' => $charity, 'dateDays' => $dateDays, 'dateWeekdays' => $dateWeekdays]);
//
// })->middleware('auth', 'verified_user', 'verified_charity', 'charitystaffonly:all')->name('charities-dashboard-donations');




// Dashboard charity about page - For editing charity info
Route::get('/dashboard/charities-old/{charity_slug}/about', function(Request $request, $charity_slug) {

	// Get charity record
	$charity = API::getCharityBySlug($charity_slug, Auth::user()->id);

	// Check if charity was not found
	if (!$charity && gettype($charity) != 'object') {
		// Return 404
		return Redirect::route('error-404');
	}

	// Return view
	return view('charities/dashboard/about', ['charity' => $charity]);

})->middleware('auth', 'verified_user', 'verified_charity', 'charitystaffonly:all');//->name('charities-dashboard-about');




// Sends an email to invite someone to join a charity
Route::post('/dashboard/charities/{charity_slug}/about/update', function(Request $request, $charity_slug) {

	// Capture data in request
	$data = Request::all();
	// Update charity profile
	$update = API::updateCharityDisplayInformation($charity_slug, Auth::user()->id, $data);

	// Check for success
	if (@$update->success == true && @$update->slug) {
		// Send success
		return Redirect::route('charities-dashboard-about', ['charity_slug' => $update->slug])->with(['success' => 'Your charity\'s details have been published.']);
	} else {

		// echo '<pre>';
		// var_dump($update);
		// return;

		// Check if error is string
		if (gettype($update) == 'string') {
			// Switch error code
			switch ($update) {
				case 'not_administrator':
					return Redirect::back()->withInput()->withErrors(['error' => 'You are not permitted to make this change.']);
				break;
				case 'logo_required':
					return Redirect::back()->withInput()->withErrors(['error' => 'You must upload a logo before publishing your page.']);
				break;
				case 'slug_invalid':
					return Redirect::back()->withInput()->withErrors(['error' => 'The URL slug that you entered was invalid.']);
				break;
				case 'slug_in_use':
					return Redirect::back()->withInput()->withErrors(['error' => 'The URL slug that you entered is already in use.']);
				break;
			}
		}
		return Redirect::back()->withInput()->withErrors(['display_name' => 'Your charity name must not be blank.']);

	}
})->middleware('auth', 'verified_user', 'charitystaffonly:administrator')->name('modals-charities-dashboard-about-confirm');




// // Dashboard charity staff page - For editing charity staff
// Route::get('/dashboard/charities/{charity_slug}/staff', function(Request $request, $charity_slug) {
//
// 	// Get charity record
// 	$charity = API::getCharityBySlug($charity_slug, Auth::user()->id);
//
// 	// Check if charity was not found
// 	if (!$charity && gettype($charity) != 'object') {
// 		// Return 404
// 		return Redirect::route('error-404');
// 	}
//
// 	// Return view
// 	return view('charities/dashboard/staff', ['charity' => $charity]);
//
// })->middleware('auth', 'verified_user', 'verified_charity', 'charitystaffonly:all')->name('charities-dashboard-staff');




// Sends an email to invite someone to join a charity
Route::post('/dashboard/charities/{charity_slug}/staff/invite', 'DashDonate_Charities_Onboarding@inviteStaff')->middleware('auth', 'verified_user', 'charitystaffonly:administrator')->name('modals-charities-dashboard-staff-invite');




// Dashboard charity staff page - For editing charity staff
Route::get('/dashboard/charities/{charity_slug}/widgets', function(Request $request, $charity_slug) {

	// Get charity record
	$charity = API::getCharityBySlug($charity_slug, Auth::user()->id);

	// Check if charity was not found
	if (!$charity && gettype($charity) != 'object') {
		// Return 404
		return Redirect::route('error-404');
	}

	// Return view
	return view('charities/dashboard/widgets', ['charity' => $charity]);

})->middleware('auth', 'verified_user', 'verified_charity', 'charitystaffonly:all')->name('charities-dashboard-widgets');




// Handles adding a URL to the authorised list for widgets
Route::post('/dashboard/charities/{charity_slug}/widgets/add', function(Request $request, $charity_slug) {

	// Add website to list
	$add = API::addAuthorisedWebsite($charity_slug, Request::get('url'));

	// Check for success
	if ($add && @$add->success == true) {
		// Return redirect with success message
		return Redirect::back()->with(['success' => 'Website added successfully.']);
	}
	// Return redirect with success message
	return Redirect::back()->withErrors(['url' => 'This website is not valid.']);

})->middleware('auth', 'verified_user', 'charitystaffonly:administrator')->name('modals-charities-dashboard-add-widget-website');




// Handles deleting a URL to the authorised list for widgets
Route::post('/dashboard/charities/{charity_slug}/widgets/delete', function(Request $request, $charity_slug) {

	// Remove website to list
	$remove = API::removeAuthorisedWebsite($charity_slug, Request::get('website_id'));

	// Check for success
	if ($remove && @$remove->success == true) {
		// Return redirect with success message
		return Redirect::back()->with(['success' => 'Website removed successfully.']);
	}
	// Return redirect with success message
	return Redirect::back()->withErrors(['url' => 'Something went wrong, please try again.']);

})->middleware('auth', 'verified_user', 'charitystaffonly:administrator')->name('modals-charities-dashboard-delete-widget-website');
