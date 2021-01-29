<?php

use \App\Http\Controllers\DashDonate as API;


// Display main landing page
Route::get('/', function() {
	// Check if user is logged in
	if (Auth::check()) {
		return Redirect::route('home');
	}
	return view('public-views/landing');
})->name('public-home');


// Get involved page page
Route::get('/get-involved', function() {
	return view('public-views/get-involved');
})->name('public-get_involved');


// About DashDonate page
Route::get('/about', function() {
	return view('public-views/about');
})->name('public-about_dashdonate');


// Charity information page
Route::get('/for-charities', function() {
	return view('public-views/for_charities');
})->name('public-for_charities');


// Donor information page
Route::get('/for-donors', function() {
	return view('public-views/for_donors');
})->name('public-for_donors');


// Route::get('/terms-of-service', function() {
// 	return view('public-views/terms_of_contribution');
// })->name('public-terms');

Route::get('/terms-of-contribution', function() {
	return view('public-views/terms_of_contribution');
})->name('public-terms_contribute');

Route::get('/privacy-policy', function() {
	return view('public-views/privacy_policy');
})->name('public-privacy');


Route::get('/contribute', function() {
	return Redirect::route('public-get_involved');
});

Route::post('/pre-signup', function() {
	$data = Request::all();
	$signup = API::presignup($data['email'], $data['type']);
	return Redirect::back()->with(['success_message' => true]);
})->name('pre-signup');

Route::post('/contribute', function() {

	$data = Request::all();

	if (trim($data['name']) == '') {
		return Redirect::to(URL::previous().'#payment-form')->withInput()->with(['form_error' => 'name_is_required']);
	}
	if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
		return Redirect::to(URL::previous().'#payment-form')->withInput()->with(['form_error' => 'email_invalid']);
	}

	// Convert donation amount from pounds (£) to pence (p)
	$data['amount'] = API::pounds_to_pence($data['donation_amount_not_final']);
	// Check if donation is too small
	if ($data['amount'] < 200) {
		return Redirect::to(URL::previous().'#payment-form')->withInput()->with(['form_error' => 'donation_too_low_warning']);
	}

	$send_contribution = API::contribute_to_project($data);

	// Check if successful
	if (@$send_contribution->status == 'succeeded') {
		// Send to success
		return Redirect::route('contribute_success');
	} else {
		// Check if status exists or if an error occurred
		if (isset($send_contribution->status)) {
			// Status to now work with and resolve issue
			return API::contribute_process_handle_intent($send_contribution);
		} else {

			// Error
			return Redirect::route('contribution_failed');
		}
	}
})->name('public-contribute_submit');


// Confirm payment from 3D Secure page
Route::get('/contribution/secure-confirmation', function() {
	// Retrieve request data
	$data = Request::all();

	var_dump($data);
	// Get donation
	$contribution = API::get_contribution($data['?payment_intent']);
	// // Handle donation via main handler method
	return API::contribute_process_handle_intent($contribution);
})->name('paymentIntent_confirm');



Route::get('/contribute/failed', function() {
	return view('public-views/contribute-failed');
})->name('contribution_failed');

Route::get('/contribute/processing', function() {
	return view('public-views/contribute-processing');
})->name('contribute_processing');

Route::get('/contribute/success', function() {
	return view('public-views/contribute-success');
})->name('contribute_success');


//
// // Route to refer a charity
// Route::get('/refer-charity', function() {
// 	// Route to refer charities to us (we get in touch with them)
// })->name('public-refer_charity');
//
//
// // Process search form to make it a GET request
// Route::post('/search-submit/{type}', function($type) {
// 	// Check query was set
// 	if (Request::has('nav_search_query')) {
// 		// Redirect to "GET" query method of submitting search
// 		return Redirect::route('public-search', ['type' => $type, 'query' => Request::get('nav_search_query')]);
// 	} else {
// 		// Redirect to search page
// 		return Redirect::route('public-search', ['type' => 'all']);
// 	}
// })->name('public-search_submit');
//
// // "Search charities, fundraisers and more"
// Route::get('/search/{type}/{query?}', function($type, $query = '') {
// 	// Perform search
// 	$results = array();
// 	// Return search results page
// 	return view('public-views/search_results', ['results' => $results, 'query' => $query]);
// })->name('public-search');
