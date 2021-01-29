<?php

namespace App\Http\Controllers;

// Include the error logging controller (to aid finding and fixing bugs)
use \App\Http\Controllers\LogError;
use \App\Http\Controllers\StripeController;


use Illuminate\Http\Request;
use DB;
use Hash;
use DateTime;

class DonationWidget extends Controller
{


	// Create record for a widget session
	public static function createSessionRecord($data) {
		// Insert details
		$insert = DB::table('widget_sessions')->insert([
			'session_token'			=> $data['session_token'],
			'session_start'			=> $data['session_start'],
			'host_website'			=> $data['host_website'],
			'host_webpage'			=> $data['host_webpage'],
			'host_webpage_title'	=> $data['host_webpage_title'],
			'referer_url'			=> $data['referer_url'],
			'user_agent'			=> $data['user_agent'],
			'csrf_token'			=> $data['csrf_token'],
			'user_id'				=> $data['user_id'],
			'charity_id'			=> $data['charity_id'],
			'date_created'			=> date('Y-m-d H:i:s e', time()),
			'date_updated'			=> date('Y-m-d H:i:s e', time()),
		]);
		// Check if successfully inserted
		if ($insert) {
			// Return success
			return true;
		}
		// Return error
		return false;
	}




	// Handle request for taking payment
	public static function processPayment($data) {
		// Check that session exists
		$session = DB::table('widget_sessions')->where(['session_token' => $data['session']['session']['token'], 'active' => true])->first();
		// Check if session was found
		if (!$session) {
			// Return error message
			return array('error' => 'invalid_session');
		} else {
			// Get data about the charity being donated to
			$charity = DB::table('charities')->where(['id' => $session->charity_id])->first();
			// Check if user is signed in
			if (!is_null($session->user_id)) {
				// Get donor user record
				$user = DB::table('users')->where(['id' => $session->user_id])->first();
				// Set email address in data array
				$data['emailAddress'] = $user->email;
			}
			// Get Stripe customer account for the donor (by email address) - An account will be created if one does not exist already.
			$customer = StripeController::getDonorStripeCustomer($data['emailAddress']);
			// Check if the customer record failed to be created
			if (!$customer) {
				// Return error
				return json_encode(['error' => 'failed_to_create_customer']);
			}
			// Get donor user record
			$user = DB::table('users')->where(['email' => $data['emailAddress']])->first();
			// Update session with donor's user ID
			DB::table('widget_sessions')->where(['session_token' => $data['session']['session']['token']])->update([
				'user_id'				=> $user->id,
				'date_updated'			=> date('Y-m-d H:i:s e', time()),
			]);


			// Check if SetupIntent needs processed
			if ($data['SetupIntent'] != false) {
				// Check if not succeeded
				if ($data['SetupIntent']['status'] == 'succeeded') {
					// Set paymentMethod as default source for customer
					$customer = StripeController::setDonorDefaultSource($user, $data['SetupIntent']['payment_method']);
				} else {
					// Send back with error
					return array('error' => 'unauthorised_card');
				}
			} else {
				// Check if card needs to be added to customer account
				if (!$data['usingSavedPaymentMethod'] === true) {
					// Create SetupIntent for saving card to customer account
					$intent = StripeController::processCardToken($customer, $data['newPaymentMethodToken']);
					// Check if intent status is 'succeeded'
					if ($intent->status == 'succeeded') {
						// Set paymentMethod as default source for customer
						$customer = StripeController::setDonorDefaultSource($user, $intent->payment_method);
					} else {
						// Return intent to do next action
						return array('intent' => array('type' => 'SetupIntent', 'data' => $intent));
					}
				}
			}


			// Get payment method for donor
			$paymentMethod = StripeController::getDonorDefaultSource($user);


			// Check if PaymentIntent needs processed
			if ($data['PaymentIntent'] != false) {
				// Check if not succeeded
				if ($data['PaymentIntent']['status'] != 'succeeded') {
					// Send back with error
					return array('error' => 'unauthorised_payment');
				}
			} else {
				// Check if payment is to be taken now
				if ($data['personaliseNow'] === true || (!$data['personaliseRepeating'] === true && !$data['personaliseScheduled'] === true)) {
					// Take donation now
					$donation = DonationWidget::takeDonationNow($data, $charity, $user, $customer, $paymentMethod);
					// Check if not successful intent
					if (!isset($donation['success'])) {
						// Check if intent or error
						if (@$donation['intent']) {
							// Return data
							return array('intent' => array('type' => 'PaymentIntent', 'data' => $donation));
						} else {
							// Return data to handle errors or the next steps for a PaymentIntent
							return $donation;
						}
					}
				}
			}


			// Check if scheduled payment is to be set up
			if ($data['personaliseScheduled'] === true) {
				// Create a scheduled donation
				$scheduled = DonationWidget::createScheduledDonation($data, $charity, $user, $customer, $paymentMethod);
			}


			// Check if scheduled payment is to be set up
			if ($data['personaliseRepeating'] === true) {
				// Create a repeating donation
				$repeating = DonationWidget::createRepeatingDonation($data, $charity, $user, $customer, $paymentMethod);
			}


			// Set up sending of the receipt
			DonationWidget::setReceiptTask($data, $charity, $user);
			// Make session inactive as it has completed donation
			$session = DB::table('widget_sessions')->where([
				'session_token' 	=> $session->session_token
			])->update([
				'active' 			=> false,
			]);
			// Return success
			return array('success' => true);
		}
	}




