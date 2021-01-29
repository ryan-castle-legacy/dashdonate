<?php

namespace App\Http\Controllers;

// Include the error logging controller (to aid finding and fixing bugs)
use \App\Http\Controllers\LogError;
use \App\Mail\QueuedEmail;


use Illuminate\Http\Request;
use DB;
use Mail;
use Hash;

class NotificationController extends Controller
{




	// public static function testMailForQueue($subject, $template, $recipient) {
	// 	try {
	//
	// 		// Delay before sending (seconds)
	// 		$delay = now()->addMinutes(1);
	//
	// 		// Email info
	// 		$email = array(
	// 			'subject'			=> 'xxxxxxx',
	// 			'recipient'			=> 'ryan@dashdonate.org',
	// 		);
	//
	// 		// // Send email
	// 		// $send = Mail::later($delay, 'emails.'.$template, ['email' => $email], function($m) use ($email) {
	// 		// 	$m->from('noreply@dashdonate.org', 'DashDonate.org');
	// 		// 	$m->to($email['recipient'])->subject($email['subject']);
	// 		// });
	//
	//
	// 		$send = Mail::later($delay, new QueuedEmail($email), ['email' => $email], function($m) use ($email) {
	// 			$m->from('noreply@dashdonate.org', 'DashDonate.org');
	// 			$m->to($email['recipient'])->subject($email['subject']);
	// 		});
	//
	//
	// 		// Check for failures
	// 		if (Mail::failures()) {
	// 			// Return response to sending
	// 			return json_encode(false);
	// 		}
	// 		// Return response to sending
	// 		return json_encode($send);
	// 	} catch (Exception $e) {
	// 		// Create error info array
	// 		$error = array(
	// 			'message'	=> $e->getMessage(),
	// 			'line'		=> $e->getLine(),
	// 			'trace'		=> $e->getTrace(),
	// 		);
	// 		// Return error
	// 		return $error;
	// 	}
	// 	return false;
	// }




	public static function sendDonationAuthEmail($task_token) {
		try {
			// Get task
			$task = DB::table('donations_task_list')->where(['task_token' => $task_token])->first();
			// Get user for task
			$user = DB::table('users')->where(['id' => $task->user_id])->first();
			// Get charity for task
			$charity = DB::table('charities')->where(['id' => $task->charity_id])->first();
			// Email info
			$email = array(
				'subject'				=> 'Your Donation Needs Authorisation',
				'recipient'				=> $user->email,
				'task'					=> $task,
				'charity'				=> $charity,
				'positive_action'		=> env('FRONTEND_URL').'/donate/authorise/'.$task_token,
			);
			// Send email
			$send = Mail::send('emails.donation_authorise_request', ['email' => $email], function($m) use ($email) {
				$m->from('noreply@dashdonate.org', 'DashDonate.org');
				$m->to($email['recipient'])->subject($email['subject']);
			});
			// Check for failures
			if (Mail::failures()) {
				// Return response to sending
				return json_encode(false);
			}
			// Update task that auth has been sent
			DB::table('donations_task_list')->where(['task_token' => $task_token])->update(['auth_req_sent' => true]);
			// Return response to sending
			return json_encode(true);
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
				'trace'		=> $e->getTrace(),
			);
			// Return error
			return $error;
		}
		return false;
	}




	public static function newCharitySignup($charity_id) {
		try {
			// Get charity details
			$charity = DB::table('charities')->where(['id' => $charity_id])->first();
			$charity->details = DB::table('charities_details')->where(['charity_id' => $charity_id])->first();
			$charity->representative = DB::table('charities_representative')->where(['charity_id' => $charity_id])->first();
			// Email info
			$email = array(
				'subject'				=> 'New Charity Signup',
				'recipient'				=> 'charities@dashdonate.org',
				'details'				=> $charity,
			);
			// Send email
			$send = Mail::send('emails.charity_signup', ['email' => $email], function($m) use ($email) {
				$m->from('noreply@dashdonate.org', 'DashDonate.org');
				$m->to($email['recipient'])->subject($email['subject']);
			});
			// Check for failures
			if (Mail::failures()) {
				// Return response to sending
				return json_encode(false);
			}
			// Return response to sending
			return json_encode(true);
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
				'trace'		=> $e->getTrace(),
			);
			// Return error
			return $error;
		}
		return false;
	}




	public static function sendPasswordReset($email, $token) {
		try {
			// Get user
			$user = DB::table('users')->where(['email' => $email])->first();
			// Email info
			$email = array(
				'subject'				=> 'Password Reset',
				'recipient'				=> $email,
				'positive_action'		=> env('FRONTEND_URL').'/reset-password/'.$token,
			);
			// Send email
			$send = Mail::send('emails.password_reset', ['email' => $email], function($m) use ($email) {
				$m->from('noreply@dashdonate.org', 'DashDonate.org');
				$m->to($email['recipient'])->subject($email['subject']);
			});
			// Check for failures
			if (Mail::failures()) {
				// Return response to sending
				return json_encode(false);
			}
			// Return response to sending
			return json_encode(true);
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
				'trace'		=> $e->getTrace(),
			);
			// Return error
			return $error;
		}
		return false;
	}




	public static function passwordHasBeenChanged($email) {
		try {
			// Get user
			$user = DB::table('users')->where(['email' => $email])->first();
			// Email info
			$email = array(
				'subject'				=> 'Your Password Has Been Changed',
				'recipient'				=> $email,
				'positive_action'		=> env('FRONTEND_URL'),
			);
			// Send email
			$send = Mail::send('emails.password_changed', ['email' => $email], function($m) use ($email) {
				$m->from('noreply@dashdonate.org', 'DashDonate.org');
				$m->to($email['recipient'])->subject($email['subject']);
			});
			// Check for failures
			if (Mail::failures()) {
				// Return response to sending
				return json_encode(false);
			}
			// Return response to sending
			return json_encode(true);
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
				'trace'		=> $e->getTrace(),
			);
			// Return error
			return $error;
		}
		return false;
	}




}
