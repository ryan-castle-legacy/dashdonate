<?php

use \App\Http\Controllers\DashDonate as API;

//
// // Confirm payment from 3D Secure page
// Route::get('/charity/{slug}/donate/secure-confirmation', function($slug) {
// 	// Retrieve request data
// 	$data = Request::all();
// 	// Get donation
// 	$donation = API::get_donation($data['?payment_intent'], 'true');
// 	// Handle donation via main handler method
// 	return API::donate_process_handle_intent($donation, $donation->metadata->charity_slug);
// })->middleware('auth')->name('paymentIntent_confirm');
//
//
// // Redirect user from donate page to add payment page (whilst setting cookie)
// Route::get('/charity/donate/payment-methods-empty/{slug}', function($slug) {
// 	// Redirect user to add payment card page
// 	return Redirect::route('payment-add_card')->withCookie(cookie('original_action', route('charity-donate', ['slug' => $slug]), 45000));
// })->middleware('auth')->name('donation-add_card-empty');
//
//
// // Redirect user from payment method needed to add payment page (whilst setting cookie)
// Route::get('/charity/donate/payment-method-add/{donation_id}', function($donation_id) {
// 	// Redirect user to add payment card page
// 	return Redirect::route('payment-add_card')->withCookie(cookie('original_action', route('donation-card_needed', ['donation_id' => $donation_id]), 45000));
// })->middleware('auth')->name('donation-add_card');
//
//
// // Submit adding card to donation
// Route::post('/charity/donate/payment/{donation_id}', function($donation_id) {
// 	// Get request data
// 	$data = Request::all();
// 	// Decode donation ID
// 	$donation_id = API::decode_donation_id($donation_id);
// 	// Get donation
// 	$donation = API::get_donation($donation_id);
// 	// Check if donation exists
// 	if (@$donation && @$donation->status) {
// 		// Check if donation requires payment method
// 		if ($donation->status == 'requires_payment_method') {
// 			// Get card ID from request
// 			$card_id = $data['card_id'];
// 			// Add card to intent (will return intent)
// 			$donation = API::add_card_to_intent($card_id, $donation_id);
// 		}
// 		// Handle donation via main handler method
// 		return API::donate_process_handle_intent($donation, $donation->metadata->charity_slug);
// 	}
// 	// Redirect user to 404 error page
// 	return Redirect::route('error-404');
// })->middleware('auth')->name('donation-card_needed');
//
//
// // Route to add a card to a donation
// Route::get('/charity/donate/payment/{donation_id}', function($donation_id) {
// 	// Decode donation ID
// 	$donation_id = API::decode_donation_id($donation_id);
// 	// Get donation
// 	$donation = API::get_donation($donation_id);
// 	// Check if donation exists
// 	if (@$donation && @$donation->status) {
// 		// Check status of intent is 'requires_payment_method'
// 		if ($donation->status == 'requires_payment_method') {
// 			// Get user cards
// 			$cards = API::get_user_payment_sources(Auth::user()->id);
// 			// Get charity
// 			$charity = API::get_charity($donation->metadata->charity_slug, true);
// 			// Check if charity was found
// 			if ($charity) {
// 				return view('charity-views/donate-add_payment_method', ['charity' => $charity, 'cards' => $cards, 'donation_id' => API::encode_donation_id($donation_id)]);
// 			}
// 		} else {
// 			// Handle donation via main handler method
// 			return API::donate_process_handle_intent($donation, $donation->metadata->charity_slug);
// 		}
// 	}
// 	// Send to 404 page
// 	return Redirect::route('error-404');
// })->middleware('auth')->name('donation-card_needed');