	// Handle request for taking payment
	public static function processOffSessionPaymentAuth($data) {
		// Get task
		$task = DB::table('cron_tasks')->where(['task_token' => $data['task_token'], 'user_id' => $data['user_id']])->first();
		// Decode meta data
		$task->meta = json_decode($task->meta);
		// Get original task
		$task->original = DB::table('cron_tasks')->where(['task_token' => $task->meta->task->task_token, 'active' => true])->first();
		// Check if original task is active
		if ($task->original->active == true) {
			// Get the user
			$user = DB::table('users')->where(['id' => $data['user_id']])->first();
			// Get the charity
			$charity = DB::table('charities')->where(['id' => $task->meta->task->charity_id])->first();


			// Check if new card needs to be card set up
			if ($data['card_token'] != null && $data['card_token'] != '' && $data['card_token'] != 'false') {
				// Get Stripe customer object
				$customer = StripeController::getDonorStripeCustomer($user->email);
				// Create SetupIntent for saving card to customer account
				$intent = StripeController::processCardToken($customer, $data['card_token']);
				// Check if intent status is 'succeeded'
				if ($intent->status == 'succeeded') {
					// Set paymentMethod as default source for customer
					$customer = StripeController::setDonorDefaultSource($user, $intent->payment_method);
				} else {
					// Return intent to do next action
					return json_encode(array('success' => false, 'intent' => $intent));
				}
			}


			// Check if intent is not in meta
			if ($data['paymentIntent'] != null && $data['paymentIntent'] != '') {
				// Overwrite intent ID
				$task->meta->intent->id = $data['paymentIntent'];
				// Get PaymentIntent
				$task->intent = StripeController::getPaymentIntent($task->meta->intent->id);
			} else {
				// Get PaymentIntent
				$task->intent = StripeController::getPaymentIntent($task->meta->intent->id);
				// Create clone of off-session intent for on-session authentication
				$task->intent = StripeController::clonePaymentIntent($task->intent, $user->id, $task->original->charity_id);
			}


			// Handle intent
			$task->intent = DonationWidget::handleOffSessionPaymentIntent($task->intent, $data, $user, $charity, $task);
			// Return intent
			return json_encode($task->intent);
		}
	}




