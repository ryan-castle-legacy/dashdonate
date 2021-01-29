<?php

use \App\Http\Controllers\DashDonate as API;

//
// // Charity page
// Route::get('/charity/{slug}', function($slug) {
//
//
// 	// DB::table('charities')->insert([
// 	// 	'name'							=> 'Test Charity',
// 	// 	'slug'							=> 'test',
// 	// 	'owner_id'						=> 1,
// 	// 	'charity_registration_number'	=> 'abc123',
// 	// 	'payout_reference_id'			=> 'zyx098',
// 	// ]);
//
//
//
// 	// Get charity info
// 	$charity = API::get_charity($slug);
// 	// Check if charity was found
// 	if ($charity) {
//
// 		echo '<h1>'.$charity->name.'</h1>';
// 		echo '<h4>URL: '.env('APP_URL').'/charity/'.$charity->slug.'</h4>';
// 		echo '<p>Date created: '.date('jS F Y \a\t g:ia', strtotime($charity->date_created)).'</p>';
//
// 		echo '<br/>';
// 		echo '<a href="'.route('charity-donate', ['slug' => $charity->slug]).'"><button>Donate</button></a>';
//
// 		return;
//
// 	}
// 	return 'Not found';
// })->name('charity-homepage');
//
//
// // Fundraise for a charity
// Route::get('/fundraise-for-charity', function() {
// 	return 'Fundraise for a charity page';
// })->name('charity-fundraise_for');
//
//
//
//
//
//
//
//
//
// // Register a charity
// Route::get('/register/charity', function() {
// 	// Return page
// 	return view('charity-views/register');
// })->name('charity-register');
//
//
// // Submit charity registration form
// Route::post('/register/charity', function() {
// 	// Get form data
// 	$data = Request::all();
// 	// Create charity account
// 	if (Auth::check()) {
// 		$charity = API::create_charity_account(Auth::user()->id, $data['charity_registration_number'], $data['charity_name']);
// 	} else {
// 		$charity = API::create_charity_account(0, $data['charity_registration_number'], $data['charity_name']);
// 	}
// 	// Check if the response was an error response
// 	switch ($charity) {
// 		case 'crn_in_use':
// 			return Redirect::back()->withInput()->with('crn_in_use');
// 		break;
// 	}
// 	// Check if user is logged in
// 	if (Auth::check()) {
// 		// Send user to next stage of application
// 		return Redirect::route('charity-register_details')->withCookie(cookie('charity_id', route('charity-register_staff'), 45000));
// 	} else {
// 		// Send user to staff signup page
// 		return Redirect::route('charity-register_staff')->withCookie(cookie('charity_id', route('charity-register_staff'), 45000))->withCookie(cookie('original_action', route('charity-register_details'), 45000));
// 	}
// })->name('charity-register');
//
//
// // Create account for charity owner
// Route::get('/register/charity/owner', function() {
// 	// Return page
// 	return view('charity-views/register_owner');
// })->name('charity-register_staff');
//
//
// // Add details to charity application
// Route::get('/register/charity/details', function() {
//
// 	// Add charity info
//
// })->middleware('auth')->name('charity-register_details');
//
//
//
//
//
//
//
//
//
// // Donation page for charities
// Route::get('/charity/{slug}/donate', function($slug) {
// 	// Get user cards
// 	$cards = API::get_user_payment_sources(Auth::user()->id);
// 	// Check if payment source needs adding
// 	if ($cards == false || sizeof($cards) == 0) {
// 		return Redirect::route('payment-add_card')->withCookie(cookie('original_action', route('charity-donate', ['slug' => $slug]), 45000));
// 	}
// 	// Get charity info
// 	$charity = API::get_charity($slug, true);
// 	// Check if charity was found
// 	if ($charity) {
// 		return view('charity-views/donate-amount', ['charity' => $charity, 'cards' => $cards]);
// 	}
// 	return 'No charity found with slug "'.$slug.'".';
// })->middleware('auth')->name('charity-donate');
//
//
// // Prevent donation submit page receiving a "GET" method request
// Route::get('/charity/{slug}/donate/submit', function($slug) {
// 	return Redirect::route('charity-donate', ['slug' => $slug]);
// })->middleware('auth')->name('charity-donate_submit');
//
//
// // Submit donation form
// Route::post('/charity/{slug}/donate/submit', function($slug) {
// 	// Get charity info
// 	$charity = API::get_charity($slug, true);
// 	// Check if charity was found
// 	if ($charity) {
// 		// Get request data
// 		$request_data = Request::all();
// 		// Convert donation amount from pounds (£) to pence (p)
// 		$donation_amount = API::pounds_to_pence($request_data['donation_amount']);
// 		// Check if donation amount is over minimum
// 		if ($request_data['donation_amount_not_final'] < env('MIN_DONATION_PHP')) {
// 			// Return with error about donation being too small
// 			return Redirect::back()->withInput()->with(['form_error' => 'donation_too_low_warning', 'form_error_info' => env('MIN_DONATION_PHP')]);
// 		}
// 		// Get card ID from request
// 		$card_id = $request_data['card_id'];
// 		// Check whether to hide donation or not
// 		if (@$request_data['hide_donation'] == 'on') {
// 			// Set donation as hidden from view
// 			$anonymous_donation = true;
// 		} else {
// 			// Set donation as publicly visible
// 			$anonymous_donation = false;
// 		}
// 		// Calculate fees
// 		$minimum_fees = API::calculateMinimumDonationFees($request_data['donation_amount_not_final']);
// 		// Check if additional donation is set
// 		if (@$request_data['additional_donation']) {
// 			// Check if it's fees only
// 			if ($request_data['additional_donation'] == 'fees_only') {
// 				// Set fees as minimum fees (in pence)
// 				$fees = API::pounds_to_pence($minimum_fees);
// 			// Check if fee_type is 'other'
// 			} elseif ($request_data['additional_donation'] == 'other') {
// 				// Check if 'other' amount is more than the fees
// 				if ($request_data['additional_donation_other'] > $minimum_fees) {
// 					// Set fees as additional fees
// 					$fees = API::pounds_to_pence($request_data['additional_donation_other']);
// 				} else {
// 					// Return with error that donation amount is too low
// 					return Redirect::back()->withInput()->with(['form_error' => 'additional_fees_too_low', 'form_error_info' => $minimum_fees]);
// 				}
// 			// Unknown fee type
// 			} else {
// 				// Return error that unknown fee_type selection was made
// 				return Redirect::back()->withInput()->with(['form_error' => 'unknown_fee_type']);
// 			}
// 		} else {
// 			// Return back with error stating no additional fees were added
// 			return Redirect::back()->withInput()->with(['form_error' => 'no_additional_fees_added', 'form_error_info' => $minimum_fees]);
// 		}
// 		// Take a donation
// 		$donation = API::take_donation($donation_amount, $fees, $slug, $card_id, $anonymous_donation);
// 		// Handle intent and retrieve a redirection for the user to receive information about their donation
// 		return API::donate_process_handle_intent($donation, $slug);
// 	}
// 	return 'No charity found with slug "'.$slug.'".';
// })->middleware('auth')->name('charity-donate_submit');
//
//
// // Display that the donation was successful
// Route::get('/charity/donate/success/{donation_id}', function($donation_id) {
// 	// Decode donation ID
// 	$donation_id = API::decode_donation_id($donation_id);
//
// 	echo 'Successful - '.$donation_id;
// 	echo '<br/>';
// 	echo '<a href="'.route('payment-settings').'">Visit billing page (to view donation history)</a>';
//
// })->middleware('auth')->name('charity-donate_success');
//
//
// // Display that the donation was successful
// Route::get('/charity/donate/cancelled/{donation_id}', function($donation_id) {
// 	// Decode donation ID
// 	$donation_id = API::decode_donation_id($donation_id);
//
// 	echo 'Donation cancelled - '.$donation_id;
//
// 	// Intent was canceled, notify user of cancelation on web page - It's classed as an error, and users should try again or add a new card. If keeps happening after changing card, get in touch
//
// })->middleware('auth')->name('charity-donate_cancelled');
//
//
// // Route to display that the donation is processing
// Route::get('/charity/donate/processing/{donation_id}', function($donation_id) {
// 	// Decode donation ID
// 	$donation_id = API::decode_donation_id($donation_id);
//
// 	echo 'Donation processing - '.$donation_id;
//
// 	// If any server/db/functional actions are made (such as sending email receipts), add them to DashDonate.php controller so that webhooks can use the same code
// 		// - Notify user that payment is being processed
// 		// - Tell user that they will receive a notification once processed
// 			// Processing can result in succeeded or requires_capture or canceled, etc
// 			// Once the status changes it will be handled by webhooks
//
// })->middleware('auth')->name('charity-donate_processing');
