<?php


use \App\Http\Controllers\DashDonate as API;




// Dashboard for charities
Route::get('/dashboard/charities/{charity_id}', function($charity_id) {
	// Get charity
	$charity = API::get_charity_by_id($charity_id);

	// Check if charity form complete
	if (!@$charity->details) {
		return Redirect::route('charities-register_details', ['charity_id' => $charity_id]);
	}

	// Charity dashboard
	return view('charities/dashboard', ['charity' => $charity]);
})->middleware('auth', 'charitystaffonly:all')->name('charities-dashboard');




// Dashboard for charities
Route::get('/dashboard/charities/{charity_id}/donations', function($charity_id) {
	// Get charity
	$charity = API::get_charity_by_id($charity_id);
	// Charity dashboard
	return view('charities/dashboard-donations', ['charity' => $charity]);
})->middleware('auth', 'charitystaffonly:all')->name('charities-dashboard_donations');




// Dashboard for charities
Route::get('/dashboard/charities/{charity_id}/staff', function($charity_id) {
	// Get charity
	$charity = API::get_charity_by_id($charity_id);
	// Charity dashboard
	return view('charities/dashboard-staff', ['charity' => $charity]);
})->middleware('auth', 'charitystaffonly:administrator')->name('charities-dashboard_staff');
