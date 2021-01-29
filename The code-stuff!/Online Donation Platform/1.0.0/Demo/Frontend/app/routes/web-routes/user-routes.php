<?php

// use \Request;
use \App\Http\Controllers\DashDonate as API;

//
// // Display user's payment settings
// Route::get('/settings/payment', function() {
// 	// Get payment settings for user
// 	$settings = API::get_payment_settings();
// 	// Return payment settings view
// 	return view('auth-views/payment-settings', ['settings' => $settings]);
// })->middleware('auth')->name('payment-settings');
//
//
// // Allow user to add a card
// Route::get('/settings/payment/cards/add', function() {
// 	// Get payment settings for user
// 	$settings = API::get_payment_settings();
// 	// Return view to add source for user
// 	return view('auth-views/payment-add_card', ['settings' => $settings]);
// })->middleware('auth')->name('payment-add_card');
//
//
// // Add card page - handle submitted data
// Route::post('/settings/payment/cards/add', function() {
// 	// Check if stripe token was created
// 	if (Request::has('stripeToken')) {
// 		// Get Stripe token from request
// 		$stripe_token = Request::get('stripeToken');
// 		// Get payment settings for user
// 		$settings = API::get_payment_settings();
// 		// Create card in customer profile
// 		$card = API::create_user_payment_source($stripe_token);
// 		// Check if card was added
// 		if ($card) {
// 			// Check if cookie exists
// 			if (Cookie::has('original_action')) {
// 				// Redirect user to original action and clear cookie
// 				return Redirect::to(Cookie::get('original_action'))->withCookie(Cookie::forget('original_action'))->with(['message' => 'card_added']);
// 			}
// 			// Redirect with success
// 			return Redirect::route('payment-settings')->with(['message' => 'card_added']);
// 		} else {
// 			// Redirect with error
// 			return Redirect::route('payment-settings')->with(['error' => $card]);
// 		}
// 	}
// 	return 'No token - Card wasn\'t valid and therefore was not added';
// })->middleware('auth')->name('payment-add_card');
//
//
//
//
// // List donations by user
// Route::get('/my-donations', function() {
// 	return 'List my donations';
// })->middleware('auth')->name('user-my_donations');
