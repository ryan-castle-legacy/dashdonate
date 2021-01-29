<?php

use Illuminate\Http\Request;

// Include the Stripe controller
use \App\Http\Controllers\StripeController as DD_Stripe;
// Include the donation controller
use \App\Http\Controllers\DonationController as Donation;
// Include the error logging controller (to aid finding and fixing bugs)
use \App\Http\Controllers\LogError;
// Include the donation widget controller
use \App\Http\Controllers\DonationWidget as DonationWidget;


use Carbon\Carbon;




Route::group(['middleware' => 'throttle:2400,1'], function() {



	// Create initial intent object
	Route::post('/widget/donation/initialise', function(Request $request) {
		try {
			// Get data
			$data = $request->all();
			// Create and retrieve intent
			$intent = DD_Stripe::createDonationIntentInitial($data['site_id']);
			// Return the intent
			return json_encode($intent);
		} catch (Exception $e) {
			return json_encode('Line '.$e->getLine().' - Error: '.$e->getMessage());
		}
	});





	Route::post('/widget/donation', function(Request $request) {
		try {
			// Get data
			$data = $request->all();


			$is_verified_charity_site = true;


			// Prevent multiple receipt emails
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
			// // Save card
			// $card = DD_Stripe::addCardToUser($stripe_user, $data['stripe_token']);




			// Clear all existing cards for the user
			DD_Stripe::clearExistingCards($stripe_user->id);




			// Check whether SetupIntent is now needed (isn't needed if only one-off payment)
			if ($data['pay_now'] == true && $data['scheduled'] == false && $data['repeat'] == false) {
				// Get card
				$card = DD_Stripe::addCardForPayNow($stripe_user, $data['stripe_token']);
				// Get card ID from intent
				$card_id = $card->id;
			} else {

				// Create SetupIntent for saving and using card
				$card = DD_Stripe::addCardToUser($stripe_user, $data['stripe_token']);

				// // Get card
				// $card = DD_Stripe::getStripeCard($data['setup_intent']);

				// Get card ID from intent
				$card_id = $card->payment_method;


				// Check if all done and needs receipt sent
				if (@$card->status == 'succeeded' && !$receipt_sent) {


					// Save card to user
					$card_save = Donation::savePaymentMethod($user->id, $stripe_user->id, $card->payment_method);


					// Check if whether there is an amount to take today
					if ($data['pay_now'] == true) {
						// Convert pounds to pence
						$amount = intval(floatval($data['amount_pounds_now']) * 100);
						// Calculate fees
						$fees = DD_Stripe::calculateFees($amount);
						// Check if fees are to be added now
						if ($data['pay_fees_now']) {
							// Add fees to amount
							$amount += $fees;
						}
						// Process donation for now
						$donation = Donation::createDonation($stripe_user->id, $data['payment_intent'], $card_id, $charity->id, $user->id, $amount, $fees, $data['pay_fees_now'], $user->email, $user->id);
					}


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


					// Send receipt email
					Donation::sendDonationReceipt($user->email, $data, $charity);
					// Mark as sent
					$receipt_sent = true;
				}


				// Return intent to setup card
				return json_encode(['success' => true, 'setup_intent' => $card]);

			}


			// Save card to user
			$card_save = Donation::savePaymentMethod($user->id, $stripe_user->id, $card_id);


			// Check if whether there is an amount to take today
			if ($data['pay_now'] == true) {
				// Convert pounds to pence
				$amount = intval(floatval($data['amount_pounds_now']) * 100);
				// Calculate fees
				$fees = DD_Stripe::calculateFees($amount);

				// Check if fees are to be added now
				if ($data['pay_fees_now']) {
					// Add fees to amount
					$amount += $fees;
				}
				// Process donation for now
				$donation = Donation::createDonation($stripe_user->id, $data['payment_intent'], $card->id, $charity->id, $user->id, $amount, $fees, $data['pay_fees_now'], $user->email, $user->id);
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
						$amount_scheduled += DD_Stripe::calculateFees($amount_scheduled);
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
						$amount_repeating += DD_Stripe::calculateFees($amount_repeating);
					}
					// Create repeating task
					$task = Donation::createRepeatDonation($stripe_user->id, $charity->id, $user->id, $amount_repeating, $data['pay_fees_scheduled'], $data['futureNotifications'], $data['repeat_interval'], $data['repeat_duration'], $data['repeat_anchor']);
				}


				// Check if receipt email has not been sent already
				if (!$receipt_sent) {
					// Send receipt email
					Donation::sendDonationReceipt($user->email, $data, $charity);
					// Mark as sent
					$receipt_sent = true;
				}


			}


			// Check if all done and needs receipt sent
			if (@$donation->status == 'succeeded' && !$receipt_sent) {
				// Send receipt email
				Donation::sendDonationReceipt($user->email, $data, $charity);
				// Mark as sent
				$receipt_sent = true;
			}


			// Return the intent
			return json_encode(['success' => true, 'intent' => $donation]);
		} catch (Exception $e) {
			return json_encode('Line '.$e->getLine().' - Error: '.$e->getMessage());
		}
	});




	Route::get('/widget/get-intent/{intent_id}', function($intent_id) {
		// Get intent
		$intent = DD_Stripe::get_intent($intent_id);
		// Respond with intent
		return json_encode($intent);
	})->middleware('ajax_auth');




});

















