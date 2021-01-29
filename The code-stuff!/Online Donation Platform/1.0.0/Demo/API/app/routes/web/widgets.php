<?php

use Illuminate\Http\Request;

// Include the Stripe controller
use \App\Http\Controllers\StripeController as DD_Stripe;
// Include the error logging controller (to aid finding and fixing bugs)
use \App\Http\Controllers\LogError;



Route::group(['middleware' => 'throttle:480,1'], function() {


	Route::post('/widget/donation', function(Request $request) {
		// Get data
		$data = $request->all();

		$intent = DD_Stripe::createDonationIntent($data['stripe_token'], 1000);

		return json_encode($intent);
		return json_encode('FROM_API');
	});

	Route::get('/widget/get-intent/{intent_id}', function($intent_id) {
		// Get intent
		$intent = DD_Stripe::get_intent($intent_id);
		// Respond with intent
		return json_encode($intent);
	});

});
