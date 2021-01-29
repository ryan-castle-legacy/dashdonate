<?php




// Add controller for the API
use \App\Http\Controllers\DashDonate as API;




// Display data dumps for administrators of DashDonate
Route::get('/admin/data-dump/{type}', function($type) {

	// Holding array
	$data = array();

	// Get data
	switch ($type) {
		case 'users':
			$data = DB::table('users')->get();
		break;
		case 'cron':
			$data = DB::table('cron_tasks')->orderBy('date_to_process', 'ASC')->get();
		break;
		case 'donations':
			$data = DB::table('donations')->orderBy('id', 'DESC')->get();
		break;
		case 'charities':
			// Get data
			$data = DB::table('charities')->get();
		break;
		case 'invites':
			// Get data
			$data = DB::table('user_invites')->get();
		break;
		case 'representatives':
			// Get data
			$data = DB::table('charities_representative')->get();
		break;
		case 'widget-sessions':
			// Get data
			$data = DB::table('donation_sessions')->get();
		break;
	}

	// Output data
	echo '<pre>';
	var_dump($data);
	return;

})->middleware('auth', 'must_be_admin')->name('admin-data_dump');




// Page to approve or deny charities
Route::get('/admin/charity-approval', function(Request $request) {

	// Get data
	$data = DB::table('charities')->get();

	// Return view
	return view('admin/approve_charities', ['charities' => $data]);

})->middleware('auth', 'must_be_admin')->name('admin-charity_approval');




// Update charity as approved/disabled
Route::post('/admin/charity-approval/{charity_id}', function(Request $request, $charity_id) {

	// Get intent
	$intent = Request::get('intent');

	if ($intent == 'approve') {
		DB::table('charities')->where(['id' => $charity_id])->update(['needs_dashdonate_approval' => false]);
	} else {
		DB::table('charities')->where(['id' => $charity_id])->update(['needs_dashdonate_approval' => true]);
	}

	return Redirect::back();

})->middleware('auth', 'must_be_admin')->name('admin-charity_approval-submit');




// Page to approve or deny charities
Route::get('/admin/representatives-approval', function(Request $request) {

	// Get data
	$data = DB::table('charities_representative')->get();

	// Return view
	return view('admin/approve_representatives', ['representatives' => $data]);

})->middleware('auth', 'must_be_admin')->name('admin-representatives_approval');



// Update charity as approved/disabled
Route::post('/admin/representatives-approval/{representative_id}', function(Request $request, $representative_id) {

	// Correction
	// $x = DB::table('charities_representative')->where(['id' => 1])->update([
	// 	'dob' => date('Y-m-d H:i:s', strtotime('13-12-1962'))
	// ]);

	// // Correction
	// $x = DB::table('charities')->where(['id' => 1])->update([
	// 	'needs_representative_id' => false,
	// 	'representative_id_pending' => false
	// ]);
	//
	// return;

	// Get rep data
	$representative = DB::table('charities_representative')->where(['id' => $representative_id])->first();
	// Get charity
	$charity = DB::table('charities')->where(['id' => $representative->charity_id])->first();
	// Submit for review
	$submit = API::submitRepresentativeIdentificationStripe($charity->slug);

	// // Output data
	// echo '<pre>';
	// var_dump($submit);
	// // var_dump($x);
	// return;



	// if ($intent == 'approve') {
	// 	DB::table('charities')->where(['id' => $charity_id])->update(['needs_dashdonate_approval' => false]);
	// } else {
	// 	DB::table('charities')->where(['id' => $charity_id])->update(['needs_dashdonate_approval' => true]);
	// }

	return Redirect::back();

})->middleware('auth', 'must_be_admin')->name('admin-representatives_approval-submit');














// use \App\Http\Controllers\TaskRunner;
//
// Route::get('/cron', function(Request $request) {
//
// 	TaskRunner::processTasks();
//
// });
