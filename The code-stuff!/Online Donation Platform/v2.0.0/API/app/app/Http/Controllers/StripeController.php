<?php

namespace App\Http\Controllers;

// Include the error logging controller (to aid finding and fixing bugs)
use \App\Http\Controllers\LogError;
use \App\Http\Controllers\UserAccountController as DD_User;

use Illuminate\Http\Request;
use DB;

class StripeController extends Controller
{




	// Process card token
	public static function processCardToken($customer, $token) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create intent to setup card
			$intent = \Stripe\SetupIntent::create([
				'customer'				=> $customer->id,
				'confirm'				=> true,
				'payment_method_data'	=> array(
					'type'					=> 'card',
					'card[token]'			=> $token,
				),
				'usage'					=> 'off_session',
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




	// Get the default payment card for a user
	public static function getDonorDefaultSource($user) {
		try {
			// Get user source
			$source = DB::table('users_payment_sources')->where(['user_id' => $user->id])->first();
			// Return data
			return $source;
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




	// Set the default payment card for a user
	public static function setDonorDefaultSource($user, $paymentMethodId) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Get customer's cards
			$cards = \Stripe\PaymentMethod::all([
				'customer' 		=> $user->stripe_customer_token,
				'type'			=> 'card',
				'limit'			=> 100,
			]);
			// Check if cards were returned
			if ($cards && @sizeof($cards->data) > 0) {
				// Loop through cards
				for ($i = 0; $i < sizeof($cards->data); $i++) {
					// Get card
					$card = \Stripe\PaymentMethod::retrieve($cards->data[$i]->id);
					// Check if not the new card
					if ($paymentMethodId != $cards->data[$i]->id) {
						// Un-attach payment method
						$card->detach();
					} else {
						// Attach payment method
						$card->attach(['customer' => $user->stripe_customer_token]);
						// Set card as default source for donor
						\Stripe\Customer::update($user->stripe_customer_token, [
							'invoice_settings'		=> array(
								'default_payment_method'	=> $paymentMethodId,
							),
						]);
						// Remove existing cards
						DB::table('users_payment_sources')->where(['user_id' => $user->id])->delete();
						// Save card for user
						DB::table('users_payment_sources')->insert([
							'user_id'				=> $user->id,
							'stripe_source_id'		=> $card->id,
							'expiry_date'			=> date('Y-m-d H:i:s', strtotime($card->card->exp_year.'-'.$card->card->exp_month.'-1')),
							'last_four_digits'		=> $card->card->last4,
							'brand'					=> $card->card->brand,
						]);
					}
				}
			}
			// Get refreshed customer record for the donor
			$customer = \Stripe\Customer::retrieve($user->stripe_customer_token);
			// Return customer record
			return $customer;
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




	// Calculate fees
	public static function calculateFeesData($amount_pence, $type = 'normal') {
		try {
			// Ensure fee formula items are not parsed as strings
			$percentageStripe 	= floatval(env('FEE_CALC_PERCENTAGE_STRIPE'));
			$percentageDD 		= floatval(env('FEE_CALC_PERCENTAGE_DD'));
			$penceStripe 		= intval(env('FEE_CALC_PENCE_STRIPE'));
			$penceDD 			= intval(env('FEE_CALC_PENCE_DD'));
			// Empty object for amounts data
			$data 				= array(
				'originalAmount'	=> intval($amount_pence),
				'totalCharge'		=> 0,
				'totalFees'			=> 0,
				'totalToCharity'	=> 0,
				'totalToStripe'		=> 0,
				'totalToDD'			=> 0,
			);
			// Switch type of calculation
			switch ($type) {
				case 'none':
					$data['totalToStripe'] 	= ceil(($data['originalAmount'] + $penceStripe) / (1 - $percentageStripe)) - $data['originalAmount'];

					$data['totalToDD'] 		= ceil(($data['originalAmount'] + ($data['originalAmount'] * $percentageDD) + $penceDD) - $data['originalAmount']);

					$data['totalToCharity'] = ($data['originalAmount'] - ($data['totalToStripe'] + $data['totalToDD']));

					$data['totalCharge'] 	= $data['totalToCharity'] + $data['totalToStripe'] + $data['totalToDD'];

					$data['totalFees'] 		= 0;

					$data['fees']			= $data['totalToStripe'] + $data['totalToDD'];
				break;
				case 'normal':
					$data['totalToStripe'] 	= ceil(($data['originalAmount'] + $penceStripe) / (1 - $percentageStripe)) - $data['originalAmount'];

					$data['totalToDD'] 		= ceil(($data['originalAmount'] + ($data['originalAmount'] * $percentageDD) + $penceDD) - $data['originalAmount']);

					$data['totalToCharity'] = $data['originalAmount'];

					$data['totalCharge'] 	= $data['totalToCharity'] + $data['totalToStripe'] + $data['totalToDD'];

					$data['totalFees'] 		= $data['totalCharge'] - $data['originalAmount'];

					$data['fees']			= $data['totalToStripe'] + $data['totalToDD'];
				break;
			}
			// Return amounts data
			return $data;
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




	// Take donation now
	public static function takeDonationNow($data, $charity, $user, $customer, $fees, $stagePrefix, $paymentMethod) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create intent
			$intent = \Stripe\PaymentIntent::create([
				'amount'					=> $fees['totalCharge'],
				'currency'					=> 'gbp',
				'confirm'					=> true,
				'customer'					=> $customer->id,
				'metadata'					=> array(
					'charityID'					=> $charity->id,
					'feesPaidByDonor'			=> $data[$stagePrefix.'PayFees'],
				),
				'off_session'				=> false,
				'payment_method'			=> $paymentMethod->stripe_source_id,
				'application_fee_amount'	=> $fees['fees'],
				'use_stripe_sdk'			=> true,
				'transfer_data'				=> array(
					'destination'				=> $charity->payout_reference_id,
				),
			]);
			// Save donation record to database
			DB::table('donations')->insert([
				'charity_id'			=> $charity->id,
				'donor_id'				=> $user->id,
				'amount'				=> $fees['totalCharge'],
				'stripe_payment_id'		=> $intent->status,
				'total_fees'			=> $fees['fees'],
				'payment_status'		=> $intent->status,
				'paymentIntent_id'		=> $intent->id,
			]);
			// Check if the intent does not need further action
			if ($intent && @$intent->status == 'succeeded') {
				// Return success
				return array('success' => true);
			} else {
				// Send PaymentIntent to user to verify
				return array('intent' => $intent);
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




	// Take off-session donation
	public static function processOffSessionDonation($charity, $user, $customer, $paymentMethod, $fees, $feesPaid) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create intent
			$intent = \Stripe\PaymentIntent::create([
				'amount'					=> $fees['totalCharge'],
				'currency'					=> 'gbp',
				'confirm'					=> true,
				'return_url'				=> env('FRONTEND_URL').'/donation/confirmation',
				'customer'					=> $customer->id,
				'metadata'					=> array(
					'charityID'					=> $charity->id,
					'feesPaidByDonor'			=> $feesPaid,
				),
				'off_session'				=> true,
				'payment_method'			=> $paymentMethod->stripe_source_id,
				'application_fee_amount'	=> $fees['fees'],
				'use_stripe_sdk'			=> true,
				'transfer_data'				=> array(
					'destination'				=> $charity->payout_reference_id,
				),
			]);
			// Save donation record to database
			DB::table('donations')->insert([
				'charity_id'			=> $charity->id,
				'donor_id'				=> $user->id,
				'amount'				=> $fees['totalCharge'],
				'stripe_payment_id'		=> $intent->status,
				'total_fees'			=> $fees['fees'],
				'payment_status'		=> $intent->status,
				'paymentIntent_id'		=> $intent->id,
			]);
			// Send PaymentIntent
			return $intent;
		} catch (\Stripe\Exception\CardException $e) {
			// Get intent from error
			$intent = $e->getError()->payment_intent;
			// Save donation record to database
			DB::table('donations')->insert([
				'charity_id'			=> $charity->id,
				'donor_id'				=> $user->id,
				'amount'				=> $fees['totalCharge'],
				'stripe_payment_id'		=> $intent->status,
				'total_fees'			=> $fees['fees'],
				'payment_status'		=> $intent->status,
				'paymentIntent_id'		=> $intent->id,
			]);
			// Send PaymentIntent to user to verify
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




	// Retrieve a Payment Intent
	public static function getPaymentIntent($intent_id) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create intent
			$intent = \Stripe\PaymentIntent::retrieve($intent_id);
			// Send PaymentIntent
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




	// Set a Payment Intent as on-session
	public static function updatePaymentIntentAsOnSession($intent_id, $paymentMethod) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create intent
			$intent = \Stripe\PaymentIntent::update($intent_id, array(
				'confirm'					=> true,
				'payment_method'			=> $paymentMethod->stripe_source_id,
				'application_fee_amount'	=> $fees['fees'],
				'use_stripe_sdk'			=> true,
				'transfer_data'				=> array(
					'destination'				=> $charity->payout_reference_id,
				),
			));
			// Send PaymentIntent
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




	// Update Payment Intent source
	public static function updatePaymentIntentSource($intent_id, $paymentMethod) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create intent
			$intent = \Stripe\PaymentIntent::update($intent_id, array(
				'payment_method'			=> $paymentMethod->stripe_source_id,
			));
			// Confirm intent
			$intent = $intent->confirm();
			// Send PaymentIntent
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




	// Clone a PaymentIntent
	public static function clonePaymentIntent($oldIntent, $user_id, $charity_id) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create intent
			$intent = \Stripe\PaymentIntent::create([
				'amount'					=> $oldIntent->amount,
				'currency'					=> 'gbp',
				'customer'					=> $oldIntent->customer,
				'metadata'					=> array(
					'charityID'					=> $oldIntent->metadata->charityID,
					'feesPaidByDonor'			=> $oldIntent->metadata->feesPaidByDonor,
				),
				'off_session'				=> false,
				'application_fee_amount'	=> $oldIntent->application_fee_amount,
				'use_stripe_sdk'			=> true,
				'transfer_data'				=> array(
					'destination'				=> $oldIntent->transfer_data->destination,
				),
			]);
			// Save donation record to database
			DB::table('donations')->insert([
				'charity_id'			=> $charity_id,
				'donor_id'				=> $user_id,
				'amount'				=> $oldIntent->amount,
				'stripe_payment_id'		=> $intent->status,
				'total_fees'			=> $oldIntent->application_fee_amount,
				'payment_status'		=> $intent->status,
				'paymentIntent_id'		=> $intent->id,
			]);
			// Send PaymentIntent
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


























































	public static function clearExistingCards($stripe_user_id) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Get all existing cards
			$existing_cards = \Stripe\Customer::allSources($stripe_user_id, ['object' => 'card', 'limit' => 200]);
			// Loop through existing cards
			for ($i = 0; $i < sizeof(@$existing_cards['data']); $i++) {
				// Un-attach payment method
				\Stripe\Customer::deleteSource($stripe_user_id, $existing_cards['data'][$i]->id);
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




	public static function createDonationIntentInitial($site_id) {
		try {
			// Get data about the charity being donated to
			$charity = DB::table('charities')->where(['api_site_id' => $site_id])->first();
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create payment intent object to use if the transaction progresses
			$intent = \Stripe\PaymentIntent::create([
				'amount'					=> 100, // This is a default value
													// - This is overwritten before any further action is taken with the intent
				'application_fee_amount'	=> 100, // This is a default value
													// - This is overwritten before any further action is taken with the intent
				'currency'					=> 'gbp',
				'confirm'					=> false,
				'use_stripe_sdk'			=> true,
				'metadata'					=> array(
					'charity_id'				=> $charity->id,
				),
				'transfer_data'				=> array(
					'destination'				=> $charity->payout_reference_id,
				),
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




	public static function getDonorStripeCustomer($email_address) {
		try {
			// Get user profile
			$user = DB::table('users')->where(['email' => $email_address])->first();
			// Check if user was not found
			if (!$user) {
				// Create user
				$user = DD_User::createDashDonateUser($email_address);
			}
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Check if user needs a Stripe customer account made
			if ($user->stripe_customer_token == null) {
				// Create Stripe customer for the user
				$customer = \Stripe\Customer::create([
					'email'		=> $email_address,
				]);
				// Update DashDonate records
				DB::table('users')->where(['id' => $user->id])->update(['stripe_customer_token' => $customer->id]);
			} else {
				// Retrive Stripe customer for the user
				$customer = \Stripe\Customer::retrieve($user->stripe_customer_token);
			}
			// Return user's customer record
			return $customer;
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




	public static function addCardToUser($stripe_user, $stripe_token) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));



			// Create intent to setup card
			$intent = \Stripe\SetupIntent::create([
				'customer'				=> $stripe_user,
				'confirm'				=> true,
				'payment_method_data'	=> array(
					'type'					=> 'card',
					'card[token]'			=> $stripe_token,
				),
				'usage'					=> 'off_session',
			]);


			return $intent;



			// // Create card for user
			// $card = \Stripe\customer::createSource($stripe_user->id, [
			// 	'source'					=> $stripe_token,
			// ]);

			// Return card
			// return $card;
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




	public static function addCardForPayNow($stripe_user, $stripe_token) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create card for user
			$card = \Stripe\customer::createSource($stripe_user->id, [
				'source'					=> $stripe_token,
			]);
			// Return card
			return $card;
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




	public static function getStripeCard($setup_intent_id) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create intent to setup card
			$intent = \Stripe\SetupIntent::retrieve($setup_intent_id);
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




	public static function progressDonationIntent($stripe_token, $amount_pounds, $pay_fees, $email_address, $site_id, $intent_id, $regular) {
		try {
			// Turn pounds into pence
			$amount = intval(floatval($amount_pounds) * 100);
			// Calculate fee
			$fee_amounts = StripeController::calculateFees($amount);
			// Check if fees will be added onto donation
			if ($pay_fees) {
				// Add fee to amount
				$amount = intval($amount + $fee_amounts);
			}
			// Get data about the charity being donated to
			$charity = DB::table('charities')->where(['api_site_id' => $site_id])->first();
			// Fetch DashDonate user with this email (One will be created if no user exists)
			$stripe_user = StripeController::getDonorStripeCustomer($email_address);
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create card for user
			$card = \Stripe\customer::createSource($stripe_user->id, [
				'source'					=> $stripe_token,
			]);
			// Check if card was added
			if ($card) {
				// Check if regular or not
				if (!$regular) {
					// Update payment intent
					$intent = \Stripe\PaymentIntent::update($intent_id, [
						'customer'					=> $stripe_user->id,
						'amount'					=> intval($amount),
						'currency'					=> 'gbp',
						'payment_method'			=> $card->id,
						'save_payment_method'		=> true,
						// 'return_url' 				=> env('FRONTEND_URL').'/widget/donation/secure-confirmation',
						'metadata'					=> array(
							'email'						=> $email_address,
							'charity_id'				=> $charity->id,
						),
						// 'receipt_email'				=> $email_address,
						'application_fee_amount'	=> $fee_amounts,
					]);
					// Check if if payment needs confirmed
					if ($intent->status == 'requires_confirmation') {
						// Capture payment
						$intent = $intent->confirm();
					}
					// Check if intent was confirmed
					if ($intent) {
						// Return the intent
						return $intent;
					}
				} else {


					return 'Monthly please';


					// // Create link for donor to be linked to the charity
					// $token = \Stripe\Token::create([
					// 	'customer'			=> $stripe_user->id,
					// ], ['stripe_account' 	=> $charity->payout_reference_id]);
					// // Check if token was created
					// if ($token) {
					// 	// Create customer for connected account
					// 	$customer = \Stripe\Customer::create([
					// 		'source'			=> $token->id,
					// 	], ['stripe_account' 	=> $charity->payout_reference_id]);
					// 	// Check if customer was added for the charity
					// 	if ($customer) {
					// 		// Create a plan for the subscription
					// 		$plan = \Stripe\Plan::create([
					// 			'amount'			=> intval($amount),
					// 			'currency'			=> 'gbp',
					// 			'interval'			=> 'month',
					// 			'product'			=> array(
					// 				'name'				=> 'Monthly donation to '.$charity->name,
					// 			),
					// 			'metadata'			=> array(
					// 				'charity_id'		=> $charity->id,
					// 				'charity_name'		=> $charity->name,
					// 			),
					// 		], ['stripe_account' 	=> $charity->payout_reference_id]);
					// 		// Check if plan was created
					// 		if ($plan) {
					//
					//
					// 			$subscription_fee = StripeController::calculateFees($amount, false);
					//
					// 			$subscription_fee_percentage = ($fee_amounts / $amount) * 100;
					//
					//
					//
					//
					// 			$strx = 	'Total amount: '.$amount.' ----';
					// 			$strx .= 	'Total fees: '.$fee_amounts.' ----';
					// 			$strx .= 	'Needs to be taken from amount as fee (for both Stripe and DD): '.$fee_amounts.' ----';
					// 			$strx .= 	'Total for charity: '.intval($amount - $fee_amounts).' ----';
					// 			$strx .= 	'DD take: '.$subscription_fee.' ----';
					// 			$strx .= 	'DD Percentage take: '.$subscription_fee_percentage.'% ----';
					// 			// $strx .= 	'To charity:   '..' ----';
					//
					// 			return $strx;
					//
					//
					// 			// Create subscription
					// 			$subscription = \Stripe\Subscription::create([
					// 				'customer'					=> $customer->id,
					// 				'items'						=> array(
					// 					array(
					// 						'plan'					=> $plan->id,
					// 					),
					// 				),
					// 				'application_fee_percent'	=> $subscription_fee_percentage,
					// 			], ['stripe_account' => $charity->payout_reference_id]);
					// 			// Check if subscription was created
					// 			if ($subscription) {
					// 				// Return the subscription
					// 				return $subscription;
					// 			}
					// 		}
					// 	}
					// }
				}
			}
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
		// try {
		// 	// Connect to Stripe
		// 	\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
		// 	// Receive payment intent
		// 	$intent = \Stripe\PaymentIntent::retrieve($intent_id);
		// 	// Return intent
		// 	return $intent;
		// } catch (Exception $e) {
		// 	// Create error info array
		// 	$error = array(
		// 		'message'	=> $e->getMessage(),
		// 		'line'		=> $e->getLine(),
		// 	);
		// 	// Return error
		// 	return $error;
		// }
		// return false;
	}





	// Create charity account
	public static function createStripeAccountForCharity($charity, $ip) {
		try {
			// Check record has key items
			if ($charity && @$charity->id != null) {
				// Get charity owner's info
				$owner = DB::table('users')->where(['id' => $charity->owner_id])->first();
				// Get charity details
				$charity->details = DB::table('charities_details')->where(['charity_id' => $charity->id])->first();
				// Get charity staff
				$charity->staff = DB::table('charities_staff')->where(['charity_id' => $charity->id])->orderBy('date_added', 'ASC')->get();
				// Get charity representative
				$charity->representative = DB::table('charities_staff')->where(['charity_id' => $charity->id, 'is_representative' => true])->first();
				// Check if company reg is set
				if (@$charity->companies_house_number && $charity->companies_house_number != '') {
					// Set tax ID as charity tax number
					$charity_tax_id = $charity->companies_house_number;
				} else {
					// As there is no company number, set charity commission reg instead
					$charity_tax_id = $charity->charity_registration_number;
				}
				// Check if VAT ID is set
				if (@$charity->details->vat_id && $charity->details->vat_id != '') {
					// Set vat ID to vat id
					$charity_vat_id = $charity->details->vat_id;
				} else {
					// Set vat ID to null
					$charity_vat_id = null;
				}

				// Set default support URL
				if (empty($charity->details->charity_website)) {
					// Set as DashDonate support URL
					$support_url = 'https://dashdonate.org';
				} else {
					// Use value from commission
					$support_url = $charity->details->charity_website;
				}

				// Set default support Tel
				if (empty($charity->details->phone_number)) {
					// Set as DashDonate support tel (Ryan business phone)
					$support_tel = '+447984545188';
				} else {
					// Use value from commission
					$support_tel = $charity->details->phone_number;
				}


				// Connect to Stripe
				\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
				// Create account in Stripe
				$account = \Stripe\Account::create([
					'type'						=> 'custom',
					'country'					=> 'GB',
					'email'						=> $owner->email,
					'default_currency'			=> 'gbp',
					'business_type'				=> 'non_profit',
					'business_profile' 			=> array(
						'mcc'							=> '8398',
						'name'							=> $charity->name,
						'product_description'			=> $charity->details->description_of_charity,
						'support_phone'					=> $support_tel,
						'support_url'					=> $support_url,
						'url'							=> $support_url,
					),
					'company'					=> array(
						'name'							=> $charity->name,
						'address'				=> array(
							'line1'					=> $charity->details->address_line_1,
							'line2'					=> $charity->details->address_line_2,
							'city'					=> $charity->details->address_town_city,
							'postal_code'			=> $charity->details->address_postcode,
							'country'				=> 'GB',
						),
						'phone'					=> $charity->details->phone_number,
						'tax_id'				=> $charity_tax_id,
						'vat_id'				=> $charity_vat_id,
					),
					'metadata'					=> array(
						'dashdonate_charity_id'			=> $charity->id,
						'dashdonate_charity_name'		=> $charity->name,
						'charity_registration_number'	=> $charity->charity_registration_number,
					),
					'tos_acceptance'			=> array(
						'date'							=> time(),
						'ip'							=> $ip,
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
				// Return account ID
				return $account->id;
			}
		} catch (Exception $e) {
			return LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace()));
		}
		return false;
	}




	// Create charity representative profile
	public static function createCharityRepresentativeAccount($charity) {
		try {
			// Check record has key items
			if ($charity && @$charity->id != null) {
				// Get charity owner's info
				$owner = DB::table('users')->where(['id' => $charity->owner_id])->first();
				// Get charity details
				$charity->details = DB::table('charities_details')->where(['charity_id' => $charity->id])->first();
				// Get representative info
				$charity->representative = DB::table('charities_representative')->where(['charity_id' => $charity->id])->first();
				// Get representative user
				$charity->representative->user = DB::table('users')->where(['id' => $charity->representative->user_id])->first();
				// Get charity representative staff profile
				$charity->representative->staff_profile = DB::table('charities_staff')->where(['charity_id' => $charity->id, 'is_representative' => true])->first();
				// Connect to Stripe
				\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
				// Get existing representative data (if it exists)
				$existing_person = \Stripe\Account::allPersons(
	  				$charity->payout_reference_id, array(
						'relationship' => array('representative' => true)
					)
				);
				// Create array to store representative_data for submission
				$representative_data = array(
					'dob'					=> array(
						'day'					=> date('d', strtotime($charity->representative->dob)),
						'month'					=> date('m', strtotime($charity->representative->dob)),
						'year'					=> date('Y', strtotime($charity->representative->dob)),
					),
					'address'				=> array(
						'line1'					=> $charity->representative->address_line_1,
						'line2'					=> $charity->representative->address_line_2,
						'city'					=> $charity->representative->address_town_city,
						'postal_code'			=> $charity->representative->address_postcode,
						'country'				=> 'GB',
					),
					'email'					=> $charity->representative->user->email,
					'phone'					=> substr($charity->representative->phone_number, 2),
					'first_name'			=> $charity->representative->legal_firstname,
					'last_name'				=> $charity->representative->legal_lastname,
					'metadata'				=> array(
						'trustee_number'		=> $charity->representative->trustee_number,
					),
					'relationship'			=> array(
						'executive'				=> true,
						'representative'		=> true,
						'owner'					=> true,
						'director'				=> true,
						'title'					=> 'Trustee',
					),
					'verification' 			=> array(
						'document'				=> array(
							'front'					=> null,
							'back'					=> null,
						),
						'additional_document'	=> null,
					),
				);
				// Get ID front file
				$file = DB::table('charity_files')->where(['charity_id' => $charity->id, 'file_intent' => 'stripe_id_front'])->orderBy('date_added', 'DESC')->first();
				// Check if file was found
				if ($file) {
					// Add item to representative data
					$representative_data['verification']['document']['front'] = $file->stripe_file_id;
				}
				// Get additional file (proof of address)
				$file = DB::table('charity_files')->where(['charity_id' => $charity->id, 'file_intent' => 'stripe_proof_of_address'])->orderBy('date_added', 'DESC')->first();
				// Check if file was found
				if ($file) {
					// Add item to representative data
					$representative_data['verification']['additional_document']['front'] = $file->stripe_file_id;
				}
				// Check if the representative already exists
				if ($existing_person && @$existing_person['data'][0]->id) {
					// Update representative
					$representative = \Stripe\Account::updatePerson($charity->payout_reference_id, $existing_person['data'][0]->id, $representative_data);
				} else {
					// Create representative
					$representative = \Stripe\Account::createPerson($charity->payout_reference_id, $representative_data);
				}
				// Update connected account to say that directors are provided
				$directors_set = \Stripe\Account::update(
	  				$charity->payout_reference_id, array(
						'company' => array('directors_provided' => true)
					)
				);
				return $directors_set;
				// Return representative data
				return $representative;
			}
		} catch (Exception $e) {
			return LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace()));
		}
		return false;
	}




	// Set supporting document for charity
	public static function uploadAddressDocumentToCharityAccount($charity) {
		try {
			// Check record has key items
			if ($charity && @$charity->id != null) {
				// Get charity owner's info
				$owner = DB::table('users')->where(['id' => $charity->owner_id])->first();
				// Get file
				$file = DB::table('charity_files')->where(['charity_id' => $charity->id, 'file_intent' => 'charity_utility_bill'])->orderBy('date_added', 'DESC')->first();
				// Connect to Stripe
				\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
				// Get charity record from Stripe
				$stripe_charity = \Stripe\Account::retrieve($charity->payout_reference_id);
				// Update with document attached
				$update = \Stripe\Account::update($charity->payout_reference_id, [
					'company'					=> array(
						'verification' 				=> array(
							'document'					=> array(
								'front'						=> $file->stripe_file_id,
								'back'						=> null,
							),
						),
					),
				]);
				// Return data
				return $update;
			}
		} catch (Exception $e) {
			return LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace()));
		}
		return false;
	}




	// Get status of representative verification
	public static function getStatusOfRepresentativeVerification($charity) {
		try {
			// Check record has key items
			if ($charity && @$charity->id != null) {
				// Connect to Stripe
				\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
				// Get representative
				$representative = \Stripe\Account::allPersons(
	  				$charity->payout_reference_id, array(
						'relationship' => array('representative' => true)
					)
				);
				// Check if data was returned
				if (@$representative->data[0]) {
					// Return representative data
					return $representative->data[0];
				}
				// Return false
				return false;
			}
		} catch (Exception $e) {
			return LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace()));
		}
		return false;
	}




	// Get status of address verification
	public static function getStatusOfAddressVerification($charity) {
		try {
			// Check record has key items
			if ($charity && @$charity->id != null) {
				// Connect to Stripe
				\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
				// Get charity record from Stripe
				$stripe_charity = \Stripe\Account::retrieve($charity->payout_reference_id);
				// Check if data was returned
				if (@$stripe_charity) {
					// Return data
					return $stripe_charity;
				}
				// Return false
				return false;
			}
		} catch (Exception $e) {
			return LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace()));
		}
		return false;
	}




	// Get status of representative verification
	public static function updateCharityBankAccountDetails($charity, $sortcode, $account_number) {
		try {
			// Check record has key items
			if ($charity && @$charity->id != null) {
				// Connect to Stripe
				\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
				// Check if the bank account already exists
				$existing_account = \Stripe\Account::allExternalAccounts(
					$charity->payout_reference_id, array(
						'object' 	=> 'bank_account',
						'limit' 	=> 1
					)
				);
				// Create new account
				$new_account = \Stripe\Account::createExternalAccount(
					$charity->payout_reference_id, array(
						'external_account'	=> array(
							'object'				=> 'bank_account',
							'country'				=> 'GB',
							'currency'				=> 'gbp',
							'account_number'		=> $account_number,
							'routing_number'		=> $sortcode,
							'default_for_currency'	=> true,
						)
					)
				);
				// If account exists already
				if (@sizeof(@$existing_account->data[0]) > 0) {
					// Delete bank account
					$delete = \Stripe\Account::deleteExternalAccount(
						$charity->payout_reference_id,
						$existing_account->data[0]->id
					);
				}
				// Check if data was returned
				if (@$new_account->data[0]) {
					// Return bank account data
					return $new_account->data[0];
				}
				// Return false
				return $new_account;
			}
		} catch (Exception $e) {
			return LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace()));
		}
		return false;
	}




	// Get status of connected charity
	public static function getStatusOfConnectedAccount($charity) {
		try {
			// Check record has key items
			if ($charity && @$charity->id != null && $charity->payout_reference_id != null) {
				// Connect to Stripe
				\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
				// Get account
				$account = \Stripe\Account::retrieve($charity->payout_reference_id);
				// Check if data was returned
				if (@$account->id) {
					// Return account data
					return $account;
				}
			}
			// Return false
			return false;
		} catch (Exception $e) {
			return LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace()));
		}
		return false;
	}











































































	// Update charity account
	public static function updateConnectedAccount($charity) {
		try {
			// Check record has key items
			if ($charity && @$charity->id != null) {
				// Get charity owner's info
				$owner = DB::table('users')->where(['id' => $charity->owner_id])->first();
				// Connect to Stripe
				\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
				// Create charity details array for update
				$update = array(
					'business_profile' 	=> array(
						'mcc'					=> '8398',
						'name'					=> $charity->details->charity_name,
						'product_description'	=> $charity->details->description_of_charity,
						'support_phone'			=> $charity->details->phone_number,
						'support_url'			=> $charity->details->charity_website,
						'url'					=> $charity->details->charity_website,
					),
					'company' 			=> array(
						'address'				=> array(
							'line1'					=> $charity->details->address_line_1,
							'line2'					=> $charity->details->address_line_2,
							'city'					=> $charity->details->address_town_city,
							'postal_code'			=> $charity->details->address_postcode,
							'country'				=> 'GB',
						),
						'phone'					=> $charity->details->phone_number,
					),
				);
				// Check if company reg is set
				if (@$charity->companies_house_number && $charity->companies_house_number != '') {
					$update['company']['tax_id'] = $charity->companies_house_number;
				} else {
					// As there is no company number, set charity commission reg instead
					$update['company']['tax_id'] = $charity->charity_registration_number;
				}
				// Check if VAT ID is set
				if (@$charity->details->vat_id && $charity->details->vat_id != '') {
					$update['company']['vat_id'] = $charity->details->vat_id;
				}
				// Create account in Stripe
				$account = \Stripe\Account::update($charity->payout_reference_id, $update);
				// Return account info
				return $account;
			}
		} catch (Exception $e) {
			return LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace()));
		}
		return false;
	}