Route::get('/task-runner/get-tasks/', function(Request $request) {
	try {

		// DB::table('cron_tasks')->truncate();

		// Get tasks
		$tasks = DB::table('cron_tasks')->where([
			'active'		=> true,
			'processing'	=> false,
		])->where('date_to_process', '<', Carbon::now()->addDays(1))
		->orderBy('date_to_process', 'ASC')
		->get();




		// Return tasks
		return json_encode($tasks);
	} catch (Exception $e) {
		return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
	}
	return json_encode(false);
})->middleware('api_auth');




Route::get('/task-runner/get-task/{task_token}', function(Request $request, $task_token) {
	try {
		// Get task
		$task = DB::table('cron_tasks')->where(['task_token' => $task_token])->first();
		// Return task
		return json_encode($task);
	} catch (Exception $e) {
		return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
	}
	return json_encode(false);
})->middleware('api_auth');




Route::post('/task-runner/mark-task-as-processing/', function(Request $request) {
	try {
		// Get data
		$task_token = $request->get('task_token');
		// Mark task as processing
		DB::table('cron_tasks')->where([
			'active'			=> true,
			'processing'		=> false,
			'task_token'		=> $task_token,
		])->update([
			'processing' 		=> true,
			'date_processed'	=> date('Y-m-d H:i:s', time()),
			'date_updated'		=> date('Y-m-d H:i:s', time()),
		]);
		// Return success
		return json_encode(true);
	} catch (Exception $e) {
		return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
	}
	return json_encode(false);
})->middleware('api_auth');




Route::post('/task-runner/mark-task-as-done/', function(Request $request) {
	try {
		// Get data
		$task_token = $request->get('task_token');
		// Mark task as done
		return DB::table('cron_tasks')->where(['task_token' => $task_token])->update([
			'active' 			=> false,
			'processing' 		=> false,
			'date_processed'	=> date('Y-m-d H:i:s', time()),
			'date_updated'		=> date('Y-m-d H:i:s', time()),
		]);
	} catch (Exception $e) {
		return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
	}
	return json_encode(false);
})->middleware('api_auth');




Route::post('/task-runner/mark-task-as-needs-further-processing/', function(Request $request) {
	try {
		// Get data
		$task_token = $request->get('task_token');
		// Mark task as needs new further processing
		return DB::table('cron_tasks')->where(['task_token' => $task_token])->update([
			'active' 			=> true,
			'processing' 		=> false,
			'date_updated'		=> date('Y-m-d H:i:s', time()),
		]);
	} catch (Exception $e) {
		return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
	}
	return json_encode(false);
})->middleware('api_auth');




