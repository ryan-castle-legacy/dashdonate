<?php


/*
 #	donate.php
 #
 #	This file contains routes relating to authorising donations
*/




// Include controller for onboarding
use \App\Http\Controllers\DashDonate as API;





/* OLD WIDGET CODE  */
/* OLD WIDGET CODE  */
/* OLD WIDGET CODE  */
/* OLD WIDGET CODE  */
/* OLD WIDGET CODE  */

// Authorise a donation
Route::get('/donate/authorise/{task_token}', function(Request $request, $task_token) {

	// Check if user is not logged in
	if (!Auth::check()) {
		// Send to login
		return Redirect::route('login')->withCookie(cookie('original_action', route('donation-authorise', ['task_token' => $task_token])));
	}

	// Get task
	$task = API::getTaskForUserAuth($task_token, Auth::user()->id);
	// Check if task was found
	if ($task && @$task->intent) {
		// Display 3Ds confirmation frame
		return view('public/donate/authorise', ['task' => $task, 'intent' => $task->intent]);
	}

	// Send to 404 page
	return Redirect::route('error-404');

})->name('donation-authorise');

/* OLD WIDGET CODE  */
/* OLD WIDGET CODE  */
/* OLD WIDGET CODE  */
/* OLD WIDGET CODE  */
/* OLD WIDGET CODE  */




Route::get('/donation/confirmation/{task_token}', function(Request $request, $task_token) {

	// Check if user is not logged in
	if (!Auth::check()) {
		// Send to login
		return Redirect::route('login')->withCookie(cookie('original_action', route('public-donate-donation_confirmation', ['task_token' => $task_token])));
	}

	// Get task
	$task = API::getOffSessionAuthorisationTask($task_token, Auth::user()->id);

	// Check if task exists/is valid
	if (@$task && gettype($task) == 'object') {
		// Set misc messages/socials
		$task->charity->widgetText = array(
			'thank_you_title'		=> 'Thank you for your support!',
			'thank_you_message'		=> 'It makes a huge difference to our cause.',
		);

		// Check if task was found
		if ($task && @$task->original && @$task->original->active == true) {
			// Display confirmation page
			return view('public/donate/confirmation', ['task' => $task]);
		}
	}

	// Send to 404 page
	return Redirect::route('error-404');

})->name('public-donate-donation_confirmation');
