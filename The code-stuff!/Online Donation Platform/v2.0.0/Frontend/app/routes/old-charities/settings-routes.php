<?php


use \App\Http\Controllers\DashDonate as API;
use Illuminate\Http\Request;




// Settings for charity setup
Route::get('/dashboard/charities/{charity_id}/setup', function($charity_id) {

	// echo DB::table('charities')->truncate();
	// echo DB::table('charities_details')->truncate();
	// echo DB::table('charities_staff')->truncate();
	// echo DB::table('user_invites')->truncate();
	// echo DB::table('charities_representative')->truncate();
	// echo DB::table('charity_files')->truncate();
	// echo DB::table('donations')->truncate();
	// echo DB::table('users_payment_sources')->truncate();
	// return;

	// Get charity
	$charity = API::get_charity_by_id($charity_id);
	// Get trustees list from commission
	$trustee_list = API::get_trustees_data_from_commission($charity_id);
	// Check if commission has not yet been use to pre-fill information
	if ($charity->data_captured_from_commission == false) {
		// Get data from commission
		$captured = API::update_charity_data_from_commission($charity_id);
		// Check if captured successfully
		if ($captured) {
			// Refresh page
			return Redirect::refresh();
		}
	}
	// Charity setup page
	return view('charities/dashboard-setup', ['charity' => $charity, 'trustees' => $trustee_list]);
})->middleware('auth', 'charitystaffonly:administrator')->name('charities-dashboard_setup');




// Submit charity setup details form
Route::post('/dashboard/charities/{charity_id}/setup', function(Request $request, $charity_id) {

	// Get charity
	$charity = API::get_charity_by_id($charity_id);


	// Check if charity was found and that the user is an admin of the charity


	// Extract data from request
	$data = $request->all();
	// Add charity ID to the data object
	$data['charity_id'] = $charity_id;


	// validate data


	// Update charity record
	$update = API::update_charity_application($data, Auth::user()->id, $request->ip());
	// Check if update was successful
	if ($update) {
		// Update connected account
		$update = API::update_connected_charity($charity_id, Auth::user()->id);
		// See if the account object was returned
		if (@$update && @$update->requirements) {
			// Check if there are items in need of being confirmed
			if (@sizeof(@$update->requirements->currently_due) > 0 ||
				@sizeof(@$update->requirements->eventually_due) > 0 ||
				@sizeof(@$update->requirements->past_due) > 0
			) {

				if (in_array('relationship.representative', $update->requirements->currently_due)) {

					// Send user to the representative form
					return Redirect::back();

				}

				echo '<pre>';
				var_dump($update->requirements);
				return;

			} else {
				// Check if waiting for verification
				if (@sizeof(@$update->requirements->pending_verification) > 0) {

				} else {

				}
			}
// 			NULL
// ["currently_due"]=>
// array(3) {
//   [0]=>
//   string(16) "external_account"
//   [1]=>
//   string(21) "relationship.director"
//   [2]=>
//   string(27) "relationship.representative"
// }
// ["disabled_reason"]=>
// string(21) "requirements.past_due"
// ["errors"]=>
// array(0) {
// }
// ["eventually_due"]=>
// array(3) {
//   [0]=>
//   string(16) "external_account"
//   [1]=>
//   string(21) "relationship.director"
//   [2]=>
//   string(27) "relationship.representative"
// }
// ["past_due"]=>
// array(3) {
//   [0]=>
//   string(16) "external_account"
//   [1]=>
//   string(21) "relationship.director"
//   [2]=>
//   string(27) "relationship.representative"
// }
// ["pending_verification"]=>
// array(0) {
// }

			echo '<pre>';
			var_dump($update->requirements);
			return;

		}
	} else {
		// Error
		echo '<pre>';
		var_dump($update);
		echo '</pre><hr/>';
		return 'error';
	}





	echo '<pre>';
	var_dump($data);
	echo '</pre><hr/>';

	echo '<pre>';
	var_dump($update);
	echo '</pre><hr/>';

	echo '<pre>';
	var_dump($charity);
	return;


		// $return = API::update_connected_charity($charity->id, Auth::user()->id);
		// echo '<pre>';
		// var_dump($return);
		// return;

})->middleware('auth')->name('charities-dashboard_setup');






// Settings for charity representative setup
Route::post('/dashboard/charities/{charity_id}/representative', function(Request $request, $charity_id) {
	// Get data from request
	$data = $request->all();
	// Get charity
	$charity = API::get_charity_by_id($charity_id);
	// Check if charity exists
	if ($charity) {
		// Check if the charity has a representative record
		if (!$charity->representative) {
			// Create record
			DB::table('charities_representative')->insert([
				'charity_id'	=> $charity->id,
				'user_id'		=> Auth::user()->id,
			]);
			// Get updated charity data
			$charity = API::get_charity_by_id($charity_id);
		}

		if (@$data['representative_phone']) {
			$data['representative_phone'] = API::phone_to_international($data['representative_phone']);
		}

		// Update representative details
		$update = DB::table('charities_representative')->where(['charity_id' => $charity->id])->update([
			'user_id'					=> Auth::user()->id,
			'trustee_number'			=> @$data['trustee_id'],
			'legal_firstname'			=> @$data['representative_firstname'],
			'legal_lastname'			=> @$data['representative_lastname'],
			'date_of_birth'				=> @$data['representative_dob'],
			'phone_number'				=> @$data['representative_phone'],
			'email_address'				=> @$data['representative_email'],
			'address_line_1'			=> @$data['representative_address_line_1'],
			'address_line_2'			=> @$data['representative_address_line_2'],
			'address_town_city'			=> @$data['representative_address_town_city'],
			'address_postcode'			=> @$data['representative_address_postcode'],
		]);


		// See if user has completed all fields
		$representative = DB::table('charities_representative')->where(['charity_id' => $charity->id])->first();

		// Check variable
		$rep_filled = true;
		// Loop through representative
		foreach ($representative as $rep => $val) {
			// Check if empty
			if ($representative->{$rep} == false || $representative->{$rep} == null) {
				$rep_filled = false;
			}
		}
		// Check if representative is filled
		if ($rep_filled == true) {

			// Need to submit to Stripe
			$submit = API::submit_charity_representative($charity->id);

			echo '<pre>';
			var_dump($submit);
			return;

		}
	}
	// Send user back to form
	return Redirect::route('charities-dashboard_setup', ['charity_id' => $charity->id]);
})->middleware('auth')->name('charities-dashboard_representative');

















// Settings for charity representative setup
Route::post('/dashboard/charities/{charity_id}/bank_account', function(Request $request, $charity_id) {
	// Get data from request
	$data = $request->all();
	// Get charity
	$charity = API::get_charity_by_id($charity_id);
	// Check if charity exists
	if ($charity) {

	}
	// Send user back to form
	return Redirect::route('charities-dashboard_setup', ['charity_id' => $charity->id]);
})->middleware('auth')->name('charities-dashboard_bank_account');
