<?php

use Illuminate\Http\Request;

// Include the Stripe controller
use \App\Http\Controllers\StripeController as DD_Stripe;
// Include the error logging controller (to aid finding and fixing bugs)
use \App\Http\Controllers\LogError;


require_once 'web/widgets.php';


Route::group(['middleware' => 'throttle:480,1'], function() {


	// Contribution to project route
	Route::post('/contribute-to-project', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();

			// Process contribution
			$contribution = DD_Stripe::process_contribution($data);


			return json_encode($contribution);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');

	Route::post('contribution/capture', function(Request $request) {
		try {
			// Extract data object from request
			$data = $request->all();
			// Capture payment
			$intent = DD_Stripe::capture_contribution($data['intent_id']);
			// Return new intent
			return json_encode($intent);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return data to user
		return json_encode(false);
	})->middleware('api_auth');

	Route::post('contribution/confirm', function(Request $request) {
		try {
			// Extract data object from request
			$data = $request->all();
			// Capture payment
			$intent = DD_Stripe::confirm_contribution($data['intent_id']);
			// Return new intent
			return json_encode($intent);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return data to user
		return json_encode(false);
	})->middleware('api_auth');

	// Return intent of a donation
	Route::get('/contribution/get-intent/{intent_id}', function($intent_id) {
		// Try getting donation
		try {
			// Get donation from Stripe
			$intent = DD_Stripe::get_contribution($intent_id);
			// Return donation intent
			return json_encode($intent);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return data to user
		return json_encode(false);
	})->middleware('api_auth');

	// Contribution to project route
	Route::post('/presignup', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Upload presignup
			$signup = DB::table('presignups')->insert([
				'email' => $data['email'],
				'type' 	=> $data['type'],
			]);
			return json_encode(true);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');




















	// Return user list to admin users
	Route::get('/admin/user-list/{limit}/{page}', function($limit, $page) {
		// Storage for users
		$users = array();
		// Try getting users
		try {
			// Check if there is a limit
			if ($limit != 0) {
				// Get limited amount
				$users = DB::table('users')->orderBy('id', 'DESC')->take($limit)->skip($page)->get();
			} else {
				// Get all records
				$users = DB::table('users')->orderBy('id', 'DESC')->get();
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return data to user
		return json_encode($users);
	})->middleware('api_auth');


	// Return donation list to admin users
	Route::get('/admin/donation-list/{limit}/{page}', function($limit, $page) {
		// Storage for donations
		$donations = array();
		// Try getting donations
		try {
			// Check if there is a limit
			if ($limit != 0) {
				// Get limited amount
				$donations = DB::table('donations')->select('*', 'users.name AS user_name', 'charities.name AS charity_name', 'charities.slug AS charity_slug', 'donations.updated_at AS donation_last_updated')->join('users', 'users.id', '=', 'donations.donor_id')->join('charities', 'charities.id', '=', 'donations.charity_id')->orderBy('donations.id', 'DESC')->take($limit)->skip($page)->get();
			} else {
				// Get all records
				$donations = DB::table('donations')->select('*', 'users.name AS user_name', 'charities.name AS charity_name', 'charities.slug AS charity_slug', 'donations.updated_at AS donation_last_updated')->join('users', 'users.id', '=', 'donations.donor_id')->join('charities', 'charities.id', '=', 'donations.charity_id')->orderBy('donations.id', 'DESC')->get();
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return data to user
		return json_encode($donations);
	})->middleware('api_auth');


	// Return charity list to admin users
	Route::get('/admin/charity-list/{limit}/{page}', function($limit, $page) {
		// Storage for charities
		$charities = array();
		// Try getting charities
		try {
			// Check if there is a limit
			if ($limit != 0) {
				// Get limited amount
				$charities = DB::table('charities')->select('*', 'charities.name AS charity_name', 'charities.id AS charity_id', 'charities.slug AS charity_slug', 'charities.date_created AS charity_date_created', 'users.name AS user_name', 'users.email AS owner_email')->join('users', 'users.id', '=', 'charities.owner_id')->orderBy('charities.id', 'DESC')->take($limit)->skip($page)->get();
			} else {
				// Get all records
				$charities = DB::table('charities')->select('*', 'charities.name AS charity_name', 'charities.id AS charity_id', 'charities.slug AS charity_slug', 'charities.date_created AS charity_date_created', 'users.name AS user_name', 'users.email AS owner_email')->join('users', 'users.id', '=', 'charities.owner_id')->orderBy('charities.id', 'DESC')->get();
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return data to user
		return json_encode($charities);
	})->middleware('api_auth');
































	// Return charity info
	Route::get('/charity/{slug}/{summary}', function($slug, $summary) {
		// Storage for charity info
		$charity = array();
		// Try getting charity info
		try {
			// Get charity info
			$charity = DB::table('charities')->where(['slug' => $slug])->first();
			// Check if charity was found
			if ($charity) {
				// Check if extra info is needed (not summary) was found
				if ($summary == 'false') {
					// Get extra info on charity
				}
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return data to user
		return json_encode($charity);
	})->middleware('api_auth');


	// Create charity account
	Route::post('/charity/new', function(Request $request) {
		try {
			// Get request data
			$data = $request->all();
			// Check if the charity has already been registered
			$exists = DB::table('charities')->where(['charity_registration_number' => $data['charity_reg_number'], 'verified' => true])->first();
			// Check if charity exists
			if ($exists) {
				// Return error that CRN is already used
				return json_encode('crn_in_use');
			} else {
				// Create charity record
				$charity = DB::table('charities')->insertGetId([
					'name'							=> $data['charity_name'],
					'slug'							=> '',
					'owner_id'						=> $data['owner_id'],
					'charity_registration_number'	=> $data['charity_reg_number'],
					'payout_reference_id'			=> '', // Stripe account ID
				]);
				// Return charity ID
				return json_encode($charity);

				// Add charity account in Stripe
				// $stripe_account = DD_Stripe::create_charity_account($charity, $data['ip']);
				// Return stripe account
				// return json_encode($stripe_account);
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
	})->middleware('api_auth');


	// Return payment settings for user
	Route::get('/payment/settings/{user_id}', function($user_id) {
		// Storage for settings
		$settings = array();
		// Try getting settings
		try {
			// Check if there is a stripe customer ID for user
			$customer_id = DB::table('users')->select(['stripe_customer_id'])->where(['id' => $user_id])->first();
			// Check if null
			if (@$customer_id->stripe_customer_id == null) {
				// Create customer in Stripe
				$settings['customer_id'] = DD_Stripe::create_stripe_customer($user_id);
			} else {
				// Add customer ID to array
				$settings['customer_id'] = $customer_id->stripe_customer_id;
			}
			// Get stripe source records
			$settings['sources'] = DB::table('users_payment_sources')
				->where(['user_id' => $user_id])->orderBy('date_added', 'DESC')->get();
			// Get past donations
			$settings['donations'] = DB::table('donations')->where(['donor_id' => $user_id])->orderBy('date_taken', 'DESC')->get();
			// Total value of donations to date (placeholder value)
			$settings['total_donated'] = 0;
			// Check if past donations were found
			if ($settings['donations'] && is_object($settings['donations'])) {
				// Loop through past donations
				for ($i = 0; $i < sizeof($settings['donations']); $i++) {
					$settings['total_donated'] += $settings['donations'][$i]->amount;
				}
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return data to user
		return json_encode($settings);
	})->middleware('api_auth');

	// Return payment sources for user
	Route::get('/payment/get-sources/{user_id}', function($user_id) {
		// Storage for sources
		$sources = array();
		// Try getting sources
		try {
			// Get stripe source records
			$sources = DB::table('users_payment_sources')->where(['user_id' => $user_id, 'is_valid' => true])->orderBy('date_added', 'DESC')->get();
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return data to user
		return json_encode($sources);
	})->middleware('api_auth');

	// Create payment source
	Route::post('/payment/sources/create', function(Request $request) {
		try {
			// Extract data object from request
			$data = $request->all();
			// Get user info
			$user = DB::table('users')->where(['id' => $data['user_id']])->first();
			// Check if user exists
			if ($user) {
				// Create source in Stripe
				$source = DD_Stripe::create_customer_source($user->stripe_customer_id, $data['stripe_token']);
				// Return source data
				return json_encode($source);
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return data to user
		return json_encode(false);
	})->middleware('api_auth');




	// Add payment source to user
	Route::post('/payment/sources/add', function(Request $request) {
		try {
			// Extract data object from request
			$data = $request->get('data');
			// Get user info
			$user = DB::table('users')->where(['id' => $data['user_id']])->first();
			// Check if user exists
			if ($user) {
				// Add source record to user
				$add_source = DB::table('users_payment_sources')->insert([
					'user_id'			=> $data['user_id'],
					'stripe_source_id'	=> $data['stripe_source_id'],
					'expiry_date'		=> $data['expiry_date'],
					'last_four_digits'	=> $data['last_four_digits'],
				]);
				// Check if source was added ok
				if ($add_source) {
					// Return success
					return json_encode(true);
				}
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return failure to add source
		return json_encode(false);
	})->middleware('api_auth');





























	Route::post('donation/capture', function(Request $request) {
		try {
			// Extract data object from request
			$data = $request->all();
			// Capture payment
			$intent = DD_Stripe::capture_donation($data['intent_id']);
			// Return new intent
			return json_encode($intent);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return data to user
		return json_encode(false);
	})->middleware('api_auth');



	Route::post('donation/confirm', function(Request $request) {
		try {
			// Extract data object from request
			$data = $request->all();
			// Capture payment
			$intent = DD_Stripe::confirm_donation($data['intent_id'], $data['charity_slug']);
			// Return new intent
			return json_encode($intent);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return data to user
		return json_encode(false);
	})->middleware('api_auth');



	// Return intent of a donation
	Route::get('/payment/get-intent/{donation_id}/{using_intent_id}', function($donation_id, $using_intent_id) {
		// Try getting donation
		try {
			if ($using_intent_id == 'false') {
				// Get donation
				$donation = DB::table('donations')->where(['id' => $donation_id])->first();
				// Check if donation was found
				if ($donation) {
					// Set ID
					$donation_id = $donation->paymentIntent_id;
				}
			}
			// Get donation from Stripe
			$intent = DD_Stripe::get_donation($donation_id);
			// Return donation intent
			return json_encode($intent);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return data to user
		return json_encode(false);
	})->middleware('api_auth');


	// Create payment source
	Route::post('/donation/new', function(Request $request) {
		try {
			// Extract data object from request
			$data = $request->all();
			// Get user info
			$user = DB::table('users')->where(['id' => $data['donor_id']])->first();
			// Currency needs to be DB driven
			$user->currency = 'gbp';
			// Check if user exists
			if ($user) {
				// Get charity info
				$charity = DB::table('charities')->where(['slug' => $data['charity_slug']])->first();
				// Check if charity exists
				if ($charity) {
					// Get card from ID (where user_id matches card owner)
					$card = DB::table('users_payment_sources')->where(['id' => $data['card_id'], 'user_id' => $user->id])->first();
					// Check if card was unable to be found
					if ($card == false) {
						// Failed to found card
						throw new Exception('Failed to find payment method');
					}
					// Make donation/charge in Stripe
					$donation = DD_Stripe::take_donation($user, $charity, $data['amount'], $data['fees'], $card);
					// Check if paymentIntent was created
					if ($donation && @$donation->status) {
						// Create donation record in database
						$record_id = DD_Stripe::log_donation($charity->id, $user->id, $data['amount'], $donation->id, DD_Stripe::calculate_fees($data['amount']), $donation->status, $data['anonymous']);
						// Check if recorded
						if ($record_id) {
							// Add local record ID to Stripe metadata
							$add_record = DD_Stripe::log_payment_local_record_id($donation->id, $record_id);
							// Add record to donation data
							$donation->metadata->local_id = $record_id;
							// Return intent/donation to the user to perform next actions
							return json_encode($donation);
						} else {
							throw new Exception('Failed to record PaymentIntent');
						}
					} else {
						// Throw error to user
						throw new Exception('Failed to create PaymentIntent');
					}
				}
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return data to user
		return json_encode(false);
	})->middleware('api_auth');







	// Add payment source to intent
	Route::post('/donation/add-card-to-intent', function(Request $request) {
		try {
			// Extract data object from request
			$data = $request->all();
			// Get card from database
			$card = DB::table('users_payment_sources')->where(['id' => $data['card_id']])->first();
			// Check card exists
			if ($card) {
				// Get donation from database
				$donation = DB::table('donations')->where(['id' => $data['donation_id']])->first();
				// Update intent
				$donation = DD_Stripe::update_intent_payment_method($card, $donation);
				// Return intent
				return json_encode($donation);
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return data to user
		return json_encode(false);
	})->middleware('api_auth');
























	Route::get('/pre-signups', function(Request $request) {
		try {
			// Get errors from database
			$errors = DB::table('presignups')->get();
			// Return errors
			return json_encode($errors);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return failure to log the error
		return json_encode(false);
	})->middleware('api_auth');




	// Log an error
	Route::post('/error-log', function(Request $request) {
		try {
			// Extract error object from request
			$data = $request->all();
			// Decode error
			$error = json_decode($data['error']);
			// Log error
			return json_encode(LogError::log_error($error['message'], $error['line'], json_encode($error['trace'])));
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return failure to log the error
		return json_encode(false);
	})->middleware('api_auth');


	// Resolve an error
	Route::post('/error-log/resolve', function(Request $request) {
		try {
			// Extract error object from request
			$data = $request->all();
			// Update record
			$update = DB::table('error_recording')->where([
				'id'	=> $data['error_id'],
			])->update([
				'resolved'		=> true,
				'date_resolved'	=> date('Y-m-d H:i:s', time()),
				'updated_at'	=> date('Y-m-d H:i:s', time()),
			]);
			// Check updated
			if ($update) {
				// Return success
				return json_encode(true);
			}
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return failure to log the error
		return json_encode(false);
	})->middleware('api_auth');


	// Get errors
	Route::get('/error-log', function(Request $request) {
		try {
			// Get errors from database
			$errors = DB::table('error_recording')->where(['resolved' => false])->limit('30')->orderBy('error_count', 'DESC')->get();
			// Return errors
			return json_encode($errors);
		} catch (Exception $e) {
			return json_encode(LogError::log_error($e->getMessage(), $e->getLine(), json_encode($e->getTrace())));
		}
		// Return failure to log the error
		return json_encode(false);
	})->middleware('api_auth');


});
