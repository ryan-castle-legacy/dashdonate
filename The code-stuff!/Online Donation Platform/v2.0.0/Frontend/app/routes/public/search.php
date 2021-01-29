<?php


/*
 #	search.php
 #
 #	This file contains routes relating to the public search pages
*/




// Charity search main page
Route::get('/search/charities', function(Request $request) {

	// Redirect to holding page
	return Redirect::route('public-search-holding_charities');

	// // Return view
	// return view('public/search/charities');

})->name('public-search-charities');




// Charity list holding  page
Route::get('/our-charities', function(Request $request) {

	// Get charities
	$data = DB::table('charities')->where([
		'data_captured_from_commission'		=> true,
		'needs_dashdonate_approval'			=> false,
		'needs_representative'				=> false,
		'needs_representative_id'			=> false,
		'representative_id_pending'			=> false,
		'needs_details_review'				=> false,
		'needs_staff_added'					=> false,
		'needs_bank_account'				=> false,
		'bank_account_needs_verified'		=> false,
	])->orderBy('id', 'ASC')->get();

	// Check for results
	if ($data) {
		// Loop through results
		for ($i = 0; $i < sizeof($data); $i++) {
			// Get charity details
			$data[$i]->details = DB::table('charities_details')->where(['charity_id' => $data[$i]->id])->first();
			// Get logo file
			$data[$i]->details->logo = DB::table('file_uploads')->where(['id' => $data[$i]->details->logo_file_id])->first();
		}
	}

	// Return view
	return view('public/search/holding-charities', ['charities' => $data]);

})->name('public-search-holding_charities');