	// Handle off-session payment intents
	public static function handleOffSessionPaymentIntent($intent, $data, $user, $charity, $task) {
		// Switch status of intent
		switch ($intent->status) {
			case 'requires_payment_method':
				// Get payment method for donor
				$paymentMethod = StripeController::getDonorDefaultSource($user);
				// Set source for intent
				$newIntent = StripeController::updatePaymentIntentSource($intent->id, $paymentMethod);
				// Return for re-submission
				return DonationWidget::handleOffSessionPaymentIntent($newIntent, $data, $user, $charity, $task);
			break;
			case 'requires_action':

				return array('success' => false, 'intent' => $intent);

			break;
			case 'succeeded':
				// Update donation status as succeeded
				DB::table('donations')->where(['paymentIntent_id' => $intent->id])->update([
					'payment_status' 	=> 'succeeded',
					'date_taken'		=> date('Y-m-d H:i:s', time()),
				]);
				// Set task of receipt email
				DonationWidget::setOffSessionReceiptTask($task->meta->fees, $charity, $user);
				// Update task as donation taken
				DB::table('cron_tasks')->where(['task_token' => $data['task_token']])->update([
					'active' 			=> false,
					'processing' 		=> false,
					'date_processed'	=> date('Y-m-d H:i:s', time()),
					'date_updated'		=> date('Y-m-d H:i:s', time()),
				]);
				// Update original task as donation taken
				DB::table('cron_tasks')->where(['id' => $task->original->id])->update([
					'active' 			=> false,
					'processing' 		=> false,
					'date_processed'	=> date('Y-m-d H:i:s', time()),
					'date_updated'		=> date('Y-m-d H:i:s', time()),
				]);
				// Return success
				return array('success' => true);
			break;
		}

		return $intent;
	}




	// Schedule receipt email
	public static function setReceiptTask($data, $charity, $user) {
		// Create task in cron task list table
		$task = DB::table('cron_tasks')->insertGetId([
			'task_token'		=> 'ddtt_'.sha1('receipt-task'.sha1(uniqid().rand()).'DashDonate.org'),
			'date_to_process'	=> date('Y-m-d H:i:s', time()),
			'date_created'		=> date('Y-m-d H:i:s', time()),
			'task_type'			=> 'donation_receipt',
			'user_id'			=> $user->id,
			'charity_id'		=> $charity->id,
			'meta'				=> json_encode($data),
			'reminder_needed'	=> false,
		]);
		// Return ID of task
		return $task;
	}




	// Take a donation now
	public static function takeDonationNow($data, $charity, $user, $customer, $paymentMethod) {
		// Default stage prefix
		$stagePrefix = 'cover';
		// Check check whether cover stage values is to be used or the payNow stage values
		if ($data['personaliseNow'] === true) {
			// Set prefix
			$stagePrefix = 'personaliseNow';
		}
		// Get amount and convert to pence
		$amount = intval(floatval($data[$stagePrefix.'Amount']) * 100);
		// Check if fees are added on top of donation
		if ($data[$stagePrefix.'PayFees'] === true) {
			// Get fees object for this donation
			$fees = StripeController::calculateFeesData($amount, 'normal');
		} else {
			// Get fees object for this donation
			$fees = StripeController::calculateFeesData($amount, 'none');
		}
		// Take donation now and return result
		return StripeController::takeDonationNow($data, $charity, $user, $customer, $fees, $stagePrefix, $paymentMethod);
	}




	// Create a scheduled donation
	public static function createScheduledDonation($data, $charity, $user, $customer, $paymentMethod) {
		// Get amount and convert to pence
		$amount = intval(floatval($data['scheduledAmount']) * 100);
		// Check if fees are added on top of donation
		if ($data['scheduledPayFees'] === true) {
			// Get fees object for this donation
			$fees = StripeController::calculateFeesData($amount, 'normal');
		} else {
			// Get fees object for this donation
			$fees = StripeController::calculateFeesData($amount, 'none');
		}
		// Create token for task group
		$taskGroupToken = 'ddtg_'.sha1('donation-group'.sha1(time().rand()).'DashDonate.org');
		// Check if annual donations
		if ($data['scheduledAnnual'] == true) {
			// Set number of loop iterations
			$iterations = 25;
		} else {
			$iterations = 1;
		}
		// Holder for dates to take donations
		$donations = array();
		// Generate list of donation tasks
		for ($i = 0; $i < $iterations; $i++) {
			// Create new donation data array
			$donations[$i] = array(
				'groupToken'		=> $taskGroupToken,
				'taskToken'			=> 'ddtt_'.sha1('donation-task'.sha1(uniqid().$taskGroupToken.rand()).'DashDonate.org'),
				'dateToProcess'		=> null,
				'taskId'			=> null,
			);
			// Check if first occurrence
			if ($i == 0) {
				// Get date for donations
				$donations[$i]['dateToProcess'] = date('Y-m-d H:i:s', strtotime($data['scheduledDate']) + 60*60*12);
			} else {
				// Generate next date
				$donations[$i]['dateToProcess'] = DonationWidget::getRepeatingDonationNextOccurrence('years', null, null, strtotime($donations[$i - 1]['dateToProcess']));
			}
			// Create task in cron task list table
			$donations[$i]['taskId'] = DB::table('cron_tasks')->insertGetId([
				'task_token'		=> $donations[$i]['taskToken'],
				'task_group_token'	=> $taskGroupToken,
				'date_to_process'	=> $donations[$i]['dateToProcess'],
				'date_created'		=> date('Y-m-d H:i:s', time()),
				'task_type'			=> 'scheduled_donation',
				'user_id'			=> $user->id,
				'charity_id'		=> $charity->id,
				'meta'				=> json_encode($data),
				'reminder_needed'	=> $data['scheduledNotify'],
			]);
		}
		// Return donations
		return $donations;
	}




