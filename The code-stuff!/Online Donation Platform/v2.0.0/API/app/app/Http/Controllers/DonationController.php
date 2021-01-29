<?php

namespace App\Http\Controllers;

// Include the error logging controller (to aid finding and fixing bugs)
use \App\Http\Controllers\LogError;
use \App\Http\Controllers\StripeController;


use Illuminate\Http\Request;
use DB;
use Mail;
use Hash;

class DonationController extends Controller
{


	public static function savePaymentMethod($user_id, $stripe_customer_id, $card_id) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));


			// Check if card or PaymentMethod
			if (strpos($card_id, 'card_') === 0) {
				// Retrieve Card from Stripe
				$card = \Stripe\Customer::retrieveSource($stripe_customer_id, $card_id);
				// Create stored ID variable
				$stored_id = $card->id;
			} else {
				// Retrieve PaymentMethod from Stripe
				$method = \Stripe\PaymentMethod::retrieve($card_id);
				// Check if found
				if ($method) {
					// Create stored ID variable
					$stored_id = $method->id;
					// Extract card data
					$card = $method->card;
				}
			}


			// Check if data was found
			if ($card) {
				// Remove existing cards
				DB::table('users_payment_sources')->where(['user_id' => $user_id])->delete();
				// Save card for user
				DB::table('users_payment_sources')->insert([
					'user_id'				=> $user_id,
					'stripe_source_id'		=> $stored_id,
					'expiry_date'			=> date('Y-m-d H:i:s', strtotime($card->exp_year.'-'.$card->exp_month.'-1')),
					'last_four_digits'		=> $card->last4,
					'brand'					=> $card->brand,
				]);
				// Return success
				return $card;
			}
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




	public static function processAuthOfOffSessionDonation($user, $task, $charity) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Get donor's Stripe customer record
			$customer = \Stripe\Customer::retrieve($user->stripe_customer_token);
			// Check if there is not a default source setup
			if (!@$customer->invoice_settings->default_payment_method) {
				// Get customer's cards
				$cards = \Stripe\PaymentMethod::all([
					'customer' 		=> $user->stripe_customer_token,
					'type'			=> 'card',
				]);
				// Check if cards were returned
				if ($cards && @sizeof($cards->data) > 0) {
					// Get card
					$card = \Stripe\PaymentMethod::retrieve($cards->data[0]->id);
					// Set card as default source for donor
					$card->attach(['customer' => $user->stripe_customer_token]);
				}
				// Get refreshed customer record for the donor
				$customer = \Stripe\Customer::retrieve($user->stripe_customer_token);
			}


			// Calculate fees
			$fee_amounts = StripeController::calculateFees($task->amount);
			// Create payment intent
			$intent = \Stripe\PaymentIntent::create([
				'customer'					=> $customer->id,
				'amount'					=> intval($task->amount),
				'currency'					=> 'gbp',
				'confirm'					=> true,
				'off_session'				=> false,
				'metadata'					=> array(
					'email'						=> $user->id,
					'charity_id'				=> $task->charity_id,
					'fees_included'				=> $task->amount_includes_fees,
				),
				'payment_method'			=> $customer->invoice_settings->default_payment_method,
				// 'receipt_email'				=> $user->email,
				'application_fee_amount'	=> $fee_amounts,
				'transfer_data'				=> array(
					'destination'				=> $charity->payout_reference_id,
				),
				'use_stripe_sdk'			=> true,
			]);
			// return intent
			return $intent;
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




	public static function createScheduledDonation($stripe_customer_id, $scheduled_date, $charity_id, $user_id, $amount, $includes_fees, $wants_reminders) {
		try {
			// Parse as int
			$amount = intval($amount);
			// Create token for task
			$task_token = sha1(uniqid(sha1($stripe_customer_id.'DashDonate').time()));
			// Create timestamp for processing date (will be midday on the scheduled date)
			$date_to_process = date('Y-m-d H:i:s', strtotime($scheduled_date) + 60*60*12);
			// Calculate fees
			$fee_amounts = StripeController::calculateFees($amount);
			// Create task
			$task = DB::table('donations_task_list')->insertGetId([
				'task_token'				=> $task_token,
				'date_to_process'			=> $date_to_process,
				'charity_id'				=> $charity_id,
				'user_id'					=> $user_id,
				'amount'					=> $amount,
				'total_fees'				=> $fee_amounts,
				'amount_includes_fees'		=> $includes_fees,
				'reminder_needed'			=> $wants_reminders,
				'recurring'					=> false,
			]);
			// Check if task was made
			if ($task) {
				// Get task
				$task = DB::table('donations_task_list')->where(['id' => $task])->first();
				// Return task
				return $task;
			}
			// Return false
			return false;
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




	public static function createRepeatDonation($stripe_customer_id, $charity_id, $user_id, $amount, $includes_fees, $wants_reminders, $interval, $duration, $anchor) {
		try {
			// Create token for task
			$task_token = sha1(uniqid(sha1($stripe_customer_id.'DashDonate').time()));
			// Check if duration is months (instead of weeks)
			if ($duration == 'months') {
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
				// Set options for days of week
				$daysOfWeek = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
				// Create timestamp for the anchor day (will be midday on the anchor date)
				$date_to_process = date('Y-m-d H:i:s', strtotime('next '.$daysOfWeek[substr($anchor, strlen('week-'))]) + 60*60*12);
			}
			// Calculate fees
			$fee_amounts = StripeController::calculateFees($amount);
			// Create task
			$task = DB::table('donations_task_list')->insertGetId([
				'task_token'				=> $task_token,
				'date_to_process'			=> $date_to_process,
				'recurring_interval'		=> $interval,
				'recurring_duration'		=> $duration,
				'recurring_anchor'			=> $anchor,
				'charity_id'				=> $charity_id,
				'user_id'					=> $user_id,
				'amount'					=> $amount,
				'total_fees'				=> $fee_amounts,
				'amount_includes_fees'		=> $includes_fees,
				'reminder_needed'			=> $wants_reminders,
				'recurring'					=> true,
			]);
			// Check if task was made
			if ($task) {
				// Get task
				$task = DB::table('donations_task_list')->where(['id' => $task])->first();
				// Return task
				return $task;
			}
			// Return false
			return false;
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




	public static function createDonation($stripe_customer_id, $intent_id, $card_id, $charity_id, $user_id, $amount, $fee_amounts, $includes_fees, $email_address, $donor_id) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Get intent
			$intent = \Stripe\PaymentIntent::retrieve($intent_id);
			// Check if not successful
			if ($intent->status != 'succeeded') {
				// Update payment intent
				$intent = \Stripe\PaymentIntent::update($intent_id, [
					'customer'					=> $stripe_customer_id,
					'amount'					=> intval($amount),
					'currency'					=> 'gbp',
					'payment_method'			=> $card_id,
					'save_payment_method'		=> true,
					'metadata'					=> array(
						'email'						=> $email_address,
						'charity_id'				=> $charity_id,
						'fees_included'				=> $includes_fees,
					),
					// 'receipt_email'				=> $email_address,
					'application_fee_amount'	=> $fee_amounts,
				]);
				// Check if if payment needs confirmed
				if ($intent->status == 'requires_confirmation') {
					// Capture payment
					$intent = $intent->confirm();
				}
			}
			// Check if intent was confirmed
			if ($intent) {
				// Log donation into the database
				$donation = DB::table('donations')->insertGetId([
					'amount'				=> intval($amount),
					'charity_id'			=> $charity_id,
					'donor_id'				=> $donor_id,
					'stripe_payment_id'		=> $intent_id,
					'total_fees'			=> $fee_amounts,
				]);
				// Return the intent
				return $intent;
			}
			// Return false
			return false;
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




	public static function processOffSessionDonation($task, $user) {
		try {
			// Get connected charity data
			$charity = DB::table('charities')->where(['id' => $task->charity_id])->first();
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Get donor's Stripe customer record
			$customer = \Stripe\Customer::retrieve($user->stripe_customer_token);
			// Check if there is not a default source setup
			if (!@$customer->invoice_settings->default_payment_method) {
				// Get customer's cards
				$cards = \Stripe\PaymentMethod::all([
					'customer' 		=> $user->stripe_customer_token,
					'type'			=> 'card',
				]);
				// Check if cards were returned
				if ($cards && @sizeof($cards->data) > 0) {
					// Get card
					$card = \Stripe\PaymentMethod::retrieve($cards->data[0]->id);
					// Set card as default source for donor
					$card->attach(['customer' => $user->stripe_customer_token]);
				}
				// Get refreshed customer record for the donor
				$customer = \Stripe\Customer::retrieve($user->stripe_customer_token);
			}


			// Calculate fees
			$fee_amounts = StripeController::calculateFees($task->amount);
			// Create payment intent
			$intent = \Stripe\PaymentIntent::create([
				'customer'					=> $customer->id,
				'amount'					=> intval($task->amount),
				'currency'					=> 'gbp',
				'confirm'					=> true,
				'off_session'				=> true,
				'metadata'					=> array(
					'email'						=> $user->id,
					'charity_id'				=> $task->charity_id,
					'fees_included'				=> $task->amount_includes_fees,
				),
				'payment_method'			=> $customer->invoice_settings->default_payment_method,
				// 'receipt_email'				=> $user->email,
				'return_url' 				=> env('FRONTEND_URL').'/widget/donation/secure-confirmation',
				'application_fee_amount'	=> $fee_amounts,
				'transfer_data'				=> array(
					'destination'				=> $charity->payout_reference_id,
				),
				'use_stripe_sdk'			=> false,
			]);


			// Check if payment was successful
			if (@$intent->status === 'succeeded') {
				// Log donation into the database
				$donation = DB::table('donations')->insertGetId([
					'amount'				=> $task->amount,
					'charity_id'			=> $charity->id,
					'donor_id'				=> $user->id,
					'stripe_payment_id'		=> $intent->id,
					'total_fees'			=> $fee_amounts,
				]);
				// Send donation receipt email
				DonationController::sendDonationReceipt($user->email, $task, $charity);
				// Return the intent
				return true;
			} else {
				// Needs confirmation from user for payment to be taken
				return 'needs_confirmation';
			}
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




	public static function sendDonationReceipt($email_address, $donation_data, $charity) {
		try {
			// Set default
			$subject = 'Your Donation Receipt';
			// Check if not pay now
			if (@!$donation_data->pay_now && gettype($donation_data) == 'object') {
				// Check if pay now
				if (!@$donation_data->amount) {
					// Set other subject
					$subject = 'Details About Your Future Donation';
				}
			}
			// Email info
			$email = array(
				'subject'				=> $subject,
				'recipient'				=> $email_address,
				'donation_details'		=> $donation_data,
				'charity'				=> $charity,
				'positive_action'		=> env('FRONTEND_URL').'/dashboard/donations',
			);
			// Send email
			$send = Mail::send('emails.donation_receipt', ['email' => $email], function($m) use ($email) {
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




	public static function sendDonationReminder($email_address, $donation_data) {
		try {
			// Get connected charity data
			$donation_data->charity = DB::table('charities')->where(['id' => $donation_data->charity_id])->first();
			// Email info
			$email = array(
				'subject'				=> 'Reminder: You Have An Upcoming Donation',
				'recipient'				=> $email_address,
				'donation_details'		=> $donation_data,
				'positive_action'		=> env('FRONTEND_URL').'/dashboard/donations',
			);
			// Send email
			$send = Mail::send('emails.donation_reminder', ['email' => $email], function($m) use ($email) {
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




	public static function createNextRepeatDonation($stripe_customer_id, $charity_id, $user_id, $amount, $includes_fees, $wants_reminders, $interval, $duration, $anchor) {
		try {
			// Create token for task
			$task_token = sha1(uniqid(sha1($stripe_customer_id.'DashDonate').time()));
			// Check if duration is months (instead of weeks)
			if ($duration == 'months') {
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
				// Set options for days of week
				$daysOfWeek = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
				// Create timestamp for the anchor day (will be midday on the anchor date)
				$date_to_process = date('Y-m-d H:i:s', strtotime('next '.$daysOfWeek[substr($anchor, strlen('week-'))]) + 60*60*12);
			}
			// Calculate fees
			$fee_amounts = StripeController::calculateFees($amount);
			// Create task
			$task = DB::table('donations_task_list')->insertGetId([
				'task_token'				=> $task_token,
				'date_to_process'			=> $date_to_process,
				'recurring_interval'		=> $interval,
				'recurring_duration'		=> $duration,
				'recurring_anchor'			=> $anchor,
				'charity_id'				=> $charity_id,
				'user_id'					=> $user_id,
				'amount'					=> $amount,
				'total_fees'				=> $fee_amounts,
				'amount_includes_fees'		=> $includes_fees,
				'reminder_needed'			=> $wants_reminders,
				'recurring'					=> true,
			]);
			// Check if task was made
			if ($task) {
				// Get task
				$task = DB::table('donations_task_list')->where(['id' => $task])->first();
				// Return task
				return $task;
			}
			// Return false
			return false;
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
