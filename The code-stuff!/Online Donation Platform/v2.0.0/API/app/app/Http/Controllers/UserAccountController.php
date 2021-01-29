<?php

namespace App\Http\Controllers;

// Include the error logging controller (to aid finding and fixing bugs)
use \App\Http\Controllers\LogError;

use DB;
use Mail;
use Hash;


class UserAccountController extends Controller
{




	public static function createDashDonateUser($email_address) {
		try {
			// Get user profile
			$user = DB::table('users')->where(['email' => $email_address])->first();
			// Check if user was found
			if ($user) {
				// Return user record
				return $user;
			}
			// Create random password
			$generated_password = sha1(uniqid(sha1($email_address.'DashDonate').time()));
			// Create user
			$user = DB::table('users')->insertGetId([
				'name'					=> '',
				'email' 				=> $email_address,
				'password' 				=> Hash::make($generated_password),
				'user_role' 			=> 'donor',
				'is_email_confirmed'	=> true,
				'email_confirm_code'	=> null,
				'needs_password_reset'	=> true,
				'created_at' 			=> date('Y-m-d H:i:s', time()),
			]);
			// Get user record
			$user = DB::table('users')->where(['id' => $user])->first();
			// Send invite email to complete signup
			$send = UserAccountController::sendEmailWelcomeOffSession($user, $generated_password);
			// Return full user record
			return $user;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
		return false;
	}




	public static function sendEmailWelcomeOffSession($user, $generated_password) {
		try {
			// Email info
			$email = array(
				'subject'				=> 'Welcome to DashDonate.org',
				'recipient'				=> $user->email,
				'generated_password'	=> $generated_password,
				'positive_action'		=> env('FRONTEND_URL'),
			);
			// Send email
			$send = Mail::send('emails.user_welcome_offsession', ['email' => $email], function($m) use ($email) {
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
			);
			// Return error
			return $error;
		}
		return false;
	}





}
