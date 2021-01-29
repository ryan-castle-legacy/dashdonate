<?php


use \App\Http\Controllers\DashDonate as API;




// Invite processing destination - Validates and sets cookies to continue invite
Route::get('/invite/charity/{invite_token}', function(Request $request, $invite_token) {
	// Get invite
	$invite = API::get_invite($invite_token);
	// Check invite is valid
	if ($invite) {
		//	Check if invite has expired (more than 48 hours old)
		if (strtotime($invite->date_added) <  time() - (60*60*48)) {
			// Redirect to expired page
			return Redirect::route('charities-invite_staff_expired', ['invite_token' => $invite_token]);
		} else {
			// Check if user is logged in
			if (Auth::check()) {
				// Check if email is the same as logged in user
				if (Auth::user()->email == $invite->email_address) {
					// Send user to decision screen
					return Redirect::route('charities-invite_staff_request', ['invite_token' => $invite_token]);
				} else {
					// Send user to login
					return Redirect::route('charities-invite_staff_wrong_account', ['invite_token' => $invite_token])->withCookie(cookie('invite_token', $invite_token, 45000))->withCookie(cookie('original_action', route('charities-invite_staff', ['invite_token' => $invite_token]), 45000));
				}
			} else {
				// Check if there is a user to login
				if ($invite->user) {
					// Send user to login
					return Redirect::route('login')->withCookie(cookie('invite_token', $invite_token, 45000))->withCookie(cookie('original_action', route('charities-invite_staff', ['invite_token' => $invite_token]), 45000));
				} else {
					// Send user to register
					return Redirect::route('charities-invite_staff_register')->withCookie(cookie('invite_token', $invite_token, 45000))->withCookie(cookie('original_action', route('charities-invite_staff', ['invite_token' => $invite_token]), 45000));
				}
			}
		}
	}
	// Return to homepage
	return Redirect::route('home');
})->name('charities-invite_staff');




// Invite processing destination - Validates and sets cookies to continue invite
Route::get('/invite/charity/{invite_token}/request', function(Request $request, $invite_token) {
	// Get invite
	$invite = API::get_invite($invite_token);
	// Check invite is valid
	if ($invite) {
		//	Check if invite has expired (more than 48 hours old)
		if (strtotime($invite->date_added) < (time() - (60*60*48))) {
			// Redirect to expired page
			return Redirect::route('charities-invite_staff_expired', ['invite_token' => $invite_token]);
		} else {
			// Check if user is logged in to the correct account
			if (@Auth::check() && @Auth::user()->email == @$invite->email_address) {
				// Return decision screen
				return view('charities/invite-decision', ['invite' => $invite]);
			}
		}
	}
	// Return to processing of request
	return Redirect::route('charities-invite_staff', ['invite_token' => $invite_token]);
})->middleware('auth')->name('charities-invite_staff_request');




// Invite has expired
Route::get('/invite/charity/{invite_token}/expired', function(Request $request, $invite_token) {

	return 'Invite expired';

})->name('charities-invite_staff_expired');




// Invite needs to be accepted by different user
Route::get('/invite/charity/{invite_token}/unauthorised', function(Request $request, $invite_token) {

	return 'Need to to login with other account';

})->name('charities-invite_staff_wrong_account');




// User needs to create account
Route::get('/invite/charity/{invite_token}/register', function(Request $request, $invite_token) {

	return 'Needs to register';

})->name('charities-invite_staff_register');




// Submit response to the form
Route::post('/invite/charity/{invite_token}', function(Request $request, $invite_token) {
	// Get data
	$data = Request::all();
	// Check whether to accept or decline invite
	if ($data['response'] == 'accept') {
		// Send response
		$invite = API::accept_invite($invite_token, Auth::user()->id);
		// If true
		if (@$invite->result === true) {
			// Send user to dashboard
			return Redirect::route('charities-dashboard', ['charity_id' => $invite->invite->charity_id])->withCookie(Cookie::forget('invite_token'))->withCookie(Cookie::forget('original_action'));
		}
	} else {
		// Send response
		$invite = API::decline_invite($invite_token, Auth::user()->id);
	}
	// Send user home
	return Redirect::route('home');
})->middleware('auth')->name('charities-invite_staff_respond');