	// Update charity account
	public static function upload_id_document($file) {
		try {

			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));


			$file = \Stripe\File::create([
				'file'		=> $file,
				'purpose'	=> 'identity_document',
			]);

			return json_encode($file);

		} catch (Exception $e) {


			return json_encode($e->getMessage());


			return LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace()));
		}
		return false;
	}






	// Update charity representative
	public static function update_representative($charity, $user_id) {
		try {
			// Set representative as data submitter
			DB::table('charities_representative')->where(['charity_id' => $charity->id])->update(['user_id' => $user_id]);
			// Remove staff is_representative data
			DB::table('charities_staff')->where(['charity_id' => $charity->id])->update(['is_representative' => false]);
			// Set staff profile as representative
			DB::table('charities_staff')->where(['charity_id' => $charity->id, 'user_id' => $user_id])->update(['is_representative' => true]);
			// Get info
			$rep = DB::table('charities_representative')->where(['charity_id' => $charity->id])->first();
			// Get rep user
			$rep->user = DB::table('users')->where(['id' => $rep->user_id])->first();
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Check if the representative already exists
			$existing_person = \Stripe\Account::allPersons(
  				$charity->payout_reference_id, array(
					'relationship' => array('representative' => true)
				)
			);
			// Update representative
			$update_data = array(
				'dob'					=> array(
					'day'					=> date('d', strtotime($rep->date_of_birth)),
					'month'					=> date('m', strtotime($rep->date_of_birth)),
					'year'					=> date('Y', strtotime($rep->date_of_birth)),
				),
				'address'				=> array(
					'line1'					=> $rep->address_line_1,
					'line2'					=> $rep->address_line_2,
					'city'					=> $rep->address_town_city,
					'postal_code'			=> $rep->address_postcode,
					'country'				=> 'GB',
				),
				'email'					=> $rep->user->email,
				'phone'					=> substr($rep->phone_number, 2),
				'first_name'			=> $rep->legal_firstname,
				'last_name'				=> $rep->legal_lastname,
				'metadata'				=> array(
					'trustee_number'		=> $rep->trustee_number,
				),
				'relationship'			=> array(
					'executive'				=> true,
					'representative'		=> true,
					'title'					=> 'Trustee',
				),
				'verification' 			=> array(
					'document'				=> array(
						'front'					=> null,
						'back'					=> null,
					),
					'additional_document'	=> null,
				),
			);


			// Check if the representative already exists
			$existing_account = \Stripe\Account::allExternalAccounts(
				$charity->payout_reference_id, array(
					'object' 	=> 'bank_account',
					'limit' 	=> 1
				)
			);
			// Check if account does not exist
			if (!@sizeof(@$existing_account->data[0]) > 0) {
				$existing_account = \Stripe\Account::createExternalAccount(
  					$charity->payout_reference_id, array(
						'external_account'	=> array(
							'object'			=> 'bank_account',
							'country'			=> 'GB',
							'currency'			=> 'gbp',
							'account_number'	=> '00012345',
							'routing_number'	=> '108800',
						)
					)
				);
			}


			return $existing_account;



			// Create account object








			// Get ID front file
			$file_id_front = DB::table('charity_files')->where(['charity_id' => $charity->id, 'file_intent' => 'id_front'])->orderBy('date_added', 'DESC')->first();
			// Check if file was found
			if ($file_id_front) {
				// Add item to update data
				$update_data['verification']['document']['front'] = $file_id_front->stripe_file_id;
			}


			// Get ID back file
			$file_id_back = DB::table('charity_files')->where(['charity_id' => $charity->id, 'file_intent' => 'id_back'])->orderBy('date_added', 'DESC')->first();
			// Check if file was found
			if ($file_id_back) {
				// Add item to update data
				$update_data['verification']['document']['back'] = $file_id_back->stripe_file_id;
			}


			// Get proof of address file
			$file_proof_of_address = DB::table('charity_files')->where(['charity_id' => $charity->id, 'file_intent' => 'proof_of_address'])->orderBy('date_added', 'DESC')->first();
			// Check if file was found
			if ($file_proof_of_address) {
				// Add item to update data
				$update_data['verification']['additional_document']['front'] = $file_proof_of_address->stripe_file_id;
			}



			// Check if person already exists
			if (@$existing_person['data'][0]->id) {
				// Update representative
				$update = \Stripe\Account::updatePerson($charity->payout_reference_id, $existing_person['data'][0]->id, $update_data);
			} else {
				// Create representative
				$update = \Stripe\Account::createPerson($charity->payout_reference_id, $update_data);
			}



			return $update;

		} catch (Exception $e) {
			return LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace()));
		}
		return false;
	}




	// Function to calculate donation fees
	public static function calculateFees($amount, $include_stripe_fee = true) {
		// Parse amount
		$amount = intval($amount);
		// Get fee information
		$fee_string = explode('|', env('MIN_FEE_FORMULA_PHP'));
		// Get fees from env string
		$fees_items = array(
			'stripe_percentage'		=> (float) $fee_string[0],
			'stripe_pounds'			=> (float) $fee_string[1],
			'dashdonate_pounds'		=> (float) $fee_string[2],
		);

		// Calculate fees
		$fees = $amount;

		$fees = $fees + ($fees_items['dashdonate_pounds'] * 100);

		$fees = $fees + ($fees_items['stripe_pounds'] * 100);

		$fees = floor($fees / $fees_items['stripe_percentage']);

		// Remove original amount from fees calculation
		$fees = $fees - $amount;

		// // Calculate fees
		// $fees = intval(ceil(($amount + round($fees_items['stripe_pounds'] * 100) + round($fees_items['dashdonate_pounds'] * 100)) / $fees_items['stripe_percentage']));
		// // Remove original amount from fees calculation
		// $fees = ($fees - $amount);

		// Return fees
		return intval($fees);
	}





}