Route::post('/task-runner/send-email-receipt/', function(Request $request) {
	try {
		// Success holding variable
		$success = true;
		// Get task data from request
		$task = $request->get('task');
		// Get task
		$task = DB::table('cron_tasks')->where(['task_token' => $task['task_token']])->first();
		// Get user for task
		$user = DB::table('users')->where(['id' => $task->user_id])->first();
		// Get meta from task
		$taskData = json_decode($task->meta);
		// Get charity for task
		$charity = DB::table('charities')->where(['id' => $task->charity_id])->first();
		// Get charity details for task
		$charity->details = DB::table('charities_details')->where(['charity_id' => $task->charity_id])->first();
		// Check if donation was off-session
		if ($task->task_type == 'donation_receipt_offsession') {
			// Email info
			$email = array(
				'subject'				=> 'Your Donation Receipt',
				'recipient'				=> $user->email,
				'charity'				=> $charity,
				'user'					=> $user,
				'fees'					=> $taskData,
				'positive_action'		=> env('FRONTEND_URL').'/dashboard/donations',
			);
			// Send email
			$send = Mail::send('emails.donations.offSessionDonationReceipt', ['email' => $email], function($m) use ($email) {
				$m->from('noreply@dashdonate.org', 'DashDonate.org');
				$m->to($email['recipient'])->subject($email['subject']);
			});
		} else {
			// Check if the email is a receipt or not (if payment is to be taken now)
			if ($taskData->personaliseNow === true || (!$taskData->personaliseRepeating === true && !$taskData->personaliseScheduled === true)) {
				// Set subject text
				$subject = 'Your Donation Receipt';
			} else {
				// Set subject text
				$subject = 'Your Donation Confirmation';
			}
			// Email info
			$email = array(
				'subject'				=> $subject,
				'recipient'				=> $user->email,
				'taskData'				=> $taskData,
				'charity'				=> $charity,
				'user'					=> $user,
				'positive_action'		=> env('FRONTEND_URL').'/dashboard/donations',
			);
			// Send email
			$send = Mail::send('emails.donations.donationReceipt', ['email' => $email], function($m) use ($email) {
				$m->from('noreply@dashdonate.org', 'DashDonate.org');
				$m->to($email['recipient'])->subject($email['subject']);
			});
		}
		// Check for failures
		if (Mail::failures()) {
			// Set success as false
			$success = false;
		}
		// Check if successfully sent
		if ($success) {
			// Update task as complete
			DB::table('cron_tasks')->where(['task_token' => $task->task_token])->update([
				'active' 			=> false,
				'processing' 		=> false,
				'date_processed'	=> date('Y-m-d H:i:s', time()),
				'date_updated'		=> date('Y-m-d H:i:s', time()),
			]);
		} else {
			// Update task as needs processed as it failed
			DB::table('cron_tasks')->where(['task_token' => $task->task_token])->update([
				'active' 			=> true,
				'processing' 		=> false,
				'fail_count'		=> ($task->fail_count + 1),
				'date_updated'		=> date('Y-m-d H:i:s', time()),
			]);
		}
		// Return result
		return json_encode($success);
	} catch (Exception $e) {
		return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
	}
	return json_encode(false);
})->middleware('api_auth');




Route::post('/task-runner/send-email-donation-reminder/', function(Request $request) {
	try {
		// Success holding variable
		$success = true;
		// Get task data from request
		$task = $request->get('task');
		// Get task
		$task = DB::table('cron_tasks')->where(['task_token' => $task['task_token']])->first();
		// Get user for task
		$user = DB::table('users')->where(['id' => $task->user_id])->first();
		// Get meta from task
		$taskData = json_decode($task->meta);
		// Get charity for task
		$charity = DB::table('charities')->where(['id' => $task->charity_id])->first();
		// Get charity details for task
		$charity->details = DB::table('charities_details')->where(['charity_id' => $task->charity_id])->first();
		// Email info
		$email = array(
			'subject'				=> 'Your Upcoming Donation',
			'recipient'				=> $user->email,
			'taskData'				=> $taskData,
			'charity'				=> $charity,
			'user'					=> $user,
			'positive_action'		=> env('FRONTEND_URL').'/dashboard/donations',
		);
		// Check if scheduled or repeating donation
		if ($task->task_type == 'scheduled_donation') {
			// Get amount and convert to pence
			$amount = intval(floatval($taskData->scheduledAmount) * 100);
			// Check if fees are added on top of donation
			if ($taskData->scheduledPayFees === true) {
				// Get fees object for this donation
				$fees = DD_Stripe::calculateFeesData($amount, 'normal');
			} else {
				// Get fees object for this donation
				$fees = DD_Stripe::calculateFeesData($amount, 'none');
			}
		} else {
			// Get amount and convert to pence
			$amount = intval(floatval($taskData->repeatingAmount) * 100);
			// Check if fees are added on top of donation
			if ($taskData->repeatingPayFees === true) {
				// Get fees object for this donation
				$fees = DD_Stripe::calculateFeesData($amount, 'normal');
			} else {
				// Get fees object for this donation
				$fees = DD_Stripe::calculateFeesData($amount, 'none');
			}
		}
		// Add fee object to email object
		$email['fees'] = $fees;
		// Send email
		$send = Mail::send('emails.donations.donationReminder', ['email' => $email], function($m) use ($email) {
			$m->from('noreply@dashdonate.org', 'DashDonate.org');
			$m->to($email['recipient'])->subject($email['subject']);
		});
		// Check for failures
		if (Mail::failures()) {
			// Set success as false
			$success = false;
		}
		// Check if successfully sent
		if ($success) {
			// Update task as notification sent
			return DB::table('cron_tasks')->where(['task_token' => $task->task_token])->update([
				'reminder_needed' 	=> false,
				'reminder_sent' 	=> true,
				'date_updated'		=> date('Y-m-d H:i:s', time()),
			]);
		} else {
			// Update task as needs processed still
			return DB::table('cron_tasks')->where(['task_token' => $task->task_token])->update([
				'reminder_needed' 	=> true,
				'reminder_sent' 	=> false,
				'fail_count'		=> ($task->fail_count + 1),
				'date_updated'		=> date('Y-m-d H:i:s', time()),
			]);
		}
		// Return result
		return json_encode($success);
	} catch (Exception $e) {
		return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
	}
	return json_encode(false);
})->middleware('api_auth');




