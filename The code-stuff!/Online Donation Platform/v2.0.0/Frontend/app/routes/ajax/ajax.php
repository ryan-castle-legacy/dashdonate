<?php


use \App\Http\Controllers\DashDonate as API;



// // Refresh charity commission data
// Route::get('/ajax/refresh-commission-data/{charity_id}', function(Request $request, $charity_id) {
// 	try {
// 		// Refresh charity data from the charity commission
// 		$data = API::update_charity_data_from_commission($charity_id, Auth::user()->id);
// 		// Return response
// 		return json_encode($data);
// 	} catch (Exception $e) {
// 		return $e->getMessage();
// 	}
// })->middleware('auth', 'ajax');
//
//
//
//
// // Invite a user to be charity staff
// Route::post('/ajax/invite-staff', function(Request $request) {
// 	try {
// 		// Get data
// 		$data = Request::all();
// 		// Get charity_id
// 		$charity_id = $data['charity_id'];
// 		// Get email address
// 		$email = $data['email'];
// 		// Get if admin
// 		$is_admin = $data['admin'];
// 		// Invite user
// 		$invite = API::invite_to_charity($charity_id, $email, Auth::user()->id, $is_admin);
// 		// Return response
// 		return json_encode($invite);
// 	} catch (Exception $e) {
// 		return $e->getMessage();
// 	}
// })->middleware('auth', 'ajax');







// Send auth for a donation task
Route::post('/ajax/process-off-session-donation-authorise/', function(Request $request) {
	try {
		// Get data
		$data = Request::all();
		// Send request
		$auth = API::processOffSessionAuthorisationTask($data['task_token'], $data['pmToken'], $data['pmCardId'], Auth::user()->id, $data['setupIntent'], $data['paymentIntent']);
		// Return response
		return json_encode($auth);
	} catch (Exception $e) {
		return $e->getMessage();
	}
})->middleware('auth', 'ajax');
































// Delete a donation task
Route::post('/ajax/cancel-donation-task/', function(Request $request) {
	try {
		// Get data
		$data = Request::all();
		// Get task token
		$task_token = $data['task_token'];
		// Delete task
		$delete = API::deleteDonationTask($task_token, Auth::user()->id);
		// Return response
		return json_encode($delete);
	} catch (Exception $e) {
		return $e->getMessage();
	}
})->middleware('auth', 'ajax');




// Complete a donation task
Route::post('/ajax/complete-donation-task/', function(Request $request) {
	try {
		// Get data
		$data = Request::all();
		// Get task token
		$task_token = $data['task_token'];
		// Complete task
		$complete = API::completeDonationTask($task_token, Auth::user()->id);
		// Return response
		return json_encode($complete);
	} catch (Exception $e) {
		return $e->getMessage();
	}
})->middleware('auth', 'ajax');




// Fail a donation task
Route::post('/ajax/fail-donation-task/', function(Request $request) {
	try {
		// Get data
		$data = Request::all();
		// Get task token
		$task_token = $data['task_token'];
		// Complete task
		$complete = API::failDonationTask($task_token, Auth::user()->id);
		// Return response
		return json_encode($complete);
	} catch (Exception $e) {
		return $e->getMessage();
	}
})->middleware('auth', 'ajax');