	// Create a repeating donation
	public static function createRepeatingDonation($data, $charity, $user, $customer, $paymentMethod) {
		// Get amount and convert to pence
		$amount = intval(floatval($data['repeatingAmount']) * 100);
		// Check if fees are added on top of donation
		if ($data['repeatingPayFees'] === true) {
			// Get fees object for this donation
			$fees = StripeController::calculateFeesData($amount, 'normal');
		} else {
			// Get fees object for this donation
			$fees = StripeController::calculateFeesData($amount, 'none');
		}
		// Create token for task group
		$taskGroupToken = 'ddtg_'.sha1('donation-group'.sha1(time().rand()).'DashDonate.org');
		// Holder for dates to take donations
		$donations = array();
		// Generate list of future tasks
		for ($i = 0; $i < 100; $i++) {
			// Create new donation data array
			$donations[$i] = array(
				'groupToken'		=> $taskGroupToken,
				'taskToken'			=> 'ddtt_'.sha1('donation-task'.sha1(uniqid().$taskGroupToken.rand()).'DashDonate.org'),
				'dateToProcess'		=> null,
				'taskId'			=> null,
			);
			// Check if first occurrence
			if ($i == 0) {
				// Get first date for donations
				$donations[$i]['dateToProcess'] = DonationWidget::getRepeatingDonationNextOccurrence($data['repeatingDuration'], $data['repeatingAnchor'], $data['repeatingInterval'], false);
			} else {
				// Generate next date
				$donations[$i]['dateToProcess'] = DonationWidget::getRepeatingDonationNextOccurrence($data['repeatingDuration'], $data['repeatingAnchor'], $data['repeatingInterval'], strtotime($donations[$i - 1]['dateToProcess']));
			}
			// Create task in cron task list table
			$donations[$i]['taskId'] = DB::table('cron_tasks')->insertGetId([
				'task_token'		=> $donations[$i]['taskToken'],
				'task_group_token'	=> $taskGroupToken,
				'date_to_process'	=> $donations[$i]['dateToProcess'],
				'date_created'		=> date('Y-m-d H:i:s', time()),
				'task_type'			=> 'repeating_donation',
				'user_id'			=> $user->id,
				'charity_id'		=> $charity->id,
				'meta'				=> json_encode($data),
				'reminder_needed'	=> $data['repeatingNotify'],
			]);
		}
		// Return donations
		return $donations;
	}




