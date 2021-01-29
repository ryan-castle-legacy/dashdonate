<?php

use \App\Http\Controllers\DashDonate as API;


// 
// // Add demo payment method
// Route::get('/error/404', function() {
// 	// Return message
// 	return 'Error 404 - Page not found';
// })->name('error-404');
//
//
//
//
//
//
// // Route for testing error logging
// Route::get('/error-logging-test', function() {
//
// 	$test = API::test_error_logging();
//
// 	// Would return "Our people are looking into this"
// 	// Or return "if this keeps happening, please get in touch."
// 	// (Depends on whether error logged on or not)
//
// 	echo '<pre>';
// 	var_dump($test);
// 	return;
// });
//
//
//
//
//
//
//
// // Route for testing error logging
// Route::get('/admin/error-log', function() {
// 	// Get error logs
// 	$logs = API::get_error_logs();
//
//
// 	// Check if any errors are logged
// 	if ($logs && @sizeof($logs) > 0) {
// 		// Loop through errors
// 		foreach ($logs as $log) {
// 			// Decode trace
// 			$trace = json_decode($log->error_trace);
// 			// Display error
// 			echo '<h3>Reported '.$log->error_count.' times.</h3>';
// 			echo '<p><small>First logged '.date('jS F Y \a\t g:ia', strtotime($log->created_at)).'</small></p>';
// 			echo '<p><small>Last logged '.date('jS F Y \a\t g:ia', strtotime($log->updated_at)).'</small></p>';
// 			echo '<p><small>Error is on line '.$log->line_number.' - '.$trace[0]->file.'</small></p>';
// 			echo '<p>Error Message: '.$log->error_message.'</p>';
// 			// Resolve button
// 			echo '<form method="POST" action="'.route('admin-resolve_error').'">';
// 			echo '<input type="hidden" name="_token" value="'.csrf_token().'"/>';
// 			echo '<input type="hidden" name="log_id" value="'.$log->id.'"/>';
// 			echo '<button type="submit">Mark as resolved</button>';
// 			echo '</form>';
// 			// // Trace
// 			// echo '<p>Error Trace:</p>';
// 			// echo '<pre>';
// 			// var_dump($trace);
// 			// echo '</pre>';
// 			echo '<hr/>';
// 		}
// 	} else {
// 		return 'No errors logged';
// 	}
// })->middleware('must_be_admin', 'auth')->name('admin-error_log');
//
//
// // Mark an error as resolved
// Route::post('/admin/error-log/resolve', function() {
// 	// Get post data
// 	$data = Request::all();
// 	// Resolve error
// 	API::resolve_error($data['log_id']);
// 	// Return back to logs
// 	return Redirect::route('admin-error_log');
// })->middleware('must_be_admin', 'auth')->name('admin-resolve_error');