Route::post('/task-runner/process-off-session-donation/', function(Request $request) {
	try {
		// Success holding variable
		$success = true;
		// Get task data from request
		$task = $request->get('task');
		// Get task
		$task = DB::table('cron_tasks')->where(['task_token' => $task['task_token']])->first();
		// Get user for task
		$user = DB::table('users')->where(['id' => $task->user_id])->first();
		// Get meta from task
		$taskData = json_decode($task->meta);
		// Get charity for task
		$charity = DB::table('charities')->where(['id' => $task->charity_id])->first();
		// Get charity details for task
		$charity->details = DB::table('charities_details')->where(['charity_id' => $task->charity_id])->first();
		// Check variable
		$feesPaid = false;
		// Check which amount is to be taken
		if ($task->task_type == 'scheduled_donation') {
			// Get amount and convert to pence
			$amount = intval(floatval($taskData->scheduledAmount) * 100);
			// Check if fees are added on top of donation
			if ($taskData->scheduledPayFees === true) {
				// Get fees object for this donation
				$fees = DD_Stripe::calculateFeesData($amount, 'normal');
				// Mark as fees paid
				$feesPaid = true;
			} else {
				// Get fees object for this donation
				$fees = DD_Stripe::calculateFeesData($amount, 'none');
			}
		} elseif ($task->task_type == 'repeating_donation') {
			// Get amount and convert to pence
			$amount = intval(floatval($taskData->repeatingAmount) * 100);
			// Check if fees are added on top of donation
			if ($taskData->repeatingPayFees === true) {
				// Get fees object for this donation
				$fees = DD_Stripe::calculateFeesData($amount, 'normal');
				// Mark as fees paid
				$feesPaid = true;
			} else {
				// Get fees object for this donation
				$fees = DD_Stripe::calculateFeesData($amount, 'none');
			}
		}
		// Process off-session donation
		$donation = DonationWidget::processOffSessionDonation($fees, $feesPaid, $charity, $user);
		// Switch status of the donation
		switch ($donation->status) {
			case 'succeeded':
				// Set task of receipt email
				DonationWidget::setOffSessionReceiptTask($fees, $charity, $user);
				// Update task as donation taken
				return DB::table('cron_tasks')->where(['task_token' => $task->task_token])->update([
					'active' 			=> false,
					'processing' 		=> false,
					'date_processed'	=> date('Y-m-d H:i:s', time()),
					'date_updated'		=> date('Y-m-d H:i:s', time()),
				]);
			break;
			default:
				// Set task of authorisation email
				DonationWidget::setOffSessionAuthoriseTask($task, $fees, $charity, $user, $donation);
				// Update task as donation authorisation has been sent
				return DB::table('cron_tasks')->where(['task_token' => $task->task_token])->update([
					'active' 			=> true,
					'processing' 		=> true,
					'auth_req_sent' 	=> true,
					'date_updated'		=> date('Y-m-d H:i:s', time()),
				]);
			break;
		}
		// Return result
		return json_encode($donation);
	} catch (Exception $e) {
		return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
	}
	return json_encode(false);
})->middleware('api_auth');




