<?php

use Illuminate\Http\Request;
use Carbon\Carbon;


// Include the Stripe controller
use \App\Http\Controllers\StripeController as DD_Stripe;
// Include the donation controller
use \App\Http\Controllers\DonationController as Donation;
// Include the notification controller
use \App\Http\Controllers\NotificationController as Notify;
// Include the Charity Commissions API controllers
use \App\Http\Controllers\CharityRegister;
// Include the error logging controller (to aid finding and fixing bugs)
use \App\Http\Controllers\LogError;




// Include routes for widgets
require_once 'widgets/widgets.php';




Route::group(['middleware' => 'throttle:2400,1'], function() {



	Route::get('/xx', function(Request $request) {
		try {

			$data = CharityRegister::searchForCharities_englandWales();


			return json_encode($data);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	// Route::post('/queue/add-email', function(Request $request) {
	// 	try {
	//
	// 		$send = Notify::testMailForQueue('Test Email', 'welcome', 'ryan@dashdonate.org');
	//
	// 		return json_encode('Sending in a few');
	//
	// 	} catch (Exception $e) {
	// 		return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
	// 	}
	// 	return json_encode(false);
	// })->middleware('api_auth');




	Route::get('/calculate-donation-fees/{amount}', function(Request $request, $amount) {
		try {
			// Turn pounds into pence
			$amount = intval($amount * 100);
			// Calculate fee
			$fee_amounts = DD_Stripe::calculateFees($amount);
			// Return amount
			return json_encode($fee_amounts);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::get('/user/billing-settings/{user_id}', function(Request $request, $user_id) {
		try {
			// Get user
			$user = DB::table('users')->where(['id' => $user_id])->first();
			// Check if user was found
			if ($user) {


				// Get user's sources
				$user->sources = DB::table('users_payment_sources')->where(['user_id' => $user_id])->get();



				// Return data
				return json_encode($user);
			}
			// Return false
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/user/update-account-details/', function(Request $request) {
		try {
			// Get user ID from request
			$user_id = $request->get('user_id');
			// Get user data from request
			$user_data = $request->get('data');
			// Update user's details
			$update = DB::table('users')->where(['id' => $user_id])->update([
				'name'			=> $user_data['firstname'].' '.$user_data['lastname'],
				'firstname'		=> $user_data['firstname'],
				'lastname'		=> $user_data['lastname'],
				'updated_at'	=> date('Y-m-d H:i:s'),
			]);
			// Check if successfully updated
			if ($update) {
				// Return success
				return json_encode(true);
			}
			// Return error
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/donor/fail-donation-task/', function(Request $request) {
		try {
			// Get token from request
			$token = $request->get('task_token');
			// Get user ID from request
			$user_id = $request->get('user_id');
			// Get task
			$task = DB::table('donations_task_list')->where([
				'task_token'	=> $token,
				'user_id'		=> $user_id,
			])->first();
			// Check if task exists
			if ($task) {
				// Get user
				$user = DB::table('users')->where(['id' => $user_id])->first();
				// Get charity
				$charity = DB::table('charities')->where(['id' => $task->charity_id])->first();
				// Complete task
				DB::table('donations_task_list')->where(['id' => $task->id])->update([
					'active' 			=> false,
					'processing' 		=> false,
					'date_processed'	=> date('Y-m-d H:i:s', time()),
					'date_updated'		=> date('Y-m-d H:i:s', time()),
				]);
				// Return success
				return json_encode(true);
			}
			// Return that task didn't exist
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/donor/complete-donation-task/', function(Request $request) {
		try {
			// Get token from request
			$token = $request->get('task_token');
			// Get user ID from request
			$user_id = $request->get('user_id');
			// Get task
			$task = DB::table('donations_task_list')->where([
				'task_token'	=> $token,
				'user_id'		=> $user_id,
			])->first();
			// Check if task exists
			if ($task) {
				// Get user
				$user = DB::table('users')->where(['id' => $user_id])->first();
				// Get charity
				$charity = DB::table('charities')->where(['id' => $task->charity_id])->first();
				// Complete task
				DB::table('donations_task_list')->where(['id' => $task->id])->update([
					'active' 			=> false,
					'processing' 		=> false,
					'date_processed'	=> date('Y-m-d H:i:s', time()),
					'date_updated'		=> date('Y-m-d H:i:s', time()),
				]);
				// Send receipt email
				Donation::sendDonationReceipt($user->email, $task, $charity);
				// Check if recurring
				if ($task->recurring == true) {
					// Set next task
					setNextTask($request->get('task_token'));
				}
				// Return success
				return json_encode(true);
			}
			// Return that task didn't exist
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::get('/donation/get-donation-task-for-auth/{task_token}/{user_id}', function(Request $request, $task_token, $user_id) {
		try {
			// Get task
			$task = DB::table('donations_task_list')->where([
				'task_token'	=> $task_token,
				'user_id'		=> $user_id,
				'active'		=> true,
			])->first();
			// Check if task exists
			if ($task) {
				// Get user
				$user = DB::table('users')->where(['id' => $user_id])->first();
				// Get connected charity data
				$task->charity = DB::table('charities')->where(['id' => $task->charity_id])->first();
				// Create intent that needs authorised
				$task->intent = Donation::processAuthOfOffSessionDonation($user, $task, $task->charity);
				// Return task data
				return json_encode($task);
			}
			// Return that task didn't exist
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::get('/donation/get-donation-task/{task_token}/{user_id}', function(Request $request, $task_token, $user_id) {
		try {
			// Get task
			$task = DB::table('donations_task_list')->where([
				'task_token'	=> $task_token,
				'user_id'		=> $user_id,
			])->first();
			// Check if task exists
			if ($task) {
				// Return task data
				return json_encode($task);
			}
			// Return that task didn't exist
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/donation/send-authentication-for-donation-task/', function(Request $request) {
		try {
			// Get token from request
			$task_token = $request->get('task_token');
			// Get task
			$task = DB::table('donations_task_list')->where([
				'task_token'	=> $task_token,
			]);
			// Check if task exists
			if ($task) {
				// Send notification
				$send = Notify::sendDonationAuthEmail($task_token);
				// Return success
				return json_encode($send);
			}
			// Return that task didn't exist
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/donor/delete-donation-task/', function(Request $request) {
		try {
			// Get token from request
			$token = $request->get('task_token');
			// Get user ID from request
			$user_id = $request->get('user_id');
			// Get task
			// $task = DB::table('donations_task_list')->where([
			// 	'task_token'	=> $token,
			// 	'user_id'		=> $user_id,
			// ])->get();
			$task = DB::table('cron_tasks')->where([
				'task_group_token'	=> $token,
				'user_id'			=> $user_id,
			])->get();
			// Check if task exists
			if ($task) {
				// Disable task
				// DB::table('donations_task_list')->where([
				// 	'task_token'	=> $token,
				// 	'user_id'		=> $user_id,
				// ])->update(['active' => false]);
				$task = DB::table('cron_tasks')->where([
					'task_group_token'	=> $token,
					'user_id'			=> $user_id,
				])->update(['active' => false]);
				// Return success
				return json_encode(true);
			}
			// Return that task didn't exist
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::get('/donor/reset-password/{token}', function(Request $request, $token) {
		try {
			// Get reset record
			$reset = DB::table('password_resets')->where(['token' => $token])->first();
			// Check if reset token is valid
			if ($reset) {
				// Return success
				return json_encode(true);
			}
			// Return that reset doesn't exist
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::put('/donor/reset-password/', function(Request $request) {
		try {
			// Get token from request
			$token = $request->get('token');
			// Get new password from request
			$password = $request->get('password');
			// Get reset record
			$reset = DB::table('password_resets')->where(['token' => $token])->first();
			// Check if reset token is valid
			if ($reset) {
				// Set password
				DB::table('users')->where(['email' => $reset->email])->update(['password' => $password]);
				// Clear all now-invalid password resets
				DB::table('password_resets')->where(['email' => $reset->email])->delete();
				// Nofify user that their password has been changed
				Notify::passwordHasBeenChanged($reset->email);
				// Return success in the form of the user's email
				return json_encode($reset->email);
			}
			// Return that reset doesn't exist
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::put('/donor/set-password/', function(Request $request) {
		try {
			// Get user ID from request
			$user_id = $request->get('user_id');
			// Get new password from request
			$password = $request->get('password');
			// Get user
			$user = DB::table('users')->where(['id' => $user_id, 'needs_password_reset' => true])->first();
			// Check if user is valid for reset
			if ($user) {
				// Set password
				DB::table('users')->where(['id' => $user->id])->update(['password' => $password, 'needs_password_reset' => false]);
				// Nofify user that their password has been changed
				Notify::passwordHasBeenChanged($user->email);
				// Return success in the form of the user's email
				return json_encode(true);
			}
			// Return that reset doesn't exist
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/donor/reset-password/', function(Request $request) {
		try {
			// Get email address of user
			$email = $request->get('email');
			// Get user account with this email
			$user = DB::table('users')->where(['email' => $email])->first();
			// Check if user user exists
			if ($user) {
				// Create reset token
				$token = sha1($email.sha1(time().rand()).'DashDonate.org');
				// Insert reset token to database
				DB::table('password_resets')->insert([
					'email'			=> $email,
					'token'			=> $token,
					'created_at'	=> date('Y-m-d H:i:s', time()),
				]);
				// Send email to user
				Notify::sendPasswordReset($email, $token);
				// Return success
				return json_encode(['success' => true]);
			} else {
				// Return error
				return json_encode(['success' => false, 'error' => 'This email address is not registered with us.']);
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::get('/donor/dashboard/{user_id}', function($user_id) {
		try {
			// Holding object for data
			$data = new stdClass();
			// Get user data
			$user = DB::table('users')->where(['id' => $user_id])->first();
			// Check if user was found
			if ($user) {
				// Get donations data for the user
				$data->donations = DB::table('donations')->where([
					'donor_id'	=> $user->id,
				])->orderBy('date_taken', 'DESC')->limit(3)->get();
				// Loop through donations to get charity data
				for ($i = 0; $i < sizeof($data->donations); $i++) {
					// Get charity details for the donation
					$data->donations[$i]->charity_slug = DB::table('charities')->select(['slug'])->where(['id' => $data->donations[$i]->charity_id])->first();
					// Extract slug from data
					$data->donations[$i]->charity_slug = $data->donations[$i]->charity_slug->slug;
					// Get charity details for the donation
					$data->donations[$i]->charity = DB::table('charities_details')->where(['charity_id' => $data->donations[$i]->charity_id])->first();
					// Placeholder value
					$data->donations[$i]->charity->logo = null;
					// Check if charity data was found
					if ($data->donations[$i]->charity) {
						// Get charity logo
						$data->donations[$i]->charity->logo = DB::table('file_uploads')->where(['id' => $data->donations[$i]->charity->logo_file_id])->first();
					}
				}
			}
			// Return data
			return json_encode($data);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::get('/donor/all-donations/{user_id}', function($user_id) {
		try {
			// Holding object for data
			$data = new stdClass();
			// Get user data
			$user = DB::table('users')->where(['id' => $user_id])->first();
			// Check if user was found
			if ($user) {
				// Get donations data for the user
				$data->donations = DB::table('donations')->where([
					'donor_id'	=> $user->id,
				])->orderBy('date_taken', 'DESC')->get();

				// Get data for past donations
				$data->donations = getDonationDetailsForFetching($data->donations);


				// // Get scheduled donations for this user
				// $data->scheduled_donations = DB::table('donations_task_list')->where([
				// 	'user_id'		=> $user->id,
				// 	'recurring'		=> false,
				// 	'active'		=> true,
				// ])->orderBy('date_to_process', 'ASC')->get();

				// Get scheduled donations for this user
				$data->scheduled_donations = DB::table('cron_tasks')->where([
					'user_id'				=> $user->id,
					'task_type'				=> 'scheduled_donation',
					'active'				=> true,
				])->groupBy('task_group_token')->orderBy('date_to_process', 'ASC')->get();

				// Get data for scheduled donations
				$data->scheduled_donations = getDonationDetailsForFetching($data->scheduled_donations);


				// // Get repeat donations for this user
				// $data->repeat_donations = DB::table('donations_task_list')->where([
				// 	'user_id'		=> $user->id,
				// 	'recurring'		=> true,
				// 	'active'		=> true,
				// ])->orderBy('date_to_process', 'ASC')->get();

				// Get repeat donations for this user
				$data->repeat_donations = DB::table('cron_tasks')->where([
					'user_id'		=> $user->id,
					'task_type'		=> 'repeating_donation',
					'active'		=> true,
				])->groupBy('task_group_token')->orderBy('date_to_process', 'ASC')->get();

				// Get data for repeat donations
				$data->repeat_donations = getDonationDetailsForFetching($data->repeat_donations);
			}
			// Return data
			return json_encode($data);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	// Capture details about donations and the charity connected with it
	function getDonationDetailsForFetching($donations, $charity_data = true) {
		// Loop through donations to get charity data
		for ($i = 0; $i < sizeof($donations); $i++) {
			if ($charity_data) {
				// Get charity details for the donation
				$donations[$i]->charity_slug = DB::table('charities')->select(['slug'])->where(['id' => $donations[$i]->charity_id])->first();
				// Extract slug from data
				$donations[$i]->charity_slug = $donations[$i]->charity_slug->slug;
				// Get charity details for the donation
				$donations[$i]->charity = DB::table('charities_details')->where(['charity_id' => $donations[$i]->charity_id])->first();
				// Placeholder value
				$donations[$i]->charity->logo = null;
				// Check if charity data was found
				if ($donations[$i]->charity) {
					// Get charity logo
					$donations[$i]->charity->logo = DB::table('file_uploads')->where(['id' => $donations[$i]->charity->logo_file_id])->first();
				}
			}
			// Check if meta
			if (@$donations[$i]->meta) {
				// Check how many items are in the task group
				$donations[$i]->task_count = DB::table('cron_tasks')->where(['task_group_token' => $donations[$i]->task_group_token])->count();
				// Parse meta
				$donations[$i]->meta = json_decode($donations[$i]->meta);
				// Get amount and convert to pence
				$amount = intval(floatval($donations[$i]->meta->scheduledAmount) * 100);
				// Check if fees are added on top of donation
				if ($donations[$i]->meta->scheduledPayFees === true) {
					// Get fees object for this donation
					$fees = DD_Stripe::calculateFeesData($amount, 'normal');
				} else {
					// Get fees object for this donation
					$fees = DD_Stripe::calculateFeesData($amount, 'none');
				}
				// Calculate amount
				$donations[$i]->amount = $fees['totalCharge'];
				// Calculate total for charity
				$donations[$i]->total_to_charity = $fees['totalToCharity'];
			} else {
				// Calculate total for charity
				$donations[$i]->total_to_charity = 0;
			}
		}
		// Return data
		return $donations;
	}




	Route::post('/widget/donation/submit-next', function(Request $request) {
		try {
			// Get data
			$data = $request->get('data');



			$is_verified_charity_site = true;



			// Anti double-send var
			$receipt_sent = false;
			// Get data about the charity being donated to
			$charity = DB::table('charities')->where(['api_site_id' => $data['site_id']])->first();
			// Check if the request is not coming from a verified site for the charity
			if (!$is_verified_charity_site) {
				// Return error
				return json_encode(['success' => false, 'error' => 'unauthorised_donation_site']);
			}
			// Fetch DashDonate user's stripe info with this email (One will be created if no user exists)
			$stripe_user = DD_Stripe::getDonorStripeCustomer($data['email_address']);
			// Check if the customer record failed to be created
			if (!$stripe_user) {
				// Return error
				return json_encode(['success' => false, 'error' => 'failed_to_create_stripe_customer']);
			}
			// Get DashDonate user
			$user = DB::table('users')->where(['email' => $data['email_address']])->first();


			// Check whether SetupIntent is now needed (isn't needed if only one-off payment)
			if ($data['pay_now'] == true && $data['scheduled'] == false && $data['repeat'] == false) {
				// Get card
				$card = DD_Stripe::addCardForPayNow($stripe_user, $data['stripe_token']);
				// Get card ID from intent
				$card_id = $card->id;
			} else {
				// Get card
				$card = DD_Stripe::getStripeCard($data['setup_intent']);
				// Get card ID from intent
				$card_id = $card->payment_method;
			}


			// Check if whether there is an amount to take today
			if ($data['pay_now'] == true) {
				// Convert pounds to pence
				$amount = intval(floatval($data['amount_pounds_now']) * 100);
				// Check if fees are to be added now
				if ($data['pay_fees_now']) {
					// Add fees to amount
					$amount += intval(DD_Stripe::calculateFees($amount));
				}
				// Process donation for now
				$donation = Donation::createDonation($stripe_user->id, $data['payment_intent'], $card_id, $charity->id, $user->id, $amount, intval(DD_Stripe::calculateFees($amount)), $data['pay_fees_now'], $user->email, $user->id);
			} else {
				// Set default
				$donation = false;
			}


			// Check if no donation intent action is needed (prevents creating tasks if payment intent fails)
			if ($donation == false || $donation->status == 'succeeded') {

				// Check if whether there is an amount to schedule for another time
				if ($data['scheduled'] == true) {
					// Convert pounds to pence
					$amount_scheduled = intval(floatval($data['amount_pounds_scheduled']) * 100);
					// Check if fees are to be added now
					if ($data['pay_fees_scheduled']) {
						// Add fees to amount
						$amount_scheduled += intval(DD_Stripe::calculateFees($amount_scheduled));
					}
					// Create task in schedule
					$task = Donation::createScheduledDonation($stripe_user->id, $data['scheduled_date'], $charity->id, $user->id, $amount_scheduled, $data['pay_fees_scheduled'], $data['futureNotifications']);
				}


				// Check if whether there is an amount to set as repeating
				if ($data['repeat'] == true) {
					// Convert pounds to pence
					$amount_repeating = intval(floatval($data['amount_pounds_repeat']) * 100);
					// Check if fees are to be added now
					if ($data['pay_fees_repeat']) {
						// Add fees to amount
						$amount_repeating += intval(DD_Stripe::calculateFees($amount_repeating));
					}
					// Create repeating task
					$task = Donation::createRepeatDonation($stripe_user->id, $charity->id, $user->id, $amount_repeating, $data['pay_fees_scheduled'], $data['futureNotifications'], $data['repeat_interval'], $data['repeat_duration'], $data['repeat_anchor']);
				}

			}


			// Check if success and no setup intent is needed
			if ($donation === false && $receipt_sent == false) {
				// Send receipt email
				Donation::sendDonationReceipt($user->email, $data, $charity);
				// Mark as sent
				$receipt_sent = true;
			}


			// Return the intent
			return json_encode(['success' => true, 'intent' => $donation]);














			// // Check if whether there is an amount to schedule for another time
			// if ($data['scheduled'] == true) {
			// 	// Convert pounds to pence
			// 	$amount_scheduled = intval(floatval($data['amount_pounds_scheduled']) * 100);
			// 	// Check if fees are to be added now
			// 	if ($data['pay_fees_scheduled']) {
			// 		// Add fees to amount
			// 		$amount_scheduled += intval(DD_Stripe::calculateFees($amount_scheduled));
			// 	}
			// 	// Create task in schedule
			// 	$task = Donation::createScheduledDonation($stripe_user->id, $data['scheduled_date'], $charity->id, $user->id, $amount_scheduled, $data['pay_fees_scheduled'], $data['futureNotifications']);
			// }
			//
			//
			// // Check if whether there is an amount to set as repeating
			// if ($data['repeat'] == true) {
			// 	// Convert pounds to pence
			// 	$amount_repeating = intval(floatval($data['amount_pounds_repeat']) * 100);
			// 	// Check if fees are to be added now
			// 	if ($data['pay_fees_repeat']) {
			// 		// Add fees to amount
			// 		$amount_repeating += intval(DD_Stripe::calculateFees($amount_repeating));
			// 	}
			// 	// Create repeating task
			// 	$task = Donation::createRepeatDonation($stripe_user->id, $charity->id, $user->id, $amount_repeating, $data['pay_fees_scheduled'], $data['futureNotifications'], $data['repeat_interval'], $data['repeat_duration'], $data['repeat_anchor']);
			// }
			//
			//
			// // Return the intent
			// return json_encode(['success' => true]);
		} catch (Exception $e) {
			return json_encode('Line '.$e->getLine().' - Error: '.$e->getMessage());
		}
	})->middleware('api_auth');




	Route::post('/widget/donation/set-tasks', function(Request $request) {
		try {
			// Get data
			$data = $request->get('data');



			$is_verified_charity_site = true;



			// Anti double-send var
			$receipt_sent = false;
			// Get data about the charity being donated to
			$charity = DB::table('charities')->where(['api_site_id' => $data['site_id']])->first();
			// Check if the request is not coming from a verified site for the charity
			if (!$is_verified_charity_site) {
				// Return error
				return json_encode(['success' => false, 'error' => 'unauthorised_donation_site']);
			}
			// Fetch DashDonate user's stripe info with this email (One will be created if no user exists)
			$stripe_user = DD_Stripe::getDonorStripeCustomer($data['email_address']);
			// Check if the customer record failed to be created
			if (!$stripe_user) {
				// Return error
				return json_encode(['success' => false, 'error' => 'failed_to_create_stripe_customer']);
			}
			// Get DashDonate user
			$user = DB::table('users')->where(['email' => $data['email_address']])->first();


			// Check if whether there is an amount to schedule for another time
			if ($data['scheduled'] == true) {
				// Convert pounds to pence
				$amount_scheduled = intval(floatval($data['amount_pounds_scheduled']) * 100);
				// Check if fees are to be added now
				if ($data['pay_fees_scheduled']) {
					// Add fees to amount
					$amount_scheduled += intval(DD_Stripe::calculateFees($amount_scheduled));
				}
				// Create task in schedule
				$task = Donation::createScheduledDonation($stripe_user->id, $data['scheduled_date'], $charity->id, $user->id, $amount_scheduled, $data['pay_fees_scheduled'], $data['futureNotifications']);
			}


			// Check if whether there is an amount to set as repeating
			if ($data['repeat'] == true) {
				// Convert pounds to pence
				$amount_repeating = intval(floatval($data['amount_pounds_repeat']) * 100);
				// Check if fees are to be added now
				if ($data['pay_fees_repeat']) {
					// Add fees to amount
					$amount_repeating += intval(DD_Stripe::calculateFees($amount_repeating));
				}
				// Create repeating task
				$task = Donation::createRepeatDonation($stripe_user->id, $charity->id, $user->id, $amount_repeating, $data['pay_fees_scheduled'], $data['futureNotifications'], $data['repeat_interval'], $data['repeat_duration'], $data['repeat_anchor']);
			}


			// Check if success and no setup intent is needed
			if ($receipt_sent == false) {
				// Send receipt email
				Donation::sendDonationReceipt($user->email, $data, $charity);
				// Mark as sent
				$receipt_sent = true;
			}


			// Return the intent
			return json_encode(['success' => true]);
		} catch (Exception $e) {
			return json_encode('Line '.$e->getLine().' - Error: '.$e->getMessage());
		}
	})->middleware('api_auth');




	Route::get('check-charity-registration-number/{crn?}', function($crn = '') {
		try {
			// Check if CRN value is not null
			if (strlen(trim($crn)) == 0) {
				return json_encode('A charity registration number is required.');
			}
			// Get the charity that uses the CRN
			$charity = DB::table('charities')->where(['charity_registration_number' => strtolower($crn), 'verified' => true])->first();
			// Check if CRN is used in an existing charity
			if ($charity) {
				// Return that it is in use
				return json_encode(true);
			}
			// Holding variable
			$crn_is_valid = false;
			// Check with england and wales register
			$eng_wales = CharityRegister::searchForCharity_englandWales($crn);
			// Check if valid
			if (!empty($eng_wales)) {
				// CRN is valid with England and Wales register
				$crn_is_valid = true;
			}
			// Check to see if CRN is a valid registered CRN
			if ($crn_is_valid) {
				return json_encode(false);
			} else {
				return json_encode('invalid_crn');
			}
		} catch (Exception $e) {
			return json_encode($e->getMessage());
		}
		return json_encode(false);
	})->middleware('ajax_auth');




	Route::post('check-website-responding', function(Request $request) {
		try {
			// Get url
			$url = $request->get('url');
			// Check if url value is not null
			if (strlen(trim($url)) == 0) {
				return json_encode('A web address is required.');
			}
			// Check that url has a https:// at the start
			$parsed = parse_url($url);
			if (empty($parsed['scheme'])) {
				$url = 'https://' . ltrim($url, '/');
			}
			// Use curl to test for response
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_NOBODY, true);
			// Get curl response
			$curl_result = curl_exec($curl);
			// Check response
			if ($curl_result !== false) {
				// Get status code
				$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
				// Check status code
				if ($status != 404) {
					// Return that website responds and therefore exists
					return json_encode('exists');
				}
			}
			// Return that website didn't respond and therefore doesn't exist
			return json_encode(false);
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return json_encode(false);
	})->middleware('ajax_auth');




	Route::get('check-email-in-use/{email?}', function($email = '') {
		try {
			// Check if email value is not null
			if (strlen(trim($email)) == 0) {
				return json_encode('An email address is required.');
			}
			// Get the user that uses the email
			$user = DB::table('users')->where(['email' => strtolower($email)])->first();
			// Check if email is used in an existing user
			if ($user) {
				// Return that it is in use
				return json_encode(true);
			} else {
				// Return that it is in use
				return json_encode(false);
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return json_encode(false);
	})->middleware('ajax_auth');




	Route::post('charity/application/create', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Check if the charity is already registered with DashDonate
			$exists = DB::table('charities')->where(['charity_registration_number' => strtolower($data['crn']), 'verified' => true])->first();
			// Check if charity already exists
			if ($exists) {
				return json_encode('already_registered');
			}
			// Add new charity to the register
			$added = DB::table('charities')->insertGetId([
				'name'							=> $data['name'],
				'slug'							=> '',
				'owner_id'						=> $data['owner_id'],
				'charity_registration_number'	=> $data['crn'],
				'payout_reference_id'			=> '',
			]);
			// Set charity staff record for user
			$owner = DB::table('charities_staff')->insertGetId([
				'request_approved'		=> true,
				'charity_id'			=> $added,
				'user_id'				=> $data['owner_id'],
				'role'					=> 'administrator',
				'is_owner'				=> true,
				'is_representative'		=> false,
			]);
			// Check added
			if ($added) {
				// Return new record ID
				return json_encode($added);
			}
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




	Route::get('charity/application/get/{charity_id}/{owner_id}', function(Request $request, $charity_id, $owner_id) {
		try {
			// Check if the charity is already registered with DashDonate
			$application = DB::table('charities')->where(['id' => $charity_id, 'owner_id' => $owner_id])->first();
			// Check if application was found
			if ($application) {
				return json_encode($application);
			} else {
				return json_encode(false);
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




	Route::get('charity/update-from-commission/{charity_id}', function(Request $request, $charity_id) {
		try {
			// Check if the charity is already registered with DashDonate
			$application = DB::table('charities')->where(['id' => $charity_id])->first();
			// Check if application was found
			if ($application) {
				// Check if the charity's commission needs to be found
				if ($application->commission_name == false) {
					// Find commission
					$application->commission_name = CharityRegister::findRegister($application->charity_registration_number);
					// Update commission name record
					DB::table('charities')->where(['id' => $application->id])->update(['commission_name' => $application->commission_name]);
				}
				// Get commission data
				$commission_data = CharityRegister::{'getCharityInfo_'.$application->commission_name}($application->charity_registration_number);
				// Add data from the commission to charity record
				DB::table('charities')->where(['id' => $application->id])->update([
					'data_captured_from_commission' 	=> true,
					'companies_house_number' 			=> $commission_data['companies_house_number'],
				]);
				// Add data from the commission to charity details record
				DB::table('charities_details')->where(['charity_id' => $application->id])->update([
					'address_line_1' 			=> $commission_data['address_line_1'],
					'address_line_2' 			=> $commission_data['address_line_2'],
					'address_town_city' 		=> $commission_data['address_town_city'],
					'address_postcode' 			=> $commission_data['address_postcode'],
					'description_of_charity' 	=> $commission_data['description_of_charity'],
				]);
				// Return true as updated successfully
				return json_encode(true);
			} else {
				return json_encode(false);
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




	Route::get('charity/get-from-commission/{charity_id}', function(Request $request, $charity_id) {
		try {
			// Check if the charity is already registered with DashDonate
			$application = DB::table('charities')->where(['id' => $charity_id])->first();
			// Check if application was found
			if ($application) {
				// Check if the charity's commission needs to be found
				if ($application->commission_name == false) {
					// Find commission
					$application->commission_name = CharityRegister::findRegister($application->charity_registration_number);
					// Update commission name record
					DB::table('charities')->where(['id' => $application->id])->update(['commission_name' => $application->commission_name]);
				}
				// Get commission data
				$commission_data = CharityRegister::{'getCharityInfo_'.$application->commission_name}($application->charity_registration_number);
				// Return data
				return json_encode($commission_data);
			} else {
				return json_encode(false);
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




	Route::get('charity/trustees/get-from-commission/{charity_id}', function(Request $request, $charity_id) {
		try {
			// Check if the charity is already registered with DashDonate
			$application = DB::table('charities')->where(['id' => $charity_id])->first();
			// Check if application was found
			if ($application) {
				// Check if the charity's commission needs to be found
				if ($application->commission_name == false) {
					// Find commission
					$application->commission_name = CharityRegister::findRegister($application->charity_registration_number);
					// Update commission name record
					DB::table('charities')->where(['id' => $application->id])->update(['commission_name' => $application->commission_name]);
				}
				// Get commission data
				$commission_data = CharityRegister::{'getTrusteesInfo_'.$application->commission_name}($application->charity_registration_number);
				// Return data
				return json_encode($commission_data);
			} else {
				return json_encode(false);
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




	Route::post('charity/application/update', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Get application
			$exists = DB::table('charities')->where(['id' => $data['data']['charity_id'], 'owner_id' => $data['owner_id']])->first();
			// Check if charity application exists
			if ($exists) {
				// Check if charity details record has been created
				$details = DB::table('charities_details')->where(['charity_id' => $data['data']['charity_id']])->first();
				// Check if details record needs created
				if (!$details) {
					// Create charity details record
					$details = DB::table('charities_details')->insertGetId(['charity_id' => $data['data']['charity_id']]);
					// Get record
					$details = DB::table('charities_details')->where(['charity_id' => $data['data']['charity_id']])->first();
				}
				// Store update data
				$update_data = array();

				// Check if item is to be updated
				if (@$data['data']['charity_name']) {
					$update_data['charity_name'] = $data['data']['charity_name'];
				}

				// Check if item is to be updated
				if (@$data['data']['charity_website']) {
					$update_data['charity_website'] = $data['data']['charity_website'];
				}

				// Check if item is to be updated
				if (@$data['data']['phone_number']) {
					$update_data['phone_number'] = phone_to_international($data['data']['phone_number']);
				}
				// Update charity details
				$update = DB::table('charities_details')->where(['id' => $details->id])->update($update_data);
				// Update charity name
				$update = DB::table('charities')->where(['id' => $details->charity_id])->update(['name' => $update_data['charity_name']]);
				// Get most recent info on the charity
				$charity = DB::table('charities')->where(['id' => $data['data']['charity_id'], 'owner_id' => $data['owner_id']])->first();
				// Check if there is not a connected account with the charity
				if ($charity && $charity->payout_reference_id == '') {
					// Create connected account for the charity
					$account = DD_Stripe::createConnectedAccount($charity, $data['ip']);
				}
				// Check if update happened
				return json_encode(true);
			}
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




	Route::post('charity/representative/update', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Get application
			$exists = DB::table('charities')->where(['id' => $data['data']['charity_id'], 'owner_id' => $data['owner_id']])->first();
			// Check if charity application exists
			if ($exists) {

				return json_encode('XXX');

			}
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




	Route::get('charity/get/{charity_id}', function(Request $request, $charity_id) {
		try {
			// Get charity
			$charity = DB::table('charities')->where(['id' => $charity_id])->first();
			// Check if charity was found
			if ($charity) {
				// Get charity details
				$charity->details = DB::table('charities_details')->where(['charity_id' => $charity_id])->first();
				// Get charity staff members
				$charity->staff = DB::table('charities_staff')->where(['charity_id' => $charity_id, 'request_approved' => true])->orderBy('date_added', 'ASC')->get();
				// Get charity representative
				$charity->representative = DB::table('charities_representative')->where(['charity_id' => $charity_id])->first();
				// Get donations to the charity
				$charity->donations = DB::table('donations')->where(['charity_id' => $charity_id])->orderBy('date_taken', 'DESC')->limit(30)->get();
			}
			return json_encode($charity);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




	Route::get('connected-charities/{user_id}', function(Request $request, $user_id) {
		try {
			// Show all charities to Ryan
			if (intval($user_id) === 1) {
				// Get charities
				$charities = DB::table('charities')
					->orderBy('charities.name', 'ASC')
					->groupBy('charities.id')
					->orderBy('charities.id', 'ASC')->get();
			} else {
				// Get charities for this user
				$charities = DB::table('charities')
					->join('charities_staff', 'charities.id', '=', 'charities_staff.charity_id')
					->where(['charities_staff.user_id' => $user_id, 'charities_staff.request_approved' => true])
					->select('charities.*')
					->orderBy('charities.name', 'ASC')
					->groupBy('charities.id')
					->orderBy('charities.id', 'ASC')->get();
			}
			// Return charities
			return json_encode($charities);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




	Route::get('update/connected-charity/{charity_id}/{user_id}', function(Request $request, $charity_id, $user_id) {
		try {
			// Get charity
			$charity = DB::table('charities')->where(['id' => $charity_id])->first();
			// Check if charity was found
			if ($charity) {
				// Get charity details
				$charity->details = DB::table('charities_details')->where(['charity_id' => $charity_id])->first();
				// Update Stripe connected account
				$charity = DD_Stripe::updateConnectedAccount($charity);
				// Return charity data
				return json_encode($charity);
			}
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




	Route::get('invite/get/{invite_token}', function(Request $request, $invite_token) {
		try {
			// Get invite
			$invite = DB::table('user_invites')->where(['invite_token' => $invite_token, 'request_approved' => null])->first();
			// Check if invite was found
			if ($invite) {
				// Get user if the invite has a user connected to it
				$invite->user = DB::table('users')->where(['email' => $invite->email_address])->first();
				// Get charity the invite has connected to it
				$invite->charity = DB::table('charities')->where(['id' => $invite->charity_id])->first();
				// Return invite data
				return json_encode($invite);
			}
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




	Route::get('invite/accept/{invite_token}/{user_id}', function(Request $request, $invite_token, $user_id) {
		try {
			// Get invite
			$invite = DB::table('user_invites')->where(['invite_token' => $invite_token])->first();
			// Check if invite was found
			if ($invite) {
				//	Check if invite has expired (more than 48 hours old)
				if (strtotime($invite->date_added) <  time() - (60*60*48)) {
					// Send false as expired
					return json_encode(false);
				}
				// Get charity the invite has connected to it
				$invite->charity = DB::table('charities')->where(['id' => $invite->charity_id])->first();
				// Update invite
				$update = DB::table('user_invites')->where(['id' => $invite->id])->update(['request_approved' => true]);
				// Get existing record
				$exists = DB::table('charities_staff')->where(['charity_id' => $invite->charity_id, 'user_id' => $invite->user_id])->first();
				// Ensure user is not already in charity
				if (!$exists) {
					// Get user
					$user = DB::table('users')->where(['email' => $invite->email_address])->first();
					// Add user to charity
					$charity_user = DB::table('charities_staff')->insert([
						'request_approved' 	=> true,
						'last_updated'		=> date('Y-m-d H:i:s', time()),
						'charity_id'		=> $invite->charity_id,
						'user_id'			=> $user->id,
						'role'				=> $invite->role,
					]);
					// Return data
					return json_encode(array('invite' => $invite, 'result' => true));
				}
				// Return data
				return json_encode(array('invite' => $invite, 'result' => true));
			}
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




	Route::get('invite/decline/{invite_token}/{user_id}', function(Request $request, $invite_token, $user_id) {
		try {
			// Get invite
			$invite = DB::table('user_invites')->where(['invite_token' => $invite_token])->first();
			// Check if invite was found
			if ($invite) {
				//	Check if invite has expired (more than 48 hours old)
				if (strtotime($invite->date_added) <  time() - (60*60*48)) {
					// Send false as expired
					return json_encode(false);
				}
				// Get charity the invite has connected to it
				$invite->charity = DB::table('charities')->where(['id' => $invite->charity_id])->first();
				// Update invite
				$invite = DB::table('user_invites')->where(['id' => $invite->id])->update(['request_approved' => false]);
				// Return success data
				return json_encode(true);
			}
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




	Route::post('invite/new-charity-staff', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Get charity
			$charity = DB::table('charities')->where(['id' => $data['charity_id']])->first();
			// Check if charity was found
			if ($charity) {
				// Get user's staff profile
				$staff = DB::table('charities_staff')->where(['charity_id' => $data['charity_id'], 'user_id' => $data['user_id']])->first();



				// Check if staff member is an administrator
				if ($staff->role == 'administrator') {
					// Get staff user name
					$staff->user = DB::table('users')->where(['id' => $staff->user_id])->first();
					// Check if user should be admin
					if ($data['is_admin'] === true || $data['is_admin'] == 'true') {
						// Set invited user role as admin
						$invite_user_role = 'administrator';
					} else {
						// Set invited user role as staff
						$invite_user_role = 'staff';
					}
					// Add invite to invites database table
					$invite_record = DB::table('user_invites')->insertGetId([
						'invite_token'		=> sha1(uniqid(sha1($data['email'].'DashDonate').time())),
						'charity_id'		=> $charity->id,
						'email_address'		=> $data['email'],
						'role'				=> $invite_user_role
					]);
					// Get invite record
					$invite_record = DB::table('user_invites')->where(['id' => $invite_record])->first();
					// Get token
					$invite_token = $invite_record->invite_token;
					// Email info
					$email = array(
						'recipient'			=> $data['email'],
						'inviter'			=> $staff,
						'positive_action'	=> env('FRONTEND_URL').'/invite/charity/'.$invite_token,
					);
					// Search for user by email
					$invitee = DB::table('users')->where(['email' => $data['email']])->first();
					// See if invited user has already got an account
					if ($invitee == true) {
						// Invite to join charity
						$email['subject'] = 'You\'ve been invited to join a charity on DashDonate.org';
						// Set template name
						$template = 'emails.charity_staff_invite_existing';
					} else {
						// Invite to create account
						$email['subject'] = 'You\'ve been invited to join DashDonate.org';
						// Set template name
						$template = 'emails.charity_staff_invite_new';
					}
					// Send email
					$send = Mail::send($template, ['email' => $email], function($m) use ($email) {
						$m->from('team@dashdonate.org', 'DashDonate.org');
						$m->to($email['recipient'])->subject($email['subject']);
					});
					// Check for failures
					if (Mail::failures()) {
						// Return response to sending
						return json_encode(false);
					}
					// Return response to sending
					return json_encode(true);
				}
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');








	Route::post('files/upload/identity', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Insert record
			$file = DB::table('charity_files')->insertGetId([
				'charity_id'		=> $data['charity_id'],
				'user_id'			=> $data['user_id'],
				'stripe_file_id'	=> $data['stripe_file_id'],
				'file_intent'		=> $data['file_intent'],
			]);
			// Get file
			$file = DB::table('charity_files')->where(['id' => $file])->first();
			// Switch type
			switch ($data['file_intent']) {
				case 'stripe_id_front':
					$update = array('stripe_id_front' => $file->id);
				break;
				case 'stripe_id_back':
					$update = array('stripe_id_back' => $file->id);
				break;
				case 'stripe_proof_of_address':
					$update = array('stripe_proof_of_address' => $file->id);
				break;
				case 'charity_utility_bill':
					$update = array('charity_proof_of_address_file_id' => $file->id);
				break;
			}
			// Check if the file is to be assigned to the charity or the rep
			if ($data['file_intent'] == 'charity_utility_bill') {
				// Add file to charity details
				DB::table('charities')->where(['id' => $data['charity_id']])->update($update);
			} else {
				// Add file to representative details
				$rep = DB::table('charities_representative')->where(['charity_id' => $data['charity_id']])->update($update);
			}
			// Return file data
			return json_encode($file);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/submit/charity-representative', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Get charity
			$charity = DB::table('charities')->where(['id' => $data['charity_id']])->first();
			// Check if charity was found
			if ($charity) {
				// Get user's staff profile
				$staff = DB::table('charities_staff')->where(['charity_id' => $data['charity_id'], 'user_id' => $data['user_id']])->first();
				// Check if staff member is an administrator
				if ($staff->role == 'administrator') {
					// Update representative details
					$representative = DD_Stripe::update_representative($charity, $data['user_id']);

					return json_encode($representative);
				}
			}
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




	function phone_to_international($number) {
		// Remove spaces
		$number = str_replace(' ', '', $number);
		// Make sure the number is actually a number
		if (is_numeric($number)) {
			// If number doesn't start with a 0 or a 4 add a 0 to the start
			if ($number[0] != 0 && $number[0] != 4) {
				$number = '0'.$number;
			}
			// If number starts with a 0 replace with 4
	        if ($number[0] == 0) {
	            $number[0] = str_replace('0', '4', $number[0]);
	            $number = '4'.$number;
	        }
			// Remove any spaces in the number
			$number = str_replace(' ', '', $number);
			// Return the number
			return $number;
		}
		return $number;
	}
































































































	Route::get('charity/crn-in-use/{crn?}', function($crn = '') {
		try {
			// Check if CRN value is not null
			if (strlen(trim($crn)) == 0) {
				return json_encode('A charity registration number is required.');
			}
			// Get the charity that uses the CRN
			$charity = DB::table('charities')->where(['charity_registration_number' => strtolower($crn), 'verified' => true])->first();
			// Check if CRN is used in an existing charity
			if ($charity) {
				// Return that it is in use
				return json_encode('crn_in_use');
			}
			// Holding variable
			$crn_is_valid = false;
			// Check with england and wales register
			$eng_wales = CharityRegister::searchForCharity_englandWales($crn);
			// Check if valid
			if (!empty($eng_wales)) {
				// CRN is valid with England and Wales register
				$crn_is_valid = true;
			}
			// Check to see if CRN is a valid registered CRN
			if ($crn_is_valid) {
				return json_encode('valid');
			} else {
				return json_encode('invalid_crn');
			}
		} catch (Exception $e) {
			return json_encode($e->getMessage());
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/charity/create-initial-charity-application', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Check if CRN value is not null
			if (strlen(trim($data['crn'])) == 0) {
				// Return failure reason
				return json_encode('invalid_crn');
			}
			// Get the charity that uses the CRN
			$charity = DB::table('charities')->where(['charity_registration_number' => strtolower($data['crn']), 'verified' => true])->first();
			// Check if CRN is used in an existing charity
			if ($charity) {
				// Return that it is in use
				return json_encode('crn_in_use');
			}
			// Fetch the user that is registering the charity
			$owner_user = DB::table('users')->where(['id' => $data['owner_user_id']])->first();
			// Check if the user has been found
			if (!$owner_user) {
				// Return failure reason
				return json_encode('no_user');
			}
			// Check if the user needs to be verified
			if ($owner_user->is_email_confirmed == false) {
				// Return failure reason
				return json_encode('unverified_user');
			}
			// Find which charity commission the charity is registered under
			$commission_name = CharityRegister::findRegister($data['crn']);
			// Check if the commission search failed
			if (!$commission_name) {
				// Return failure reason
				return json_encode('commission_unsupported');
			}
			// Get charity information from the relevant commission
			$charity_data_from_the_commission = CharityRegister::{'getCharityInfo_'.$commission_name}($data['crn']);
			// Check if there was no data was found for the charity
			if (!$charity_data_from_the_commission) {
				// Return failure reason
				return json_encode('invalid_crn');
			}
			// Create slug for charity
			$charity_slug = 'char_'.sha1($data['crn'].sha1(time().rand()).'DashDonate.org');
			// Create site API ID for charity
			$api_site_id = sha1($data['crn'].sha1(time().rand()).'api.dashdonate.org');
			// Create charity application record
			$charity_application = DB::table('charities')->insertGetId([
				'name'								=> $charity_data_from_the_commission['charity_name'],
				'slug'								=> $charity_slug,
				'owner_id'							=> $owner_user->id,
				'charity_registration_number'		=> $data['crn'],
				'payout_reference_id'				=> '',
				'verified'							=> false,
				'data_captured_from_commission'		=> true,
				'companies_house_number'			=> $charity_data_from_the_commission['companies_house_number'],
				'commission_name'					=> $commission_name,
				'api_site_id'						=> $api_site_id,
			]);
			// Check if the insert failed
			if ($charity_application == false) {
				// Return failure reason
				return json_encode('charities_insert_failed');
			}
			// Create charity staff record for the owner
			$charity_owner = DB::table('charities_staff')->insertGetId([
				'request_approved'		=> true,
				'charity_id'			=> $charity_application,
				'user_id'				=> $owner_user->id,
				'role'					=> 'administrator',
				'is_owner'				=> true,
				'is_representative'		=> false,
			]);
			// Check if the insert failed
			if ($charity_owner == false) {
				// Return failure reason
				return json_encode('charities_staff_insert_failed');
			}
			// Create charity deyails record
			$charity_details = DB::table('charities_details')->insertGetId([
				'charity_id'				=> $charity_application,
				'charity_name'				=> $charity_data_from_the_commission['charity_name'],
				'charity_website'			=> $charity_data_from_the_commission['public_website'],
				'charity_email'				=> $charity_data_from_the_commission['public_emailaddress'],
				'phone_number'				=> $charity_data_from_the_commission['public_telephone'],
				'address_line_1'			=> $charity_data_from_the_commission['address_line_1'],
				'address_line_2'			=> $charity_data_from_the_commission['address_line_2'],
				'address_town_city'			=> $charity_data_from_the_commission['address_town_city'],
				'address_postcode'			=> $charity_data_from_the_commission['address_postcode'],
				'description_of_charity'	=> $charity_data_from_the_commission['description_of_charity'],
				'charity_goals_onboarding'	=> $data['registration_goals'],
			]);
			// Check if the insert failed
			if ($charity_details == false) {
				// Return failure reason
				return json_encode('charities_details_insert_failed');
			}
			// Return success
			return json_encode(array('success' => true, 'charity_slug' => $charity_slug));
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




	Route::get('charity/get-staff-role/{charity_slug}/{user_id}', function($charity_slug, $user_id) {
		try {
			// Try and find charity
			$charity = DB::table('charities')->where(['slug' => $charity_slug])->first();
			// See if charity failed to be found
			if (!$charity) {
				// Return error
				return json_encode(false);
			}
			// Check if user ID was passed
			if ($user_id != 0) {
				// Get staff user record
				$user = DB::table('charities_staff')->where(['charity_id' => $charity->id, 'user_id' => $user_id, 'request_approved' => true])->first();
				// See if user was found
				if ($user) {
					// Return role
					return json_encode($user->role);
				}
			}
			// Is not staff, so return false
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');



	// $res = DashDonate::api_call('POST', '/charity/remove-authorised-website', [
	// 	'charity_slug'	=> $charity_slug,
	// 	'user_id'		=> Auth::user()->id,
	// 	'website_id'	=> $website_id,
	// ]);
	Route::post('/charity/remove-authorised-website', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Get charity
			$charity = DB::table('charities')->where(['slug' => $data['charity_slug']])->first();
			// Check if charity exists
			if ($charity) {
				// Get staff user profile
				$staff = DB::table('charities_staff')->where([
					'role'				=> 'administrator',
					'charity_id'		=> $charity->id,
					'user_id'			=> $data['user_id'],
					'request_approved'	=> true,
				])->first();
				// Check if user is admin
				if ($staff) {
					// Delete item
					DB::table('authorised_websites')->where([
						'id'				=> $data['website_id'],
						'charity_id' 		=> $charity->id,
					])->delete();
					// Return success
					return json_encode(['success' => true]);
				}
				// Return error
				return json_encode('not_administrator');
			}
			// Return error
			return json_encode('charity_not_found');
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/charity/add-authorised-website', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Get charity
			$charity = DB::table('charities')->where(['slug' => $data['charity_slug']])->first();
			// Check if charity exists
			if ($charity) {
				// Get staff user profile
				$staff = DB::table('charities_staff')->where([
					'role'				=> 'administrator',
					'charity_id'		=> $charity->id,
					'user_id'			=> $data['user_id'],
					'request_approved'	=> true,
				])->first();
				// Check if user is admin
				if ($staff) {
					// Parse URL to get URL root (rather than a page)
					$url = 'https://'.parse_url($data['url'], PHP_URL_HOST);
					// Get existing to prevent repeats
					$exists = DB::table('authorised_websites')->where(['charity_id' => $charity->id, 'website_url' => $url])->first();
					// Check if website isn't already added
					if (!$exists) {
						// Add site to authorised website list of this charity
						DB::table('authorised_websites')->insert([
							'charity_id' 		=> $charity->id,
							'website_url' 		=> $url,
						]);
					}
					// Return success
					return json_encode(['success' => true]);
				}
				// Return error
				return json_encode('not_administrator');
			}
			// Return error
			return json_encode('charity_not_found');
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::get('charity/get-by-slug/{charity_slug}/{staff_user_id}/{donation_data?}', function($charity_slug, $staff_user_id, $donation_data = false) {
		try {
			// Try and find charity
			$charity = DB::table('charities')->where(['slug' => $charity_slug])->first();
			// See if charity failed to be found
			if (!$charity) {
				// Return error
				return json_encode('not_found');
			}
			// Get charity details
			$charity->details = DB::table('charities_details')->where(['charity_id' => $charity->id])->first();
			// Get logo file
			$charity->details->logo = DB::table('file_uploads')->where(['id' => $charity->details->logo_file_id])->first();
			// Get charity staff
			$charity->staff = DB::table('charities_staff')->where(['charity_id' => $charity->id])->orderBy('date_added', 'ASC')->get();
			// Check if staff user ID was passed
			if ($staff_user_id != 0) {
				// Get staff user record
				$charity->local_staff_user = DB::table('charities_staff')->where(['charity_id' => $charity->id, 'user_id' => $staff_user_id, 'request_approved' => true])->first();
			} else {
				// Set blank staff user record
				$charity->local_staff_user = null;
			}
			// Get authorised websites
			$charity->authorised_websites = DB::table('authorised_websites')->where(['charity_id' => $charity->id])->orderBy('website_url', 'ASC')->get();


			// Get number of page views
			$charity->page_views_total = DB::table('donation_sessions')->where(['site_id' => $charity->id])->count();


			// Check if to get data about donations
			if ($donation_data) {
				// Get donations data for the charity
				$charity->donations = DB::table('donations')->where([
					'charity_id'	=> $charity->id,
				])->orderBy('date_taken', 'DESC')->get();

				// Loop through all
				for ($i = 0; $i < sizeof($charity->donations); $i++) {
					// Calc total for charity
					$charity->donations[$i]->total_to_charity = $charity->donations[$i]->amount - $charity->donations[$i]->total_fees;
				}


				// // Get scheduled donations for this charity
				// $charity->scheduled_donations = DB::table('donations_task_list')->where([
				// 	'charity_id'	=> $charity->id,
				// 	'recurring'		=> false,
				// 	'active'		=> true,
				// ])->orderBy('date_to_process', 'ASC')->get();

				// Get scheduled donations for this user
				$charity->scheduled_donations = DB::table('cron_tasks')->where([
					'charity_id'			=> $charity->id,
					'task_type'				=> 'scheduled_donation',
					'active'				=> true,
				])->groupBy('task_group_token')->orderBy('date_to_process', 'ASC')->get();

				// Get data for scheduled donations
				$charity->scheduled_donations = getDonationDetailsForFetching($charity->scheduled_donations, false);

				// // Loop through all
				// for ($i = 0; $i < sizeof($charity->scheduled_donations); $i++) {
				// 	// Calc total for charity
				// 	$charity->scheduled_donations[$i]->total_to_charity = $charity->scheduled_donations[$i]->amount - $charity->scheduled_donations[$i]->total_fees;
				// }


				// // Get repeat donations for this user
				// $charity->repeat_donations = DB::table('donations_task_list')->where([
				// 	'charity_id'	=> $charity->id,
				// 	'recurring'		=> true,
				// 	'active'		=> true,
				// ])->orderBy('date_to_process', 'ASC')->get();

				// Get repeating donations for this user
				$charity->repeat_donations = DB::table('cron_tasks')->where([
					'charity_id'			=> $charity->id,
					'task_type'				=> 'repeating_donation',
					'active'				=> true,
				])->groupBy('task_group_token')->orderBy('date_to_process', 'ASC')->get();

				// Get data for repeating donations
				$charity->repeat_donations = getDonationDetailsForFetching($charity->repeat_donations, false);

				// // Loop through all
				// for ($i = 0; $i < sizeof($charity->repeat_donations); $i++) {
				// 	// Calc total for charity
				// 	$charity->repeat_donations[$i]->total_to_charity = $charity->repeat_donations[$i]->amount - $charity->repeat_donations[$i]->total_fees;
				// }

			} else {

				// Get amount of donations for today
				$charity->donations_today = DB::table('donations')->where([
					'charity_id'	=> $charity->id,
				])->whereDate('date_taken', Carbon::today())->count();
				// Get value of donations for today
				$charity->donations_today_total = DB::table('donations')->where([
					'charity_id'	=> $charity->id,
				])->whereDate('date_taken', Carbon::today())->sum('amount');

				// Get value of fees for donations today
				$charity->donations_today_total_fees = DB::table('donations')->where([
					'charity_id'	=> $charity->id,
				])->whereDate('date_taken', Carbon::today())->sum('total_fees');
				// Take fees away from total
				$charity->donations_today_total -= $charity->donations_today_total_fees;




				// Get amount of donations for the past 7 days
				$charity->donations_7days = DB::table('donations')->where([
					'charity_id'	=> $charity->id,
				])->whereDate('date_taken', '>=', Carbon::today()->subDays(7))->count();
				// Get value of donations for the past 7 days
				$charity->donations_7days_total = DB::table('donations')->where([
					'charity_id'	=> $charity->id,
				])->whereDate('date_taken', '>=', Carbon::today()->subDays(7))->sum('amount');

				// Get value of fees for donations today
				$charity->donations_7days_total_fees = DB::table('donations')->where([
					'charity_id'	=> $charity->id,
				])->whereDate('date_taken', '>=', Carbon::today()->subDays(7))->sum('total_fees');
				// Take fees away from total
				$charity->donations_7days_total -= $charity->donations_7days_total_fees;




				// Get amount of donations for the month to date
				$charity->donations_mtd = DB::table('donations')->where([
					'charity_id'	=> $charity->id,
				])->whereDate('date_taken', '>=', Carbon::today()->subDays(7))->count();
				// Get value of donations for month to date
				$charity->donations_mtd_total = DB::table('donations')->where([
					'charity_id'	=> $charity->id,
				])->whereDate('date_taken', '>=', Carbon::today()->startOfMonth())->sum('amount');

				// Get value of fees for donations today
				$charity->donations_mtd_total_fees = DB::table('donations')->where([
					'charity_id'	=> $charity->id,
				])->whereDate('date_taken', '>=', Carbon::today()->startOfMonth())->sum('total_fees');
				// Take fees away from total
				$charity->donations_mtd_total -= $charity->donations_mtd_total_fees;




				// Get amount of donations all-time
				$charity->donations_alltime = DB::table('donations')->where([
					'charity_id'	=> $charity->id,
				])->count();
				// Get value of donations for all-time
				$charity->donations_alltime_total = DB::table('donations')->where([
					'charity_id'	=> $charity->id,
				])->sum('amount');

				// Get value of fees for donations today
				$charity->donations_alltime_total_fees = DB::table('donations')->where([
					'charity_id'	=> $charity->id,
				])->sum('total_fees');
				// Take fees away from total
				$charity->donations_alltime_total -= $charity->donations_alltime_total_fees;

			}


			$charity->widget_apikey = 'DD-1234';


			// Check if requirement was due and it has been resolved
			if ($charity->needs_representative == true) {
				// Get charity representative
				$charity->representative = DB::table('charities_staff')->where(['charity_id' => $charity->id, 'is_representative' => true])->first();
				// Check if representative exists
				if ($charity->representative) {
					// Check if representative is fetching data
					if (@$charity->representative->user_id == intval($staff_user_id)) {
						// Get representative details record
						$charity->representative->details = DB::table('charities_representative')->where([
							'charity_id' 	=> $charity->id,
							'user_id'		=> $staff_user_id,
						])->first();
						// Update charity record as rep has been added
						DB::table('charities')->where(['slug' => $charity_slug])->update(['needs_representative' => false]);
						// Update data object
						$charity->needs_representative = false;
					}
				}
			}
			// Check if requirement was due and it has been resolved
			if ($charity->needs_representative_id || $charity->representative_id_pending) {
				// Get charity representative
				$charity->representative = DB::table('charities_staff')->where(['charity_id' => $charity->id, 'is_representative' => true])->first();
				// Check if representative exists
				if ($charity->representative) {
					// Check if representative is fetching data
					if (@$charity->representative->user_id == intval($staff_user_id)) {
						// Get verification details of representative
						$representative_verification = DD_Stripe::getStatusOfRepresentativeVerification($charity);
						// Check if started verification
						if (@$representative_verification->verification) {
							// Switch status
							switch ($representative_verification->verification->status) {
								case 'verified':
									// Update charity record
									DB::table('charities')->where(['slug' => $charity_slug])->update([
										'representative_id_pending' 	=> false,
										'needs_representative_id' 		=> false,
									]);
									// Update data object
									$charity->representative_id_pending = false;
									$charity->needs_representative_id 	= false;
								break;
								case 'pending':
									// Update charity record
									DB::table('charities')->where(['slug' => $charity_slug])->update([
										'representative_id_pending' 	=> true,
										'needs_representative_id' 		=> false,
									]);
									// Update data object
									$charity->representative_id_pending = true;
									$charity->needs_representative_id 	= false;
								break;
								default:
									// Update charity record
									DB::table('charities')->where(['slug' => $charity_slug])->update([
										'representative_id_pending' 	=> true,
										'needs_representative_id' 		=> true,
									]);
									// Update data object
									$charity->representative_id_pending = false;
									$charity->needs_representative_id 	= true;
								break;
							}
						}
					}
				}
			}
			// Check if requirement was due and it has been resolved
			if ($charity->bank_account_needs_verified) {
				// Get connected account details of charity
				$connected_account = DD_Stripe::getStatusOfConnectedAccount($charity);
				// Check if connected account is been added
				if ($connected_account) {
					// Check if payouts are enabled (will only happen if bank is approved)
					if ($connected_account->payouts_enabled == true) {
						// Update charity record
						DB::table('charities')->where(['slug' => $charity_slug])->update([
							'needs_bank_account' 			=> false,
							'bank_account_needs_verified' 	=> false,
						]);
						// Update data object
						$charity->needs_bank_account 			= false;
						$charity->bank_account_needs_verified 	= false;
					} else {
						// Check if status exists
						if (@$connected_account->external_accounts->data[0]->status) {
							// Switch status of bank account
							switch (@$connected_account->external_accounts->data[0]->status) {
								default:
									// Update charity record
									DB::table('charities')->where(['slug' => $charity_slug])->update([
										'needs_bank_account' 			=> false,
										'bank_account_needs_verified' 	=> true,
									]);
									// Update data object
									$charity->needs_bank_account 			= false;
									$charity->bank_account_needs_verified 	= true;
								break;
							}
						} else {
							// Update charity record
							DB::table('charities')->where(['slug' => $charity_slug])->update([
								'needs_bank_account' 			=> true,
								'bank_account_needs_verified' 	=> true,
							]);
							// Update data object
							$charity->needs_bank_account 			= true;
							$charity->bank_account_needs_verified 	= true;
						}
					}
				} else {
					// Update charity record
					DB::table('charities')->where(['slug' => $charity_slug])->update([
						'bank_account_needs_verified' 	=> true,
						'needs_bank_account' 			=> true,
					]);
					// Update data object
					$charity->bank_account_needs_verified 	= true;
					$charity->needs_bank_account 			= true;
				}
			}
			// Active staff counter
			$active_staff_count = 0;
			// Loop through charity staff
			for ($i = 0; $i < sizeof($charity->staff); $i++) {
				// Check if staff member is active
				if ($charity->staff[$i]->request_approved == true) {
					// Increment counter
					$active_staff_count++;
					// Get user info for the staff member
					$charity->staff[$i]->details = DB::table('users')->where(['id' => $charity->staff[$i]->user_id])->first();
				}
			}
			// Check that there are at least two active members of staff
			if ($active_staff_count >= 2) {
				// Update charity record
				DB::table('charities')->where(['slug' => $charity_slug])->update([
					'needs_staff_added' 	=> false,
				]);
				// Update data object
				$charity->needs_staff_added 	= false;
			} else {
				// Update charity record
				DB::table('charities')->where(['slug' => $charity_slug])->update([
					'needs_staff_added' 	=> true,
				]);
				// Update data object
				$charity->needs_staff_added 	= true;
			}




			// Check if requirement was due and it has been resolved
			if ($charity->needs_charity_proof_of_address) {
				// Get connected account details of charity
				$connected_account = DD_Stripe::getStatusOfConnectedAccount($charity);
				// Check if connected account is been added
				if ($connected_account) {
					// Get verification details of charity address
					$charity_address_verification = DD_Stripe::getStatusOfAddressVerification($charity);
					// Check if verification has been added
					if (@$charity_address_verification->company->verification->document->front) {
						// Update charity record
						DB::table('charities')->where(['slug' => $charity_slug])->update([
							'needs_charity_proof_of_address' 				=> false,
							'needs_charity_proof_of_address_pending' 		=> false,
						]);
						// Update data object
						$charity->needs_charity_proof_of_address 			= false;
						$charity->needs_charity_proof_of_address_pending 	= false;
					} else {
						// Update charity record
						DB::table('charities')->where(['slug' => $charity_slug])->update([
							'needs_charity_proof_of_address' 				=> true,
							'needs_charity_proof_of_address_pending' 		=> true,
						]);
						// Update data object
						$charity->needs_charity_proof_of_address 			= true;
						$charity->needs_charity_proof_of_address_pending 	= true;
					}
				}
			}






			// Default check
			$charity->is_activated_for_public = true;
			// Check if charity should not be public
			if ($charity->needs_representative						== true ||
				$charity->needs_dashdonate_approval					== true ||
				$charity->needs_representative_id					== true ||
				$charity->representative_id_pending					== true ||
				$charity->needs_details_review						== true ||
				$charity->needs_staff_added							== true ||
				$charity->needs_charity_proof_of_address			== true ||
				$charity->needs_charity_proof_of_address_pending	== true ||
				$charity->needs_bank_account						== true ||
				$charity->bank_account_needs_verified				== true
			) {
				// Check if user is not a staff member
				if ($charity->local_staff_user == null) {
					// Set as not activated for public
					$charity->is_activated_for_public = false;
				}
			}







			// Set Carbon now value
			$carbonNow = Carbon::now();

			$charity->dashboard = array(
				'thisweek_weekstart'	=> date('jS', strtotime($carbonNow->startOfWeek())).' '.strtoupper(date('M', strtotime($carbonNow->startOfWeek()))),
				'lastweek_weekstart'	=> date('jS', strtotime($carbonNow->startOfWeek()->subDays(7))).' '.strtoupper(date('M', strtotime($carbonNow->startOfWeek()))),
				'audience'			=> array(
					'sources'				=> array(),
					'visits'				=> array(
						'thisweek'				=> array(),
						'thisweek_total'		=> 0,
						'thisweek_conversion'	=> 0,
						'thisweek_newvisitors'	=> 0,
						'lastweek'				=> array(),
						'lastweek_total'		=> 0,
					),
				),
				'donations' 		=> array(
					'all'					=> array(),
					'recent'				=> array(
						'thisweek'				=> array(),
						'thisweek_total'		=> 0,
						'thisweek_totalfees'	=> 0,
						'thisweek_oneoff'		=> 0,
						'thisweek_recurring'	=> 0,
						'thisweek_count'		=> 0,
						'lastweek'				=> array(),
						'lastweek_total'		=> 0,
						'lastweek_totalfees'	=> 0,
						'lastweek_count'		=> 0,
					),
					'next6months'			=> array(
						'graph'					=> array(),
						'total'					=> 0,
						'sixmonth_start'		=> date('jS M Y', strtotime(Carbon::now())),
						'sixmonth_end'			=> date('jS M Y', strtotime(Carbon::now()->addMonths(5))),
						'sixmonth_label_month1'	=> date('M y', strtotime(Carbon::now())),
						'sixmonth_label_month2'	=> date('M y', strtotime(Carbon::now()->addMonths(1))),
						'sixmonth_label_month3'	=> date('M y', strtotime(Carbon::now()->addMonths(2))),
						'sixmonth_label_month4'	=> date('M y', strtotime(Carbon::now()->addMonths(3))),
						'sixmonth_label_month5'	=> date('M y', strtotime(Carbon::now()->addMonths(4))),
						'sixmonth_label_month6'	=> date('M y', strtotime(Carbon::now()->addMonths(5))),
					),
				),
			);




			// Get list of donations
			$charity->dashboard['donations']['all'] = DB::table('donations')->where(['charity_id' => $charity->id, 'payment_status' => 'succeeded'])->orderBy('date_taken', 'DESC')->limit(20)->get();
			// Check donations exist
			if ($charity->dashboard['donations']['all']) {
				// Go though all fetched donations
				for ($x = 0; $x < sizeof($charity->dashboard['donations']['all']); $x++) {
					// Create unique ID
					$charity->dashboard['donations']['all'][$x]->unique_id = 100000000000000 + $charity->dashboard['donations']['all'][$x]->id;
				}
			}


			// Set Carbon now value
			$carbonNow = Carbon::now();

			// Get sum of donations this week
			$charity->dashboard['donations']['recent']['thisweek_total'] = DB::table('donations')
				->where(['charity_id' => $charity->id, 'payment_status' => 'succeeded'])
				->whereDate('date_taken', '>=', $carbonNow->startOfWeek())
				->sum('amount');


			// Get sum of donations this week
			$charity->dashboard['donations']['recent']['thisweek_totalfees'] = DB::table('donations')
				->where(['charity_id' => $charity->id, 'payment_status' => 'succeeded'])
				->whereDate('date_taken', '>=', $carbonNow->startOfWeek())
				->sum('total_fees');


			// Get count of donations this week
			$charity->dashboard['donations']['recent']['thisweek_count'] = DB::table('donations')
				->where(['charity_id' => $charity->id, 'payment_status' => 'succeeded'])
				->whereDate('date_taken', '>=', $carbonNow->startOfWeek())
				->count();


			// Get list of donations this week
			$charity->dashboard['donations']['recent']['thisweek'] = DB::table('donations')
			   	->where(['charity_id' => $charity->id, 'payment_status' => 'succeeded'])
				->whereDate('date_taken', '>=', $carbonNow->startOfWeek())
				->select('*', DB::raw('COUNT(*) AS counter'), DB::raw('SUM(amount) AS amount_total'), DB::raw('SUM(total_fees) AS fees_total'), DB::raw('DATE(date_taken) AS date'))
				->groupBy('date')
				->orderBy('date', 'ASC')
				->get();




			// Set Carbon now value
			$carbonNow = Carbon::now();

			// Get sum of donations this week
			$charity->dashboard['donations']['recent']['lastweek_total'] = DB::table('donations')
				->where(['charity_id' => $charity->id, 'payment_status' => 'succeeded'])
				->whereDate('date_taken', '<', $carbonNow->startOfWeek())
				->whereDate('date_taken', '>', $carbonNow->startOfWeek()->subDays(7))
				->sum('amount');

			// Get sum of donations this week
			$charity->dashboard['donations']['recent']['lastweek_totalfees'] = DB::table('donations')
				->where(['charity_id' => $charity->id, 'payment_status' => 'succeeded'])
				->whereDate('date_taken', '<', $carbonNow->startOfWeek())
				->whereDate('date_taken', '>', $carbonNow->startOfWeek()->subDays(7))
				->sum('total_fees');


			// Set Carbon now value
			$carbonNow = Carbon::now();

			// Get list of donations this week
			$charity->dashboard['donations']['recent']['lastweek'] = DB::table('donations')
			   	->where(['charity_id' => $charity->id, 'payment_status' => 'succeeded'])
				->whereDate('date_taken', '<', $carbonNow->startOfWeek())
				->whereDate('date_taken', '>', $carbonNow->startOfWeek()->subDays(7))
				->select('*', DB::raw('COUNT(*) AS counter'), DB::raw('SUM(amount) AS amount_total'), DB::raw('SUM(total_fees) AS fees_total'), DB::raw('DATE(date_taken) AS date'))
				->groupBy('date')
				->orderBy('date', 'ASC')
				->get();




			// Get list of donations for the next 6 months
			$next6Months = DB::table('cron_tasks')
			   	->where(['charity_id' => $charity->id, 'active' => true])
				->where(function ($q) {
					$q->where('task_type', 'repeating_donation')->orWhere('task_type', 'scheduled_donation');
				})
				->whereDate('date_to_process', '>', Carbon::now())
				->whereDate('date_to_process', '<', Carbon::now()->addMonths(5))
				->orderBy('date_to_process', 'ASC')
				->get();


			// Work out totals
			for ($i = 0; $i < sizeof($next6Months); $i++) {
				// Parse the meta data
				$next6Months[$i]->meta = json_decode($next6Months[$i]->meta);
				// Check type of donation
				if ($next6Months[$i]->task_type == 'repeating_donation') {
					// Get amount and convert to pence
					$amount = intval(floatval($next6Months[$i]->meta->repeatingAmount) * 100);
					// Check if fees are added on top of donation
					if ($next6Months[$i]->meta->repeatingPayFees === true) {
						// Get fees object for this donation
						$fees = DD_Stripe::calculateFeesData($amount, 'normal');
					} else {
						// Get fees object for this donation
						$fees = DD_Stripe::calculateFeesData($amount, 'none');
					}
				} else {
					// Get amount and convert to pence
					$amount = intval(floatval($next6Months[$i]->meta->scheduledAmount) * 100);
					// Check if fees are added on top of donation
					if ($next6Months[$i]->meta->scheduledPayFees === true) {
						// Get fees object for this donation
						$fees = DD_Stripe::calculateFeesData($amount, 'normal');
					} else {
						// Get fees object for this donation
						$fees = DD_Stripe::calculateFeesData($amount, 'none');
					}
				}
				// Add to total
				$charity->dashboard['donations']['next6months']['total'] += $fees['totalToCharity'];
				// Check if month does not exist already
				if (!isset($charity->dashboard['donations']['next6months']['graph'][date('M y', strtotime($next6Months[$i]->date_to_process))])) {
					// Add set first key for monthly totals
					$charity->dashboard['donations']['next6months']['graph'][date('M y', strtotime($next6Months[$i]->date_to_process))] = $fees['totalToCharity'];
				} else {
					// Add to monthly totals
					$charity->dashboard['donations']['next6months']['graph'][date('M y', strtotime($next6Months[$i]->date_to_process))] += $fees['totalToCharity'];
				}
			}










			// Get list of session sources
			$charity->dashboard['audience']['sources'] = DB::table('widget_sessions')->where(['charity_id' => $charity->id])->select('*', DB::raw('COUNT(*) AS counter'))->groupBy('referer_url')->get();




			// Set Carbon now value
			$carbonNow = Carbon::now();

			// Get count of donations this week
			$charity->dashboard['audience']['visits']['thisweek_total'] = DB::table('widget_sessions')
				->where(['charity_id' => $charity->id])
				->whereDate('date_created', '>=', $carbonNow->startOfWeek())
				->count();


			// Set Carbon now value
			$carbonNow = Carbon::now();

			// Get list of donations this week
			$charity->dashboard['audience']['visits']['thisweek'] = DB::table('widget_sessions')
				->where(['charity_id' => $charity->id])
				->whereDate('date_created', '>=', $carbonNow->startOfWeek())
				->select('*', DB::raw('COUNT(*) AS counter'), DB::raw('DATE(date_created) AS date'))
				->groupBy('date')
				->orderBy('date', 'ASC')
				->get();




			// Set Carbon now value
			$carbonNow = Carbon::now();

			$charity->dashboard['audience']['visits']['lastweek_total'] = DB::table('widget_sessions')
				->where(['charity_id' => $charity->id])
				->whereDate('date_created', '<', $carbonNow->startOfWeek())
				->whereDate('date_created', '>', $carbonNow->startOfWeek()->subDays(7))
				->count();


			// Set Carbon now value
			$carbonNow = Carbon::now();

			// Get list of donations last week
			$charity->dashboard['audience']['visits']['lastweek'] = DB::table('widget_sessions')
				->where(['charity_id' => $charity->id])
				->whereDate('date_created', '<', $carbonNow->startOfWeek())
				->whereDate('date_created', '>', $carbonNow->startOfWeek()->subDays(7))
				->select('*', DB::raw('COUNT(*) AS counter'), DB::raw('DATE(date_created) AS date'))
				->groupBy('date')
				->orderBy('date', 'ASC')
				->get();


			// Return charity data
			return json_encode($charity);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::get('charity/get-by-api-key/{apikey}/', function($apikey) {
		try {
			// Try and find charity
			$charity = DB::table('charities')->where(['api_site_id' => $apikey])->first();
			// See if charity failed to be found
			if (!$charity) {
				// Return error
				return json_encode('not_found');
			}
			// Get charity details
			$charity->details = DB::table('charities_details')->where(['charity_id' => $charity->id])->first();
			// Get logo file
			$charity->details->logo = DB::table('file_uploads')->where(['id' => $charity->details->logo_file_id])->first();
			// Get authorised websites
			$charity->authorised_websites = DB::table('authorised_websites')->where(['charity_id' => $charity->id])->orderBy('website_url', 'ASC')->get();
			// Default check
			$charity->is_activated_for_public = true;
			// Check if charity should not be public
			if ($charity->needs_representative						== true ||
				$charity->needs_dashdonate_approval					== true ||
				$charity->needs_representative_id					== true ||
				$charity->representative_id_pending					== true ||
				$charity->needs_details_review						== true ||
				$charity->needs_staff_added							== true ||
				$charity->needs_charity_proof_of_address			== true ||
				$charity->needs_charity_proof_of_address_pending	== true ||
				$charity->needs_bank_account						== true ||
				$charity->bank_account_needs_verified				== true
			) {
				// Set as not activated for public
				$charity->is_activated_for_public = false;
			}
			// Return charity data
			return json_encode($charity);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/charity/invite-representative', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Check if email is valid
			if (!filter_var($data['recipient_email'], FILTER_VALIDATE_EMAIL)) {
				// Return error
				return json_encode('invalid_recipient');
			}
			// Get charity
			$charity = DB::table('charities')->where(['slug' => $data['charity_slug']])->first();
			// Check if charity was not found
			if (!$charity) {
				// Return error
				return json_encode('no_charity');
			}
			// Ensure that the inviter user is an approved staff member of the charity
			$is_approved_staff = DB::table('charities_staff')->where([
				'charity_id' 			=> $charity->id,
				'user_id' 				=> $data['inviter_user_id'],
				'request_approved'		=> true,
			])->first();
			// Check if staff was not found
			if (!$is_approved_staff && !$data['inviter_user_id'] === 1) {
				// Return error
				return json_encode('not_staff');
			}
			// Get details of the inviter
			$inviter = DB::table('users')->where(['id' => $data['inviter_user_id']])->first();
			// Search for a DashDonate account for the recipient of the invite
			$recipient_account = DB::table('users')->where(['email' => $data['recipient_email']])->first();
			// Check if recipient is already a DashDonate user
			if ($recipient_account) {
				// Get record if recipient is already a member of staff
				$already_staff = DB::table('charities_staff')->where([
					'charity_id' 			=> $charity->id,
					'user_id' 				=> $recipient_account->id,
					'request_approved' 		=> true,
				])->first();
				// Check if the recipient is already a member of staff
				if ($already_staff) {
					// Return error
					return json_encode('already_staff');
				}
			}
			// Create a random invite token
			$invite_token = sha1(uniqid(sha1($data['recipient_email'].'DashDonate').time()));
			// Record invite in DB
			$invite = DB::table('user_invites')->insert([
				'invite_token'						=> $invite_token,
				'charity_id'						=> $charity->id,
				'email_address'						=> $data['recipient_email'],
				'user_id'							=> @$recipient_account->id,
				'role'								=> 'staff',
				'invite_to_be_representative'		=> true,
			]);
			// Check that the invite was saved
			if ($invite) {
				// Create email data array
				$email = array(
					'recipient'			=> $data['recipient_email'],
					'inviter'			=> $inviter,
					'positive_action'	=> env('FRONTEND_URL').'/invite/charity/'.$invite_token,
				);
				// Check if recipient already has a DashDonate account
				if ($recipient_account) {
					// Invite to join charity
					$email['subject'] = 'You\'ve been invited to join a charity on DashDonate.org.';
					// Set template name
					$template = 'emails.charity_staff_invite_existing';
				} else {
					// Invite to create account
					$email['subject'] = 'You\'ve been invited to join DashDonate.org.';
					// Set template name
					$template = 'emails.charity_staff_invite_new';
				}
				// Send email
				$send = Mail::send($template, ['email' => $email], function($m) use ($email) {
					// Add sender details
					$m->from('team@dashdonate.org', 'DashDonate.org');
					// Add recipient details
					$m->to($email['recipient'])->subject($email['subject']);
					// Set email priority
					$m->priority(1);
				});
				// Check for failures
				if (Mail::failures()) {
					// Return response to sending
					return json_encode('mail_failed');
				}
				// Return response to sending
				return json_encode('sent');
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/charity/invite-staff', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Check if email is valid
			if (!filter_var($data['recipient_email'], FILTER_VALIDATE_EMAIL)) {
				// Return error
				return json_encode('invalid_recipient');
			}
			// Get charity
			$charity = DB::table('charities')->where(['slug' => $data['charity_slug']])->first();
			// Check if charity was not found
			if (!$charity) {
				// Return error
				return json_encode('no_charity');
			}
			// Ensure that the inviter user is an approved staff member of the charity
			$is_approved_staff = DB::table('charities_staff')->where([
				'charity_id' 			=> $charity->id,
				'user_id' 				=> $data['inviter_user_id'],
				'request_approved'		=> true,
			])->first();
			// Check if staff was not found
			if (!$is_approved_staff) {
				// Return error
				return json_encode('not_staff');
			}
			// Get details of the inviter
			$inviter = DB::table('users')->where(['id' => $data['inviter_user_id']])->first();
			// Search for a DashDonate account for the recipient of the invite
			$recipient_account = DB::table('users')->where(['email' => $data['recipient_email']])->first();
			// Check if recipient is already a DashDonate user
			if ($recipient_account) {
				// Get record if recipient is already a member of staff
				$already_staff = DB::table('charities_staff')->where([
					'charity_id' 			=> $charity->id,
					'user_id' 				=> $recipient_account->id,
					'request_approved' 		=> true,
				])->first();
				// Check if the recipient is already a member of staff
				if ($already_staff) {
					// Return error
					return json_encode('already_staff');
				}
			}
			// Create a random invite token
			$invite_token = sha1(uniqid(sha1($data['recipient_email'].'DashDonate').time()));
			// Record invite in DB
			$invite = DB::table('user_invites')->insert([
				'invite_token'						=> $invite_token,
				'charity_id'						=> $charity->id,
				'email_address'						=> $data['recipient_email'],
				'user_id'							=> @$recipient_account->id,
				'role'								=> 'staff',
				'invite_to_be_representative'		=> false,
			]);
			// Check that the invite was saved
			if ($invite) {
				// Create email data array
				$email = array(
					'recipient'			=> $data['recipient_email'],
					'inviter'			=> $inviter,
					'positive_action'	=> env('FRONTEND_URL').'/invite/charity/'.$invite_token,
				);
				// Check if recipient already has a DashDonate account
				if ($recipient_account) {
					// Invite to join charity
					$email['subject'] = 'You\'ve been invited to join a charity on DashDonate.org.';
					// Set template name
					$template = 'emails.charity_staff_invite_existing';
				} else {
					// Invite to create account
					$email['subject'] = 'You\'ve been invited to join DashDonate.org.';
					// Set template name
					$template = 'emails.charity_staff_invite_new';
				}
				// Send email
				$send = Mail::send($template, ['email' => $email], function($m) use ($email) {
					// Add sender details
					$m->from('team@dashdonate.org', 'DashDonate.org');
					// Add recipient details
					$m->to($email['recipient'])->subject($email['subject']);
					// Set email priority
					$m->priority(1);
				});
				// Check for failures
				if (Mail::failures()) {
					// Return response to sending
					return json_encode('mail_failed');
				}
				// Return response to sending
				return json_encode('sent');
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::get('charity/invite-representative/{invite_token}', function($invite_token) {
		try {
			// Check if invite token was is not blank
			if (strlen(trim($invite_token)) == 0) {
				// Return error
				return json_encode('invalid_token');
			}
			// Get invite data
			$invite = DB::table('user_invites')->where(['invite_token' => $invite_token])->first();
			// Check if invite was found
			if (!$invite) {
				// Return error
				return json_encode('not_found');
			}
			// Check if invite has expired
			if (strtotime($invite->date_added) <  time() - (60*60*(24*5))) {
				// Return error
				return json_encode('expired_date');
			}
			// Check if invite has already been responded to
			if ($invite->request_approved != null) {
				// Return error
				return json_encode('already_handled');
			}
			// // Check if the invite is not for representative role
			// if ($invite->invite_to_be_representative == false) {
			// 	// Return error
			// 	return json_encode('not_representative_invite');
			// }
			// Search for existing DashDonate user
			$existing_user = DB::table('users')->where(['email' => $invite->email_address])->first();
			// Return that the invite is valid and whether or not the user needs to register a new account
			return json_encode(['valid' => true, 'invite_email' => $invite->email_address, 'must_register' => ($existing_user == null)]);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::get('charity/respond-invite-representative/{invite_token}/{response}', function($invite_token, $response) {
		try {
			// Check if invite token was is not blank
			if (strlen(trim($invite_token)) == 0) {
				// Return error
				return json_encode('invalid_token');
			}
			// Get invite data
			$invite = DB::table('user_invites')->where(['invite_token' => $invite_token])->first();
			// Check if invite was found
			if (!$invite) {
				// Return error
				return json_encode('not_found');
			}
			// Check if decision was 'accept'
			if ($response == 'accept') {
				// Update invite record as accepted
				$update = DB::table('user_invites')->where(['id' => $invite->id])->update([
					'request_approved'		=> true,
					'last_updated'			=> date('Y-m-d H:i:s', time()),
				]);
				// Search for existing staff record for the invited user
				$already_staff = DB::table('charities_staff')->where(['charity_id' => $invite->charity_id, 'user_id' => $invite->user_id])->first();
				// Check if user is not a staff member already
				if (!$already_staff) {
					// Get staff that the the user will be added to
					$charity = DB::table('charities')->where(['id' => $invite->charity_id])->first();
					// Get user that has been invited
					$invited_user = DB::table('users')->where(['email' => $invite->email_address])->first();
					// Add user to charity
					$new_charity_member = DB::table('charities_staff')->insert([
						'request_approved'		=> true,
						'charity_id'			=> $invite->charity_id,
						'user_id'				=> $invited_user->id,
					]);
					// Check user staff was added
					if ($new_charity_member) {
						// Return success
						return json_encode(['success' => true, 'charity_slug' => $charity->slug]);
					}
				}
			} else {
				// Update invite record as declined
				$update = DB::table('user_invites')->where(['id' => $invite->id])->update([
					'request_approved'		=> false,
					'last_updated'			=> date('Y-m-d H:i:s', time()),
				]);
				// Respond with true success
				return json_encode(true);
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::get('charity/get-trustees-from-commission/{crn}/', function($crn) {
		try {
			// Check if CRN was is not blank
			if (strlen(trim($crn)) == 0) {
				// Return error
				return json_encode('invalid_crn');
			}
			// Search for this charity on DashDonate records
			$existing_charity = DB::table('charities')->where(['charity_registration_number' => $crn])->first();
			// Check if existing charity was found
			if (!$existing_charity) {
				// Search charity commission to find which commission should be used
				$commission_name = CharityRegister::findRegister($crn);
			} else {
				// Capture commission name from record
				$commission_name = $existing_charity->commission_name;
			}
			// Check if commission_name is not blank
			if (strlen(trim($commission_name)) == 0) {
				// Return error
				return json_encode('commission_not_found');
			}
			// Get trustee data from the commission
			$trustees = CharityRegister::{'getTrusteesInfo_'.$commission_name}($crn);
			// Return data
			return json_encode($trustees);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::get('charity/is-trustee-valid/{charity_slug}/{trustee_number}', function($charity_slug, $trustee_number) {
		try {
			// Get charity on DashDonate records
			$charity = DB::table('charities')->where(['slug' => $charity_slug])->first();
			// Check if charity was not found
			if (!$charity) {
				// Return error
				return json_encode('charity_not_found');
			}
			// Check trustee number is not blank
			if (strlen(trim($trustee_number)) == 0) {
				// Return error
				return json_encode('empty_trustee_number');
			}
			// Capture commission name from record
			$commission_name = $charity->commission_name;
			// Check if commission_name is not blank
			if (strlen(trim($commission_name)) == 0) {
				// Return error
				return json_encode('commission_not_found');
			}
			// Get trustee data from the commission
			$trustee = CharityRegister::{'getTrustee_'.$commission_name}($charity->charity_registration_number, $trustee_number);
			// Check if trustee was found
			if (@sizeof($trustee) == 0) {
				// Return error
				return json_encode('trustee_not_found');
			}
			// Return data
			return json_encode($trustee);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/charity/create-representative', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Get charity
			$charity = DB::table('charities')->where(['slug' => $data['charity_slug']])->first();
			// Check if charity was not found
			if (!$charity) {
				// Return error
				return json_encode('no_charity');
			}
			// Ensure that the representative is an approved staff member of the charity
			$is_approved_staff = DB::table('charities_staff')->where([
				'charity_id' 			=> $charity->id,
				'user_id' 				=> $data['representative_user_id'],
				'request_approved'		=> true,
			])->first();
			// Check if staff was not found
			if (!$is_approved_staff) {
				// Return error
				return json_encode('not_staff');
			}
			// Get trustee data from the commission
			$trustee = CharityRegister::{'getTrustee_'.$charity->commission_name}($charity->charity_registration_number, $data['representative_data']['trustee_id']);
			// Check if trustee was found
			if (@sizeof($trustee) == 0) {
				// Return error
				return json_encode('trustee_not_found');
			}
			// Collect errors
			$form_errors = array();
			// Check if form value
			if (!@$data['representative_data']['legal_firstname'] && @strlen($data['representative_data']['legal_firstname']) > 0) {
				// Add error
				$form_errors['legal_firstname'] = 'A legal first name is required.';
			}
			// Check if form value
			if (!@$data['representative_data']['legal_lastname'] && @strlen($data['representative_data']['legal_lastname']) > 0) {
				// Add error
				$form_errors['legal_lastname'] = 'A legal last name is required.';
			}
			// Check if form value
			if (!@$data['representative_data']['telephone_number'] && @strlen($data['representative_data']['telephone_number']) > 0) {
				// Add error
				$form_errors['telephone_number'] = 'A telephone number is required.';
			} else {
				// Convert to international number
				$data['representative_data']['telephone_number'] = phone_to_international($data['representative_data']['telephone_number']);
			}
			// Check if form value
			if (!@$data['representative_data']['date_of_birth'] && @strlen($data['representative_data']['date_of_birth']) > 0) {
				// Add error
				$form_errors['date_of_birth'] = 'This field is required.';
			} else {
				// Convert to timestamp
				$data['representative_data']['date_of_birth'] = date('Y-m-d H:i:s', strtotime($data['representative_data']['date_of_birth'].' 13:00:00'));
				// Set DOB
				$data['representative_data']['dob'] = date('Y-m-d H:i:s', strtotime($data['representative_data']['date_of_birth']));

			}
			// Check if form value
			if (!@$data['representative_data']['address_line_1'] && @strlen($data['representative_data']['address_line_1']) > 0) {
				// Add error
				$form_errors['address_line_1'] = 'This field is required.';
			}
			// Check if form value
			if (!@$data['representative_data']['address_line_2'] && @strlen($data['representative_data']['address_line_2']) > 0) {
				// Add error
				$form_errors['address_line_2'] = 'This field is required.';
			}
			// Check if form value
			if (!@$data['representative_data']['address_town_city'] && @strlen($data['representative_data']['address_town_city']) > 0) {
				// Add error
				$form_errors['address_town_city'] = 'This field is required.';
			}
			// Check if form value
			if (!@$data['representative_data']['address_postcode'] && @strlen($data['representative_data']['address_postcode']) > 0) {
				// Add error
				$form_errors['address_postcode'] = 'This field is required.';
			}
			// Check if errors were found
			if (sizeof($form_errors) > 0) {
				// Return with errors
				return json_encode($form_errors);
			}
			// Remove existing representative data for this user and charity
			DB::table('charities_representative')->where([
				'charity_id' 	=> $charity->id,
				'user_id'		=> $data['representative_user_id'],
			])->delete();
			// Get representative user record
			$rep_user = DB::table('users')->where(['id' => $data['representative_user_id']])->first();
			// Create fresh record for this representative
			$representative = DB::table('charities_representative')->insert([
				'charity_id' 		=> $charity->id,
				'user_id'			=> $data['representative_user_id'],
				'trustee_number'	=> $data['representative_data']['trustee_id'],
				'legal_firstname'	=> $data['representative_data']['legal_firstname'],
				'legal_lastname'	=> $data['representative_data']['legal_lastname'],
				'date_of_birth'		=> $data['representative_data']['date_of_birth'],
				'dob'				=> $data['representative_data']['dob'],
				'email_address'		=> $rep_user->email,
				'phone_number'		=> $data['representative_data']['telephone_number'],
				'address_line_1'	=> $data['representative_data']['address_line_1'],
				'address_line_2'	=> $data['representative_data']['address_line_2'],
				'address_town_city'	=> $data['representative_data']['address_town_city'],
				'address_postcode'	=> $data['representative_data']['address_postcode'],
			]);
			// Check if the representative was not inserted
			if (!$representative) {
				// Return error
				return json_encode('failed_to_insert_rep');
			}
			// Update all staff in charity that they are not a representative
			DB::table('charities_staff')->where(['charity_id' => $charity->id])->update([
				'is_representative' 	=> false,
				'is_owner' 				=> false,
			]);
			// Update representative staff record
			DB::table('charities_staff')->where(['charity_id' => $charity->id, 'user_id' => $rep_user->id])->update([
				'is_representative' 	=> true,
				'is_owner' 				=> true,
			]);
			// Update charity owner
			DB::table('charities')->where(['id' => $charity->id])->update(['owner_id' => $rep_user->id]);
			// Notify staff of new charity signup
			Notify::newCharitySignup($charity->id);
			// Return success
			return json_encode(['success' => true]);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/charity/refresh-stripe-account', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Get charity
			$charity = DB::table('charities')->where(['slug' => $data['charity_slug']])->first();
			// Check if charity was not found
			if (!$charity) {
				// Return error
				return json_encode('no_charity');
			}
			// Check if the charity needs a Stripe account created
			if ($charity->payout_reference_id == null || $charity->payout_reference_id == '') {
				// Create a Stripe account for the charity
				$charity->payout_reference_id = DD_Stripe::createStripeAccountForCharity($charity, $data['ip']);
			}
			// Return success
			return json_encode(true);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/charity/submit-representative-identity', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Get charity
			$charity = DB::table('charities')->where(['slug' => $data['charity_slug']])->first();
			// Check if charity was not found
			if (!$charity) {
				// Return error
				return json_encode('no_charity');
			}
			// Check if the charity needs a Stripe account created
			if ($charity->payout_reference_id == null || $charity->payout_reference_id == '') {
				// Return error
				return json_encode('no_stripe_account');
			}
			// Submit representative data
			$representative = DD_Stripe::createCharityRepresentativeAccount($charity);
			// Return data
			return json_encode($representative);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/charity/submit-proof-charity-of-address', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Get charity
			$charity = DB::table('charities')->where(['slug' => $data['charity_slug']])->first();
			// Check if charity was not found
			if (!$charity) {
				// Return error
				return json_encode('no_charity');
			}
			// Check if the charity needs a Stripe account created
			if ($charity->payout_reference_id == null || $charity->payout_reference_id == '') {
				// Return error
				return json_encode('no_stripe_account');
			}
			// Submit document
			$document = DD_Stripe::uploadAddressDocumentToCharityAccount($charity);
			// Return data
			return json_encode($document);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::get('/charity/representative-identity-status/{charity_slug}', function(Request $request, $charity_slug) {
		try {
			// Get request data
			$data = $request->all();
			// Get charity
			$charity = DB::table('charities')->where(['slug' => $charity_slug])->first();
			// Check if charity was not found
			if (!$charity) {
				// Return error
				return json_encode('no_charity');
			}
			// Check if the charity needs a Stripe account created
			if ($charity->payout_reference_id == null || $charity->payout_reference_id == '') {
				// Return error
				return json_encode('no_stripe_account');
			}
			// Get status
			$status = DD_Stripe::getStatusOfRepresentativeVerification($charity);
			// Return data
			return json_encode($status);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/charity/update-bank-account', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Get charity
			$charity = DB::table('charities')->where(['slug' => $data['charity_slug']])->first();
			// Check if charity was not found
			if (!$charity) {
				// Return error
				return json_encode('no_charity');
			}
			// Check if the charity needs a Stripe account created
			if ($charity->payout_reference_id == null || $charity->payout_reference_id == '') {
				// Return error
				return json_encode('no_stripe_account');
			}
			// Ensure that the submitting user is the representative of the charity
			$is_representative = DB::table('charities_staff')->where([
				'charity_id' 			=> $charity->id,
				'user_id' 				=> $data['rep_user_id'],
				'request_approved'		=> true,
				'is_representative'		=> true,
			])->first();
			// Check if user is not rep
			if (!$is_representative) {
				// Return error
				return json_encode('not_representative');
			}
			// Remove spaces from sortcode
			$data['sort_code'] = str_replace(' ', '', $data['sort_code']);
			// Check if sortcode is not 6 digits long
			if (strlen($data['sort_code']) != 6) {
				// Return error
				return json_encode('invalid_sortcode');
			}
			// Check if account number is not 8 digits long
			if (strlen($data['account_number']) != 8) {
				// Return error
				return json_encode('invalid_account_number');
			}
			// Submit to Stripe
			$bank_account = DD_Stripe::updateCharityBankAccountDetails($charity, $data['sort_code'], $data['account_number']);
			// Return data
			return json_encode($bank_account);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/charity/update-charity-display-details', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Get charity
			$charity = DB::table('charities')->where(['slug' => $data['charity_slug']])->first();
			// Check if charity was not found
			if (!$charity) {
				// Return error
				return json_encode('no_charity');
			}
			// Ensure that the submitting user is staff of the charity
			$is_admin_staff = DB::table('charities_staff')->where([
				'charity_id' 			=> $charity->id,
				'user_id' 				=> $data['admin_user_id'],
				'request_approved'		=> true,
			])->first();
			// Check if user is not admin
			if (!$is_admin_staff) {
				// Return error
				return json_encode('not_administrator');
			}
			// Get form data
			$form_data = $data['form_data'];
			// Check if logo is empty
			if (!@$form_data['charity_logo_id'] || empty($form_data['charity_logo_id'])) {
				// Return error
				return json_encode('logo_required');
			}
			// Check if slug is empty or is invalid
			if (!@$form_data['charity_slug'] || empty($form_data['charity_slug'])) {
				// Return error
				return json_encode('slug_invalid');
			}
			// Check if slug has changed
			if ($data['charity_slug'] != $form_data['charity_slug']) {
				// Search for if a charity is already using this slug
				$slug_double = DB::table('charities')->where(['slug' => $form_data['charity_slug']])->first();
				// Check if slug is already in use for another charity
				if ($slug_double) {
					// Return error
					return json_encode('slug_in_use');
				} else {
					// Update slug for charity
					DB::table('charities')->where(['id' => $charity->id])->update(['slug' => $form_data['charity_slug']]);
					// Update data record
					$data['charity_slug'] = $form_data['charity_slug'];
				}
			}
			// Update charity details
			$update = DB::table('charities_details')->where(['id' => $charity->id])->update([
				'logo_file_id'				=> @$form_data['charity_logo_id'],
				'display_name'				=> @$form_data['display_name'],
				'display_bio'				=> @$form_data['display_bio'],
				'charity_website'			=> @$form_data['charity_website'],
				'phone_number'				=> @$form_data['phone_number'],
				'charity_email'				=> @$form_data['charity_email'],
				'facebook_handle'			=> @str_replace('@', '', $form_data['facebook_handle']),
				'twitter_handle'			=> @str_replace('@', '', $form_data['twitter_handle']),
				'instagram_handle'			=> @str_replace('@', '', $form_data['instagram_handle']),
				'linkedin_handle'			=> @str_replace('@', '', $form_data['linkedin_handle']),
			]);
			// Check if updated
			if ($update) {
				// Update charity to not needing details reviewed
				DB::table('charities')->where(['slug' => $data['charity_slug']])->update(['needs_details_review' => false]);
			}
			// Return success
			return json_encode(['success' => true, 'slug' => $data['charity_slug']]);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




















	Route::post('/files/save-upload/', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Insert file data into DB
			$image = DB::table('file_uploads')->insertGetId([
				'user_id'	=> $data['user_id'],
				's3_url'	=> $data['path'],
				'filename'	=> $data['file_name'],
				'intent'	=> $data['intent'],
			]);
			// Return file ID
			return json_encode(['id' => $image]);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');














































	Route::get('/user/check-if-exists/{email}', function(Request $request, $email) {
		try {
			// Get request data
			$data = $request->all();
			// Get user
			$user = DB::table('users')->where(['email' => $email, 'is_email_confirmed' => true])->first();
			// Check if user was found
			if ($user) {
				// Return that user exists
				return json_encode(true);
			}
			// Return that user does exist
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		return json_encode(false);
	})->middleware('api_auth');




	Route::post('/user/confirm-email', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Update user record
			$update = DB::table('users')->where(['id' => $data['user_id']])->update([
				'is_email_confirmed'		=> true,
				'email_confirm_code'		=> null,
			]);
			// Check if updated
			if ($update) {
				// Return success
				return json_encode(true);
			}
			// Return failure
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




	Route::post('/user/send-verification-email', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Check if user is in need of being searched
			if ($data['search_user_id'] == true) {
				// Get user
				$user = DB::table('users')->where(['email' => $data['user']])->first();
			} else {
				// Get user
				$user = DB::table('users')->where(['id' => $data['user']])->first();
			}
			// Check if user was found
			if ($user) {
				// Check if user has already passed verification
				if ($user->is_email_confirmed === true) {
					// Return that the user has been successfully confirmed
					return json_encode(true);
				} else {
					// Send email and return whether it was a success or not
					return sendVerificationEmail($user->email, $user->email_confirm_code);
				}
			}
			// Return failure
			return json_encode(false);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




	// Function to send email to user to confirm password
	function sendVerificationEmail($email_address, $code) {
		// Email info
		$email = array(
			'recipient'			=> $email_address,
			'code'				=> $code,
			'subject'			=> 'Confirm your email address.',
		);
		// Send email
		$send = Mail::send('emails.verify_email', ['email' => $email], function($m) use ($email) {
			// Add sender details
			$m->from('team@dashdonate.org', 'DashDonate.org');
			// Add recipient details
			$m->to($email['recipient'])->subject($email['subject']);
			// Set email priority
			$m->priority(1);
		});
		// Check for failures
		if (Mail::failures()) {
			// Return response to sending
			return json_encode('x');
		}
		// Return response to sending
		return json_encode(true);
	}




});




Route::post('/donation/send-reminder-email/', function(Request $request) {
	try {
		// Get task
		$task = DB::table('donations_task_list')->where(['task_token' => $request->get('task_token')])->first();
		// Get user connected to the task
		$user = DB::table('users')->where(['id' => $task->user_id])->first();
		// Send reminder
		Donation::sendDonationReminder($user->email, $task);
		// Return success
		return json_encode(['success' => true]);
	} catch (Exception $e) {
		return json_encode('Line '.$e->getLine().' - Error: '.$e->getMessage());
	}
})->middleware('api_auth');




Route::post('/donation/perform-donation-task/', function(Request $request) {
	try {
		// Get task
		$task = DB::table('donations_task_list')->where(['task_token' => $request->get('task_token')])->first();
		// Get user connected to the task
		$user = DB::table('users')->where(['id' => $task->user_id])->first();
		// Perform off-session donation
		$donate = Donation::processOffSessionDonation($task, $user);
		// Check if donation was successful
		if ($donate === true) {
			// Return success
			return json_encode(['success' => true]);
		} else {
			// Return intent so that it can be processed
			return json_encode(['success' => false, 'error' => $donate]);
		}
	} catch (Exception $e) {
		return json_encode('Line '.$e->getLine().' - Error: '.$e->getMessage());
	}
})->middleware('api_auth');




Route::post('/donation/set-next-donation-task/', function(Request $request) {
	try {
		// Set next task
		$next = setNextTask($request->get('task_token'));
		// Return the next task
		return json_encode($next);
	} catch (Exception $e) {
		return json_encode('Line '.$e->getLine().' - Error: '.$e->getMessage());
	}
})->middleware('api_auth');




function setNextTask($task_token) {
	// Get task
	$task = DB::table('donations_task_list')->where(['task_token' => $task_token])->first();
	// Get user connected to the task
	$user = DB::table('users')->where(['id' => $task->user_id])->first();
	// Create next donation task
	$next = Donation::createNextRepeatDonation($user->stripe_customer_id, $task->charity_id, $user->id, $task->amount, $task->amount_includes_fees, $task->reminder_needed, $task->recurring_interval, $task->recurring_duration, $task->recurring_anchor);
	// Return next
	return $next;
}
