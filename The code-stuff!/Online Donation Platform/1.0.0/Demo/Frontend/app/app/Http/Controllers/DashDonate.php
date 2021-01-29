<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as APIRequest;
use Auth;
use DateTime;
use Exception;
use Redirect;


class DashDonate extends Controller
{



	public static function donate_via_widget($data) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/widget/donation', $data);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
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

	public static function get_intent($intent_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/widget/get-intent/'.$intent_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
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




	// Get error logs
	public static function get_presignups() {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/pre-signups');
			// Check response body is success
			if ($res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			// Throw error as request wasn't successful
			throw new Exception('Error in API request');
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
				'trace'		=> $e->getTrace(),
			);
			// Log error and return true or false as to whether the error was logged
			return DashDonate::log_error($error);
		}
	}

	// Get error logs
	public static function get_error_logs() {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/error-log');
			// Check response body is success
			if ($res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			// Throw error as request wasn't successful
			throw new Exception('Error in API request');
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
				'trace'		=> $e->getTrace(),
			);
			// Log error and return true or false as to whether the error was logged
			return DashDonate::log_error($error);
		}
	}


	// Send error to be logged
	public static function log_error($error) {
		$res = DashDonate::api_call('POST', '/error-log', ['error' => json_encode($error)]);
		// Return response
		return $res;
	}


	// Mark error resolved
	public static function resolve_error($error_id) {
		$res = DashDonate::api_call('POST', '/error-log/resolve', ['error_id' => $error_id]);
		// Return response
		return $res;
	}





















	// Get user list for admin
	public static function get_user_list($limit = 0, $page = 0) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/admin/user-list/'.$limit.'/'.$page);
			// Check response body is success
			if ($res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			// Throw error as request wasn't successful
			throw new Exception('Error in API request');
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

	// Get donation list for admin
	public static function get_donation_list($limit = 0, $page = 0) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/admin/donation-list/'.$limit.'/'.$page);
			// Check response body is success
			if ($res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			// Throw error as request wasn't successful
			throw new Exception('Error in API request');
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

	// Get charity list for admin
	public static function get_charity_list($limit = 0, $page = 0) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/admin/charity-list/'.$limit.'/'.$page);
			// Check response body is success
			if ($res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			// Throw error as request wasn't successful
			throw new Exception('Error in API request');
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




























	// Get charity information
	public static function get_charity($slug, $summary = false) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/charity/'.$slug.'/'.DashDonate::boolToString($summary));
			// Check response body is success
			if ($res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			// Throw error as request wasn't successful
			throw new Exception('Error in API request');
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


	// Create a charity account
	public static function create_charity_account($owner_id = 0, $charity_reg_number, $charity_name) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/charity/new', ['owner_id' => $owner_id, 'charity_reg_number' => $charity_reg_number, 'charity_name' => $charity_name]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
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


































	// Get payment settings of user who's logged in
	public static function get_payment_settings() {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/payment/settings/'.Auth::user()->id);
			// Check response body is success
			if ($res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			// Throw error as request wasn't successful
			throw new Exception('Error in API request');
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



	// Get donation intent
	public static function get_donation($donation_id, $using_intent_id = 'false') {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/payment/get-intent/'.$donation_id.'/'.$using_intent_id);
			// Check response body is success
			if ($res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			// Throw error as request wasn't successful
			throw new Exception('Error in API request');
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

	// Get payment sources for a user
	public static function get_user_payment_sources($user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/payment/get-sources/'.$user_id);
			// Check response body is success
			if ($res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			// Throw error as request wasn't successful
			throw new Exception('Error in API request');
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








































	public static function presignup($email, $type) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/presignup', ['email' => $email, 'type' => $type]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			// Return error info
			return json_decode($res);
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
	}



	// Contribute to project (anonymous donation essentially)
	public static function contribute_to_project($data) {
		try {

			// Format data
			if (!isset($data['get_in_touch'])) {
				$data['get_in_touch'] = 'off';
			}

			// Perform API request
			$res = DashDonate::api_call('post', '/contribute-to-project', ['data' => $data]);

			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}

			// Return error info
			return json_decode($res);

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
	}

	// Get donation intent
	public static function get_contribution($intent_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/contribution/get-intent/'.$intent_id);
			// Check response body is success
			if ($res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			// Throw error as request wasn't successful
			throw new Exception('Error in API request');
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

	public static function contribute_process_handle_intent($contribution) {
		// Check if contribution is the PaymentIntent object
		if ($contribution && @isset($contribution->status)) {
			// Switch contribution status to perform next steps
			switch ($contribution->status) {
				case 'requires_payment_method':
					// Handle contribution
					return DashDonate::contribute_process_donation_canceled();
				break;
				case 'requires_confirmation':
					// Handle confirmation
					return DashDonate::contribute_process_donation_canceled();
				break;
				case 'requires_action':
					// Handle sending user to authenticate page
					$contribution = DashDonate::contribute_process_donation_requires_confirmation($contribution);
					// Find next action item
					$next_action = $contribution->next_action->redirect_to_url->url;
					// Return redirection
					return Redirect::to($next_action);
				break;
				case 'processing':
					// Handle donation
					return DashDonate::contribute_process_donation_processing($contribution);
				break;
				case 'requires_capture':
					// Handle donation
					$donation = DashDonate::contribute_process_donation_requires_capture($contribution);
					// Handle new donation status
					return DashDonate::contribute_process_handle_intent($contribution);
				break;
				case 'canceled':
					// Handle donation
					return DashDonate::contribute_process_donation_canceled();
				break;
				case 'succeeded':
					// Handle donation success
					return DashDonate::contribute_process_donation_succeeded();
				break;
				default:
					// Handle donation
					return DashDonate::contribute_process_donation_canceled();
				break;
			}
		}
		return $contribution;
	}


	// Confirms paymentIntent and returns updated intent object
	public static function contribute_process_donation_requires_confirmation($intent) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/contribution/confirm', ['intent_id' => $intent->id]);
			// Check response body is success
			if ($res->status == 200) {
				// Decode response body
				$new_intent = json_decode($res->body);
				// Check if the result is an intent object
				if ($new_intent && @isset($new_intent->status)) {
					// Return new intent object
					return $new_intent;
				} else {
					throw new Exception('Error in API request - '.$res->body);
				}
			}
			// Throw error as request wasn't successful
			throw new Exception('Error in API request - '.$res->status);
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
		return $intent;
	}


	// Returns user to success page
	public static function contribute_process_donation_succeeded() {
		// Redirect to success route
		return Redirect::route('contribute_success');
	}

	// Send user to cancelled donation page
	public static function contribute_process_donation_canceled() {
		// Redirect to cancelled route
		return Redirect::route('contribution_failed');
	}

	// Sends user to 3D Secure authorisation page
	public static function contribute_process_donation_requires_action($intent) {
		// Find next action item
		$next_action = $intent->next_action->redirect_to_url->url;
		// Return redirection
		return Redirect::to($next_action);
	}

	// Sends user to page that notifies them that the payment is processing
	public static function contribute_process_donation_processing($intent) {
		// Redirect to processing route
		return Redirect::route('contribute_processing');
	}

	// Attempt capturing donation funds
	public static function contribute_process_donation_requires_capture($intent) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/contribution/capture', ['intent_id' => $intent->id]);
			// Check response body is success
			if ($res->status == 200) {
				// Decode response body
				$new_intent = json_decode($res->body);
				// Check if the result is an intent object
				if ($new_intent && @isset($new_intent->status)) {
					// Return new intent object
					return $new_intent;
				}
			}
			// Throw error as request wasn't successful
			throw new Exception('Error in API request');
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
		return $intent;
	}

















































	// Create payment source in Stripe
	public static function create_user_payment_source($token) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/payment/sources/create', ['user_id' => Auth::user()->id, 'stripe_token' => $token]);
			// Check response body is success
			if ($res->status == 200) {
				// Get source data
				$source = json_decode($res->body);
				// Check if source was created
				if (isset($source->id)) {
					// Add card to user account
					$added = DashDonate::add_payment_source(Auth::user()->id, $source->id, $source->exp_month, $source->exp_year, $source->last4);
					// Check if added
					if ($added) {
						// Return success
						return json_encode(true);
					} else {
						throw new Exception('Error adding source to user');
					}
				} else {
					throw new Exception('Error creating source');
				}
			}
			// Throw error as request wasn't successful
			throw new Exception('Error in API request');
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


	// Add payment source to user
	public static function add_payment_source($user_id, $source_id, $expiry_month, $expiry_year, $four_digits) {
		try {
			// Turn month number into name
			$month = DateTime::createFromFormat('!m', $expiry_month);
			$month_name = $month->format('F');
			// Format expiry date from 'MM/YY' to timestamp string
			$formatted_date = $month_name.' '.date('Y', strtotime('01/01/'.$expiry_year));
			// Create data object
			$data = array(
				'user_id'			=> $user_id,
				'stripe_source_id'	=> $source_id,
				'expiry_date'		=> date('Y-m-d H:i:s', strtotime('1st '.$formatted_date.' 00:00:00')),
				'last_four_digits'	=> $four_digits,
			);
			// Perform API request
			$res = DashDonate::api_call('post', '/payment/sources/add', ['data' => $data]);
			// Check response body is success
			if ($res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			// Throw error as request wasn't successful
			throw new Exception('Error in API request');
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


	// Take donation from user's account
	public static function take_donation($amount, $fees, $slug, $card_id, $anonymous = false) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/donation/new/', ['donor_id' => Auth::user()->id, 'amount' => $amount, 'fees' => $fees, 'charity_slug' => $slug, 'card_id' => $card_id, 'anonymous' => $anonymous]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
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
	}


	// Function to calculate donation fees
	public static function calculateMinimumDonationFees($amount) {
		// Get fee information
		$fee_string = explode('|', env('MIN_FEE_FORMULA_PHP'));
		// Get fees from env string
		$fees_items = array(
			'stripe_percentage'		=> floatval($fee_string[0]),
			'stripe_pounds'			=> floatval($fee_string[1]),
			'dashdonate_pounds'		=> floatval($fee_string[2]),
		);
		// Calculate fees and turn into pence
		$fees = ((($amount + $fees_items['stripe_pounds'] + $fees_items['dashdonate_pounds']) / $fees_items['stripe_percentage']) * 100);
		// Ceil sub-pence and divide back down to pence
		$fees = (ceil($fees) / 100);
		// Calculate minimum fee (take away donation amount from total calculated above)
		$fees = ($fees - $amount);
		// Return fees
		return $fees;
	}


	// Convert pounds (£) into pence (p) for Stripe payment
	public static function pounds_to_pence($pounds) {
		return (number_format(floatval($pounds), 2)) * 100;
	}


	// Encode donation ID
	public static function encode_donation_id($id) {
		$id = array(['donation_id' => $id]);
		$id = json_encode($id);
		$id = base64_encode($id);
		$id = urlencode($id);
		return $id;
	}


	// Decode donation ID
	public static function decode_donation_id($id) {
		$id = urldecode($id);
		$id = base64_decode($id);
		$id = json_decode($id);
		$id = $id[0]->donation_id;
		return $id;
	}


















	public static function donate_process_handle_intent($donation, $charity_slug) {
		// Check if donation is the PaymentIntent object
		if ($donation && @isset($donation->status)) {
			// Switch donation status to perform next steps
			switch ($donation->status) {
				case 'requires_payment_method':
					// Handle donation
					return DashDonate::donate_process_donation_requires_payment_method($donation, $charity_slug);
				break;
				case 'requires_confirmation':
					// Handle donation
					$donation = DashDonate::donate_process_donation_requires_confirmation($donation, $charity_slug);
					// Handle new donation status
					return DashDonate::donate_process_handle_intent($donation, $charity_slug);
				break;
				case 'requires_action':
					// Handle sending user to authenticate page
					return DashDonate::donate_process_donation_requires_action($donation);
				break;
				case 'processing':
					// Handle donation
					return DashDonate::donate_process_donation_processing($donation);
				break;
				case 'requires_capture':
					// Handle donation
					$donation = DashDonate::donate_process_donation_requires_capture($donation);
					// Handle new donation status
					return DashDonate::donate_process_handle_intent($donation, $charity_slug);
				break;
				case 'canceled':
					// Handle donation
					return DashDonate::donate_process_donation_canceled($donation);
				break;
				case 'succeeded':
					// Handle donation success
					return DashDonate::donate_process_donation_succeeded($donation->metadata->local_id);
				break;
				default:
					// Handle donation
					return DashDonate::donate_process_donation_unknown_status($donation);
				break;
			}
		}
		return $donation;
	}








	// Returns user to success page
	public static function donate_process_donation_succeeded($donation_id) {
		// Encode donation ID for url
		$donation_id = DashDonate::encode_donation_id($donation_id);
		// Redirect to success route
		return Redirect::route('charity-donate_success', ['donation_id' => $donation_id]);
	}


	// Confirms paymentIntent and returns updated intent object
	public static function donate_process_donation_requires_confirmation($intent, $charity_slug) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/donation/confirm', ['intent_id' => $intent->id, 'charity_slug' => $charity_slug]);
			// Check response body is success
			if ($res->status == 200) {
				// Decode response body
				$new_intent = json_decode($res->body);
				// Check if the result is an intent object
				if ($new_intent && @isset($new_intent->status)) {
					// Return new intent object
					return $new_intent;
				} else {
					throw new Exception('Error in API request - '.$res->body);
				}
			}
			// Throw error as request wasn't successful
			throw new Exception('Error in API request - '.$res->status);
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
		return $intent;
	}


	// Sends user to 3D Secure authorisation page
	public static function donate_process_donation_requires_action($intent) {
		// Find next action item
		$next_action = $intent->next_action->redirect_to_url->url;
		// Return redirection
		return Redirect::to($next_action);
	}


	// Sends user to page that notifies them that the payment is processing
	public static function donate_process_donation_processing($intent) {
		// Encode donation ID for url
		$donation_id = DashDonate::encode_donation_id($donation_id);
		// Redirect to processing route
		return Redirect::route('charity-donate_processing', ['donation_id' => $donation_id]);
	}







	// Add card to an intent object
	public static function add_card_to_intent($card_id, $donation_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/donation/add-card-to-intent', ['card_id' => $card_id, 'donation_id' => $donation_id]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			// Throw error as request wasn't successful
			throw new Exception('Error in API request');
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
		return $intent;
	}










	// Attempt capturing donation funds
	public static function donate_process_donation_requires_capture($intent) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/donation/capture', ['intent_id' => $intent->id]);
			// Check response body is success
			if ($res->status == 200) {
				// Decode response body
				$new_intent = json_decode($res->body);
				// Check if the result is an intent object
				if ($new_intent && @isset($new_intent->status)) {
					// Return new intent object
					return $new_intent;
				}
			}
			// Throw error as request wasn't successful
			throw new Exception('Error in API request');
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
		return $intent;
	}


	// Send user to cancelled donation page
	public static function donate_process_donation_canceled($intent) {
		// Encode donation ID for url
		$donation_id = DashDonate::encode_donation_id($donation_id);
		// Redirect to cancelled route
		return Redirect::route('charity-donate_cancelled', ['donation_id' => $donation_id]);
	}







	public static function donate_process_donation_requires_payment_method($intent, $charity_slug) {
		// Encode donation ID
		$donation_id = DashDonate::encode_donation_id($intent->metadata->local_id);
		// Redirect user to payment method adding page
		return Redirect::route('donation-card_needed', ['donation_id' => $donation_id]);
	}







	public static function donate_process_donation_unknown_status($intent) {

		// Log bug in database
		// Bug should be "unknown paymentIntent status - {STATUS HERE}" - Allows us to handle error

		// Return redirect to payment cancelled page
		return DashDonate::donate_process_donation_canceled($intent);
	}

























	//
	// public static function test() {
	// 	// Try action
	// 	try {
	// 		// Perform API request
	// 		$res = DashDonate::api_call('get', '/api-test');
	// 		// Check response body is success
	// 		if ($res->status == 200) {
	// 			// Return data to method caller
	// 			return json_decode($res->body);
	// 		}
	// 		// Throw error as request wasn't successful
	// 		throw new Exception('Error in API request');
	// 	} catch (Exception $e) {
	// 		// Create error info array
	// 		$error = array(
	// 			'message'	=> $e->getMessage(),
	// 			'line'		=> $e->getLine(),
	// 		);
	// 		// Return error
	// 		return $error;
	// 	}
	// }


	// public static function unsubscribe() {
	// 	// Get user info
	// 	$user = Auth::user();
	// 	// Send request
	// 	$res = NYFA_API::api_call('PUT', '/stripe/customer/plan/unsubscribe', ['user_id' => $user->id]);
	// 	// Return response
	// 	return json_decode($res->body);
	// }
	//
	// public static function get_user_plan() {
	// 	// Get user data from Authentication
	// 	$user = Auth::user();
	// 	// Perform request
	// 	$res = NYFA_API::api_call('GET', '/stripe/customer/plan/'.$user->id);
	// 	// Return response
	// 	return json_decode($res->body);
	// }
































	// Perform API Call
	protected static function api_call($method, $endpoint, $data = []) {
		try {
			// Create request object
			$api_req = new APIRequest();
			// Create request body array
			$api_req_body = [
				// Create headers
				'headers'	=> [
					'Authorization' => 'Bearer '.env('API_TOKEN'),
				],
				'json'		=> $data,
			];
			// Send request to API route
			$api_res = $api_req->request(strtoupper($method), env('API_URL').$endpoint, $api_req_body);
			// Create response object
			$response = (object)[];
			// Add response status and data to response object
			$response->status = $api_res->getStatusCode();
			$response->body = $api_res->getBody()->getContents();
			// Return response object
			return $response;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}


	public static function boolToString($bool) {
		// Check if boolean is true
		if ($bool) {
			return 'true';
		}
		return 'false';
	}

}
