<?php

namespace App\Http\Controllers;

// Include the error logging controller (to aid finding and fixing bugs)
use \App\Http\Controllers\LogError;

use Illuminate\Http\Request;
use DB;

class StripeController extends Controller
{

	// Create stripe customer
	public static function create_stripe_customer($user_id) {
		// Get user info
		$user = DB::table('users')->where(['id' => $user_id])->first();
		// Check user exists and doesn't have a customer ID
		if ($user && $user->stripe_customer_id == null) {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create customer in Stripe
			$customer = \Stripe\Customer::create([
				'description'	=> 'Customer for '.$user->name.' ('.$user->email.')',
				'email'			=> $user->email,
				'name'			=> $user->name,
				'metadata'		=> array(
					'user_id'		=> $user->id,
				),
			]);
			// Check if customer was created
			if ($customer) {
				// Get customer ID from creation method response
				$stripe_customer_id = $customer->id;
				// Set stripe_customer_id in DB
				DB::table('users')->where(['id' => $user_id])->update(['stripe_customer_id' => $stripe_customer_id]);
				// Return stripe_customer_id
				return $stripe_customer_id;
			}
			return false;
		}
	}


	// Create charity account
	public static function create_charity_account($charity, $ip) {
		try {
			// Check record has key items
			if ($charity && @$charity->id != null) {
				// Get charity owner's info
				$owner = DB::table('users')->where(['id' => $charity->owner_id])->first();
				// Connect to Stripe
				\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
				// Create account in Stripe
				$account = \Stripe\Account::create([
					'type'						=> 'custom',
					'country'					=> 'GB',
					'email'						=> $owner->email,
					'business_type'				=> 'non_profit',
					'default_currency'			=> 'gbp',
					'metadata'					=> array(
						'dashdonate_charity_id'			=> $charity->id,
						'dashdonate_charity_name'		=> $charity->name,
						'charity_registration_number'	=> $charity->charity_registration_number,
					),
					'tos_acceptance'			=> array(
						'date'						=> time(),
						'ip'						=> $ip,
					),
					'requested_capabilities'	=> array(
						'card_payments',
						'transfers',
					),
				]);
				// Check account was made
				if ($account) {
					// Update charity account with Stripe account ID
					$update = DB::table('charities')->where([
						'id' 					=> $charity->id,
					])->update([
						'payout_reference_id'	=> $account->id,
					]);
				}
				// Return account info
				return $account;
			}
		} catch (Exception $e) {
			return LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace()));
		}
		return false;
	}


	// Create stripe source for a customer
	public static function create_customer_source($customer_token, $source_token) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create source for customer in Stripe
			$source = \Stripe\Customer::createSource($customer_token, array(
				'source'	=> $source_token,
				// EXTRA INFO HERE
			));
			// Check if source was created
			if ($source) {
				// Return source info to API caller
				return $source;
			}
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














	// Process a contribution
	public static function process_contribution($data) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create payment intent
			$intent = \Stripe\PaymentIntent::create([
				'amount'				=> $data['data']['amount'],
				'currency'				=> 'gbp',
				// 'payment_method'		=> $data['data']['stripeToken'],
				'payment_method_data'	=> array(
					'type'					=> 'card',
					'card[token]'			=> $data['data']['stripeToken'],
				),
				'save_payment_method'	=> false,
				'description'			=> 'Contribution to project',
				'confirm'				=> true,
				'return_url' 			=> env('FRONTEND_URL').'/contribution/secure-confirmation',
				'metadata'				=> array(
					'name'					=> $data['data']['name'],
					'email'					=> $data['data']['email'],
					'happy_to_chat'			=> $data['data']['get_in_touch'],
					'heardabout'			=> $data['data']['hearabout'],
				),
				'receipt_email'			=> $data['data']['email'],
				'use_stripe_sdk'		=> false,
			]);
			// Return intent
			return $intent;
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

	// Retrieve a donation
	public static function get_contribution($intent_id) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create payment intent
			$intent = \Stripe\PaymentIntent::retrieve($intent_id);
			// Return intent
			return $intent;
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


	// Confirm PaymentIntent
	public static function confirm_contribution($intent_id) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Retrieve payment intent
			$intent = \Stripe\PaymentIntent::retrieve($intent_id);
			// Confirm intent
			$confirm = $intent->confirm([
				'return_url' 	=> env('FRONTEND_URL').'/contribution/secure-confirmation',
			]);
			// Return resulting intent from confirmation procedures
			return $confirm;
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


	// Capture payment for PaymentIntent
	public static function capture_contribution($intent_id) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Retrieve payment intent
			$intent = \Stripe\PaymentIntent::retrieve($intent_id);
			// Capture intent
			$capture = $intent->capture();
			// Check if capture succeeded
			if ($capture) {
				// Return capture data
				return $capture;
			} else {
				// Cancel intent as failed to capture payment
				$intent = $intent->cancel([
					'cancellation_reason'	=> 'abandoned',
				]);
				// Return intent
				return $intent;
			}
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










	// Retrieve a donation
	public static function get_donation($intent_id) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create payment intent
			$intent = \Stripe\PaymentIntent::retrieve($intent_id);
			// Return intent
			return $intent;
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


	// Make donation/charge
	public static function take_donation($user, $charity, $amount, $fees, $card) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create payment intent
			$intent = \Stripe\PaymentIntent::create(array(
				'amount'				=> $amount,
				'currency'				=> 'gbp',
				'customer'				=> $user->stripe_customer_id,
				'description'			=> 'Donation of ('.$user->currency.') '.number_format($amount / 100, 2).' to '.$charity->name.' (ID: '.$charity->id.')',
				'payment_method'		=> $card->stripe_source_id,
				'save_payment_method'	=> true,
				'livemode'				=> env('LIVE_MODE'),
				'metadata'				=> array(
					'charity_id'			=> $charity->id,
					'charity_slug'			=> $charity->slug,
					'total_fees'			=> $fees,
				),
				'transfer_data' 		=> array(
					'amount'				=> ($amount - $fees),
					'destination'			=> $charity->payout_reference_id,
				),
			));
			// Check if intent was found and that it is an object
			if ($intent) {
				// Check if intent was created and needs action
				if ($intent->status !== 'succeeded') {
					// Switch status
					switch ($intent->status) {
						case 'requires_payment_method':
							// Return intent to redirect to add payment method
							return $intent;
						break;
						case 'requires_confirmation':
							// Confirm the paymentIntent
							$confirm = $intent->confirm([
								'return_url' 	=> env('FRONTEND_URL').'/charity/'.$charity->slug.'/donate/secure-confirmation',
							]);
							// Return resulting intent from confirmation procedures
							return $confirm;
						break;
						case 'requires_action':
							// Return intent to notify DashDonate of next actions
							return $intent;
						break;
						case 'processing':
							// Return intent to notify DashDonate of next actions
							return $intent;
						break;
						case 'requires_capture':
							// Capture intent
							$capture = $intent->capture();
							// Check if capture succeeded
							if ($capture) {
								// Return capture data
								return $capture;
							} else {
								// Cancel intent as failed to capture payment
								$intent = $intent->cancel([
									'cancellation_reason'	=> 'abandoned',
								]);
								// Return intent
								return $intent;
							}
							// If capture succeeds, return same as 'success'
							// If capture fails, cancel payment intent and return failure of capturing payment
						break;
						case 'canceled':
							// Return intent to notify DashDonate of next actions
							return $intent;
						break;
						default:
							// Cancel intent as failed to capture payment
							$intent = $intent->cancel([
								'cancellation_reason'	=> 'abandoned',
							]);
							// Return intent
							return $intent;
						break;
					}
				} else {
					// Return intent as it was successful
					return $intent;
				}
			} else {
				// Failed to create intent
				throw new Exception('Failed to create PaymentIntent');
			}
			// Return intent to notify DashDonate of next actions
			return $intent;
		} catch (Exception $e) {
			return LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace()));
		}
		return false;
	}





	public static function update_intent_payment_method($card, $donation) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Retrive intent
			$intent = \Stripe\PaymentIntent::retrieve($donation->stripe_payment_id);
			// Update intent's card
			$update = \Stripe\PaymentIntent::update($intent->id, [
				'payment_method'	=> $card->stripe_source_id,
			]);
			// Return updated intent
			return $update;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'trace'		=> $e->getTrace(),
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
		return $donation;
	}







	// Insert local record ID into Stripe paymentIntent metadata
	public static function log_payment_local_record_id($intent_id, $local_record_id) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Retrive intent
			$intent = \Stripe\PaymentIntent::retrieve($intent_id);
			// Retrieve exisitng metadata
			$metadata = json_decode(json_encode($intent->metadata), true);
			// Add the local record ID to metadata
			$metadata['local_id'] = $local_record_id;
			// Update intent
			$update = \Stripe\PaymentIntent::update(
				$intent_id,
				array('metadata' => $metadata)
			);
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'trace'		=> $e->getTrace(),
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
		return $local_record_id;
	}

	// Log changes to donation payment status
	public static function log_donation_status($donation_id, $status) {
		try {
			// Get record
			$record = DB::table('donations')->where(['id' => $donation_id])->first();
			// Check if found
			if ($record) {
				// Update record with new status
				$update = DB::table('donations')->where(['id' => $donation_id])->update([
					'updated_at'		=> date('Y-m-d H:i:s', time()),
					'payment_status'	=> $status,
				]);
				// Check if update was made
				if ($update) {
					return true;
				}
			}
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

	// Log donation to database
	public static function log_donation($charity_id, $donor_id, $amount, $donation_id, $fees, $status, $is_anonymous) {
		try {
			// Create record in database
			$record = DB::table('donations')->insertGetId([
				'charity_id'			=> $charity_id,
				'donor_id'				=> $donor_id,
				'amount'				=> $amount,
				'stripe_payment_id'		=> $donation_id,
				'total_fees'			=> $fees,
				'payment_status'		=> $status,
				'paymentIntent_id'		=> $donation_id,
				'is_anonymous'			=> $is_anonymous,
			]);
			// Check if record was created
			if ($record) {
				// Return record ID
				return $record;
			}
			return false;
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



	// Capture payment for PaymentIntent
	public static function capture_donation($intent_id) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Retrieve payment intent
			$intent = \Stripe\PaymentIntent::retrieve($intent_id);
			// Capture intent
			$capture = $intent->capture();
			// Check if capture succeeded
			if ($capture) {
				// Change status of record
				$update = DB::table('donations')->where(['paymentIntent_id' => $intent_id])->update([
					'payment_status'	=> $intent->status,
					'updated_at'		=> date('Y-m-d H:i:s', time()),
				]);
				// Return capture data
				return $capture;
			} else {
				// Cancel intent as failed to capture payment
				$intent = $intent->cancel([
					'cancellation_reason'	=> 'abandoned',
				]);
				// Change status of record
				$update = DB::table('donations')->where(['paymentIntent_id' => $intent_id])->update([
					'payment_status'	=> $intent->status,
					'updated_at'		=> date('Y-m-d H:i:s', time()),
				]);
				// Return intent
				return $intent;
			}
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


	// Confirm PaymentIntent
	public static function confirm_donation($intent_id, $charity_slug) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Retrieve payment intent
			$intent = \Stripe\PaymentIntent::retrieve($intent_id);
			// Confirm intent
			$confirm = $intent->confirm([
				'return_url' 	=> env('FRONTEND_URL').'/charity/'.$charity_slug.'/donate/secure-confirmation',
			]);
			// Change status of record
			$update = DB::table('donations')->where(['paymentIntent_id' => $intent_id])->update([
				'payment_status'	=> $confirm->status,
				'updated_at'		=> date('Y-m-d H:i:s', time()),
			]);
			// Return resulting intent from confirmation procedures
			return $confirm;
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













	public static function createDonationIntent($stripe_token, $amount) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create payment intent
			$intent = \Stripe\PaymentIntent::create([
				'amount'				=> $amount,
				'currency'				=> 'gbp',
				'payment_method_data'	=> array(
					'type'					=> 'card',
					'card[token]'			=> $stripe_token,
				),
				'return_url' 			=> env('FRONTEND_URL').'/widget/donation/secure-confirmation',
				'save_payment_method'	=> false,
				'confirm'				=> true,
				'metadata'				=> array(
					// 'email'					=> $data['data']['email'],
				),
				// 'receipt_email'			=> $data['data']['email'],
				'use_stripe_sdk'		=> true,
			]);
			// Return the intent
			return $intent;
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

	// Retrieve a payment
	public static function get_intent($intent_id) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Receive payment intent
			$intent = \Stripe\PaymentIntent::retrieve($intent_id);
			// Return intent
			return $intent;
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










	// Calculate fee on a donation
	public static function calculate_fees($amount) {
		// Calculate fees on donation
		return (($amount * env('DONATION_FEE_PERCENTAGE')) + env('DONATION_FEE_ADDITIONAL'));
	}

}