Route::post('/task-runner/send-email-off-session-auth/', function(Request $request) {
	try {
		// Success holding variable
		$success = true;
		// Get task data from request
		$task = $request->get('task');
		// Get task
		$task = DB::table('cron_tasks')->where(['task_token' => $task['task_token']])->first();
		// Get user for task
		$user = DB::table('users')->where(['id' => $task->user_id])->first();
		// Get meta from task
		$taskData = json_decode($task->meta);
		// Get charity for task
		$charity = DB::table('charities')->where(['id' => $task->charity_id])->first();
		// Get charity details for task
		$charity->details = DB::table('charities_details')->where(['charity_id' => $task->charity_id])->first();
		// Email info
		$email = array(
			'subject'				=> 'Your Donation Needs Authorised',
			'recipient'				=> $user->email,
			'charity'				=> $charity,
			'user'					=> $user,
			'fees'					=> $taskData->fees,
			'positive_action'		=> env('FRONTEND_URL').'/donation/confirmation/'.$task->task_token,
		);
		// Send action email
		$send = Mail::send('emails.donations.offSessionDonationAuthorise', ['email' => $email], function($m) use ($email) {
			$m->from('noreply@dashdonate.org', 'DashDonate.org');
			$m->to($email['recipient'])->subject($email['subject']);
		});
		// Check for failures
		if (Mail::failures()) {
			// Set success as false
			$success = false;
		}
		// Check if successfully sent
		if ($success) {
			// Update task as complete
			DB::table('cron_tasks')->where(['task_token' => $task->task_token])->update([
				'active' 			=> false,
				'processing' 		=> false,
				'date_processed'	=> date('Y-m-d H:i:s', time()),
				'date_updated'		=> date('Y-m-d H:i:s', time()),
			]);
		} else {
			// Update task as needs processed as it failed
			DB::table('cron_tasks')->where(['task_token' => $task->task_token])->update([
				'active' 			=> true,
				'processing' 		=> false,
				'fail_count'		=> ($task->fail_count + 1),
				'date_updated'		=> date('Y-m-d H:i:s', time()),
			]);
		}
		// Return result
		return json_encode($success);
	} catch (Exception $e) {
		return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
	}
	return json_encode(false);
})->middleware('api_auth');




Route::get('/task-runner/get-task-for-authorisation/{task_token}/{user_id}', function(Request $request, $task_token, $user_id) {
	try {
		// Get task
		$task = DB::table('cron_tasks')->where(['task_token' => $task_token, 'user_id' => $user_id])->first();
		// Decode meta data
		$task->meta = json_decode($task->meta);
		// Get original task
		$task->original = DB::table('cron_tasks')->where(['task_token' => $task->meta->task->task_token, 'active' => true])->first();
		// Check if original task is active
		if ($task->original->active == true) {
			// Get PaymentIntent
			$task->intent = DD_Stripe::getPaymentIntent($task->meta->intent->id);
			// Check if intent was found and if it's already successful
			if ($task->intent->status == 'succeeded') {
				// Set original task as done in database
				DB::table('cron_tasks')->where([
					'task_token' 	=> $task->meta->task->task_token
				])->update([
					'active' 		=> true,
					'processing' 	=> true,
				]);
				// Set original task as done in object
				$task->original->active = false;
				$task->original->processing = false;
			}
			// Get charity for task
			$task->charity = DB::table('charities')->where(['id' => $task->charity_id])->first();
			// Get charity details for task
			$task->charity->details = DB::table('charities_details')->where(['charity_id' => $task->charity_id])->first();
			// Set commission name
			switch ($task->charity->commission_name) {
				case 'englandWales':
					$task->charity->details->commission_name = 'England and Wales';
				break;
			}
			// Get charity logo
			$task->charity->details->logo = DB::table('file_uploads')->where(['id' => $task->charity->details->logo_file_id])->first();
			// Get default payment method
			$task->default_card = DB::table('users_payment_sources')->where(['user_id' => $task->user_id])->first();
		}
		// Return task
		return json_encode($task);
	} catch (Exception $e) {
		return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
	}
	return json_encode(false);
})->middleware('api_auth');








































// Part of widget v2 functionality
Route::post('/widget/process-payment/', function(Request $request) {
	try {
		// Get data
		$data = $request->all();
		// Handle data
		$response = DonationWidget::processPayment($data);
		// Return response
		return json_encode($response);
	} catch (Exception $e) {
		return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
	}
	return json_encode(false);
})->middleware('api_auth');




// Part of widget v2 functionality
Route::post('/widget/create-session-record/', function(Request $request) {
	try {
		// Get data
		$data = $request->all();
		// Handle data
		$response = DonationWidget::createSessionRecord($data);
		// Return response
		return json_encode($response);
	} catch (Exception $e) {
		return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
	}
	return json_encode(false);
})->middleware('api_auth');

































// Part of widget v2 functionality
Route::post('/widget/authorise-off-session-donation/', function(Request $request) {
	try {
		// Get data
		$data = $request->all();
		// Handle data
		$response = DonationWidget::processOffSessionPaymentAuth($data);
		// Return response
		return json_encode($response);
	} catch (Exception $e) {
		return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
	}
	return json_encode(false);
})->middleware('api_auth');
