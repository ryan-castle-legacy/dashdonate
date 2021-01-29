<?php


/*
 #	DashDonate_Users.php
 #
 #	This file contains the functionality specific to user accounts.
*/




// Include namespace
namespace App\Http\Controllers;


// Declare controllers
use Redirect;
use Request;
use Auth;
use Cookie;
use DB;




// Include controller for connecting to the API
use \App\Http\Controllers\DashDonate as API;




// Extend controller
class DashDonate_Users extends Controller {




	// Handle password resets
	public static function forgotPassword() {
		try {
			// Capture request data
			$data = Request::all();
			// Check if email is valid
			if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
				// Return error
				return Redirect::back()->withErrors(['email' => 'This email address is not valid.']);
			}
			// Perform API request
			$res = API::api_call('POST', '/donor/reset-password/', ['email' => $data['email']]);
			// Check response body is success
			if (@$res->status == 200) {
				// Decode data
				$data = json_decode($res->body);
				// Check if success
				if ($data->success == true) {
					// Return success
					return Redirect::back()->with(['success' => 'We have sent you an email to reset your password.']);
				} else {
					// Return error
					return Redirect::back()->withErrors(['email' => $data->error]);
				}
			}
			// Return error
			return Redirect::back()->withErrors(['email' => 'Something went wrong, please try again.']);
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




}