	// Work out next instance of a donation
	public static function getRepeatingDonationNextOccurrence($duration, $anchor, $interval, $previousOccurrence) {
		// Switch the duration string
		switch ($duration) {
			case 'years':
				// Add 1 year to give next occurrence date
				$date_to_process = date('Y-m-d H:i:s', strtotime('+1 year', $previousOccurrence));
			break;
			case 'months':
				// Check if this is the first occurrence
				if ($previousOccurrence == false) {
					// Check if anchor is last of month
					if (substr($anchor, strlen('month-')) == 'last') {
						// Check if today is the last day of the month
						if (strtotime('last day of this month') == strtotime(date('Y-m-d', time()))) {
							// Set to last day of next month
							$date_to_process = date('Y-m-d H:i:s', strtotime('last day of next month 12:00'));
						} else {
							// Set to last day of this month
							$date_to_process = date('Y-m-d H:i:s', strtotime('last day of this month 12:00'));
						}
					} else {
						// Check if the Xth of this month is in the future
						if (strtotime(date('Y-m-'.substr($anchor, strlen('month-')), time())) > strtotime(date('Y-m-d', time()))) {
							// Get next anchor by date
							$date_to_process = date('Y-m-'.substr($anchor, strlen('month-')), time());
						} else {
							// Get next anchor by date
							$date_to_process = date('Y-m-d', strtotime(date('Y-m-'.substr($anchor, strlen('month-')), time()).' +1 month'));
						}
						// Set to mid-day of the date to process
						$date_to_process = date('Y-m-d H:i:s', strtotime($date_to_process) + 60*60*12);
					}
				} else {
					// Check if anchor is last of month
					if (substr($anchor, strlen('month-')) == 'last') {
						// Set start on the month
						$date_to_process = date('Y-m-'.'01'.' H:i:s', $previousOccurrence);
						// Add months
						$date_to_process = date('Y-m-'.'01'.' H:i:s', strtotime('+'.$interval.' months', strtotime($date_to_process)));
						// Switch month
						switch (date('n', strtotime($date_to_process))) {
							case '1': case '3': case '5': case '7': case '8': case '10': case '12':
								$date_to_process = str_replace('-01 ', '-31 ', $date_to_process);
							break;
							case '2':
								$date_to_process = str_replace('-01 ', '-28 ', $date_to_process);
							break;
							case '4': case '6': case '9': case '11':
								$date_to_process = str_replace('-01 ', '-30 ', $date_to_process);
							break;
						}
					} else {
						// Add on months to the last occurrence
						$date_to_process = date('Y-m-d H:i:s', strtotime('+'.$interval.' months', $previousOccurrence));
					}
				}
			break;
			case 'weeks':
				// Check if this is the first occurrence
				if ($previousOccurrence == false) {
					// Set options for days of week
					$daysOfWeek = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
					// Create timestamp for the anchor day (will be midday on the anchor date)
					$date_to_process = date('Y-m-d H:i:s', strtotime('next '.$daysOfWeek[substr($anchor, strlen('week-'))]) + 60*60*12);
				} else {
					// Add 7 days
					$date_to_process = date('Y-m-d H:i:s', strtotime('+'.(7 * intval($interval)).' days ', $previousOccurrence));
				}
			break;
		}
		// Return date to process
		return $date_to_process;
	}




	// Process an off-session donation
	public static function processOffSessionDonation($fees, $feesPaid, $charity, $user) {
		// Get customer record
		$customer = StripeController::getDonorStripeCustomer($user->email);
		// Get payment method
		$paymentMethod = StripeController::getDonorDefaultSource($user);
		// Take donation and return result
		return StripeController::processOffSessionDonation($charity, $user, $customer, $paymentMethod, $fees, $feesPaid);
	}




	// Send receipt email for an off-session donation
	public static function setOffSessionReceiptTask($fees, $charity, $user) {
		// Create task in cron task list table
		$task = DB::table('cron_tasks')->insertGetId([
			'task_token'		=> 'ddtt_'.sha1('receipt-task'.sha1(uniqid().rand()).'DashDonate.org'),
			'date_to_process'	=> date('Y-m-d H:i:s', time()),
			'date_created'		=> date('Y-m-d H:i:s', time()),
			'task_type'			=> 'donation_receipt_offsession',
			'user_id'			=> $user->id,
			'charity_id'		=> $charity->id,
			'meta'				=> json_encode($fees),
			'reminder_needed'	=> false,
		]);
		// Return ID of task
		return $task;
	}




	// Send authorisation email for an off-session donation
	public static function setOffSessionAuthoriseTask($task, $fees, $charity, $user, $intent) {
		// Create task in cron task list table
		$task = DB::table('cron_tasks')->insertGetId([
			'task_token'		=> 'ddtt_'.sha1('auth-task'.sha1(uniqid().rand()).'DashDonate.org'),
			'date_to_process'	=> date('Y-m-d H:i:s', time()),
			'date_created'		=> date('Y-m-d H:i:s', time()),
			'task_type'			=> 'donation_authorise_offsession',
			'user_id'			=> $user->id,
			'charity_id'		=> $charity->id,
			'meta'				=> json_encode(array('fees' => $fees, 'task' => $task, 'intent' => $intent)),
			'reminder_needed'	=> false,
		]);
		// Return ID of task
		return $task;
	}




}
