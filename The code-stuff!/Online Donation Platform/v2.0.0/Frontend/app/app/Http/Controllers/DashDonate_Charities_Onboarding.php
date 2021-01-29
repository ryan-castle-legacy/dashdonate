<?php


/*
 #	DashDonate_Charities_Onboarding.php
 #
 #	This file contains the functionality specific to charity account onboarding.
*/




// Include namespace
namespace App\Http\Controllers;


// Declare controllers
use Redirect;
use Request;
use Auth;
use Cookie;
use DB;




// Include controller for connecting to the API
use \App\Http\Controllers\DashDonate as API;




// Extend controller
class DashDonate_Charities_Onboarding extends Controller {




	// List of onboarding goals for charities
	public static function onboardingGoals() {
		// Array of goals
		$goals = array(
			array(
				'name'			=> 'capture',
				'icon'			=> 'fas fa-plus',
				'label'			=> 'We want to capture donations online.',
				'selected'		=> true,
			),
			array(
				'name'			=> 'grow',
				'icon'			=> 'fas fa-plus',
				'label'			=> 'We would like to grow our online following.',
				'selected'		=> true,
			),
			array(
				'name'			=> 'recurring',
				'icon'			=> 'fas fa-plus',
				'label'			=> 'We would like to increase monthly donations.',
				'selected'		=> true,
			),
			array(
				'name'			=> 'analytics',
				'icon'			=> 'fas fa-plus',
				'label'			=> 'We would like to learn more about our donation trends.',
				'selected'		=> false,
			),
			array(
				'name'			=> 'onetime',
				'icon'			=> 'fas fa-plus',
				'label'			=> 'We would like to increase one-off donations.',
				'selected'		=> false,
			),
			array(
				'name'			=> 'giftaid',
				'icon'			=> 'fas fa-plus',
				'label'			=> 'We would like to automate GiftAid.',
				'selected'		=> false,
			),
		);
		// Return onboarding goals
		return $goals;
	}




	// List of identification documents
	public static function typesOfIdentityDocument() {
		// Array of options
		$options = array(
			array(
				'name'				=> 'Passport',
				'back_required'		=> false,
			),
			array(
				'name'				=> 'Driving licence',
				'back_required'		=> false,
			),
		);
		// Return options
		return $options;
	}




	// Handle initial registration of charity goals
	public static function getStarted() {
		// Capture request data
		$data = Request::all();
		// Check if goals list is empty
		if (empty($data['goals_list'])) {
			// Send user back to goal selection
			return Redirect::back()->withErrors(['goals_list' => 'You must select at least one item from the list.']);
		} else {
			// Check if user is signed in
			if (Auth::check()) {
				// Send user to next step of onboarding
				return Redirect::route('charities-onboarding-capture_details');
			} else {
				// Send to email capture page
				return Redirect::route('public-onboarding-register')
					->withCookie(cookie('goals_list', $data['goals_list'], 45000))
					->withCookie(cookie('original_action', route('charities-onboarding-capture_details'), 45000));
			}
		}
	}




	// Handle onboarding of charities
	public static function captureDetails($stage = 'first') {
		// Capture request data
		$data = Request::all();
		// Switch stage
		switch ($stage) {
			case 'first':
				// Check if the CRN valid and is in use
				$crn = API::checkIfCRNIsInUse($data['crn']);
				// Switch the response
				switch ($crn) {
					case 'crn_in_use':
						// Return error
						return Redirect::back()->withErrors(['crn' => 'This charity is already registered on DashDonate.']);
					break;
					case 'invalid_crn':
						// Return error
						return Redirect::back()->withErrors(['crn' => 'This charity registration number is invalid.']);
					break;
					case 'valid':
						// Check if goals cookie exists
						if (@Request::cookie('goals_list')) {
							// Set goals string to stored value
							$registration_goals = Request::cookie('goals_list');
						} else {
							// Set goals string to empty
							$registration_goals = '';
						}
						// Create initial charity application
						$application = API::createInitialCharityApplication($data['crn'], Auth::user()->id, $registration_goals);
						// Check if the application was created successfully
						if (@$application->success === true && @$application->charity_slug) {
							// Redirect to next stage
							return Redirect::route('charities-onboarding-confirm_details',
								['charity_slug' => $application->charity_slug]
								)->withCookie(Cookie::forget('goals_list'));
						}
						// Switch errors
						switch ($application) {
							// Possible errors from API:
							// - invalid_crn
							// - crn_in_use
							// - no_user
							// - unverified_user
							// - commission_unsupported
							// - charities_insert_failed
							// - charities_staff_insert_failed
							// - charities_details_insert_failed
							default:
								// Return error code to CRN error banner
								return Redirect::back()->withErrors(['crn' => $application]);
							break;
						}
					break;
					default:
						// Return error
						return Redirect::back()->withErrors(['crn' => $crn]);
					break;
				}
			break;
		}
	}




	// Sends an email to invite someone to represent a charity
	public static function inviteRepresentative($charity_slug) {
		// Capture request data
		$data = Request::all();
		// Attempt sending invite email
		$invite = API::inviteRepresentativeToCharity($charity_slug, $data['email'], Auth::user()->id);
		// Use switch to interpret the success of sending the invite
		switch ($invite) {
			case 'sent':
				// Send user back with a success message
				return Redirect::back()->with(['success' => 'Your invite has been sent.']);
			break;
			case 'invalid_recipient':
				// Send user back with error message
				return Redirect::back()->withErrors(['email' => 'This email address is invalid.']);
			break;
			case 'already_staff':
				// Send user back with error message
				return Redirect::back()->withErrors(['email' => 'This person is already a part of your charity.']);
			break;
			default:
				// Send user back with error message
				return Redirect::back()->withErrors(['email' => 'Something went wrong, please try again.']);
			break;
		}
	}




	// Sends an email to invite someone to join a charity
	public static function inviteStaff($charity_slug) {
		// Capture request data
		$data = Request::all();
		// Attempt sending invite email
		$invite = API::inviteStaffToCharity($charity_slug, $data['email'], Auth::user()->id);
		// Use switch to interpret the success of sending the invite
		switch ($invite) {
			case 'sent':
				// Send user back with a success message
				return Redirect::back()->with(['success' => 'Your invite has been sent.']);
			break;
			case 'invalid_recipient':
				// Send user back with error message
				return Redirect::back()->withErrors(['email' => 'This email address is invalid.']);
			break;
			case 'already_staff':
				// Send user back with error message
				return Redirect::back()->withErrors(['email' => 'This person is already a part of your charity.']);
			break;
			default:
				// Send user back with error message
				return Redirect::back()->withErrors(['email' => 'Something went wrong, please try again.']);
			break;
		}
	}




	// Handles the invite for someone to represent a charity
	public static function handleRepresentativeInvite($invite_token) {
		// Process invite token
		$invite = API::handleInviteRepresentativeToCharity($invite_token);
		// Check if the invite was found
		if (@$invite->valid == true) {
			// Check if the visitor is already signed in to DashDonate
			if (@Auth::check()) {
				// Check if the logged in user is the same as the invite user
				if (@Auth::user()->email == $invite->invite_email) {
					// Display decision view
					return view('charities/onboarding/invite_decision', ['invite_token' => $invite_token, 'inviter' => $invite->invite_email]);
				} else {
					// Check whether user needs to register a new account for DashDonate to accept the invite
					if ($invite->must_register) {
						// Redirect user to page to handle next actions
						return Redirect::route('charities-invite-logout')
							->withCookie(cookie('register_email', $invite->invite_email, 45000))
							->withCookie(cookie('original_action', route('charities-invite', ['invite_token' => $invite_token]), 45000));
					}
					// Redirect user to page to handle next actions
					return Redirect::route('charities-invite-logout_existing')
						->withCookie(cookie('login_email', $invite->invite_email, 45000))
						->withCookie(cookie('original_action', route('charities-invite', ['invite_token' => $invite_token]), 45000));
				}
			} else {
				// Check whether user needs to register a new account for DashDonate to accept the invite
				if ($invite->must_register) {
					// Redirect user to page to handle next actions
					return Redirect::route('charities-invite-register')
						->withCookie(cookie('register_email', $invite->invite_email, 45000))
						->withCookie(cookie('original_action', route('charities-invite', ['invite_token' => $invite_token]), 45000));
				}
				// Redirect user to login
				return Redirect::route('login')
					->withCookie(cookie('login_email', $invite->invite_email, 45000))
					->withCookie(cookie('original_action', route('charities-invite', ['invite_token' => $invite_token]), 45000));
			}
		}
		// Switch the status of the invite
		switch ($invite) {
			case 'expired_date': case 'not_representative_invite': case 'already_handled':
				// Redirect user to expired page
				return Redirect::route('charities-invite-expired');
			break;
			case 'invalid_token': case 'not_found': default:
				// Send to 404 error page
				return Redirect::route('error-404');
			break;
		}
	}




	// Handles the response to the invite for someone to represent a charity
	public static function handleRepresentativeInviteResponse($invite_token) {
		// Process invite token
		$invite = API::handleInviteRepresentativeToCharity($invite_token);
		// Check if the invite was found
		if (@$invite->valid == true) {
			// Check if the visitor is already signed in to DashDonate
			if (@Auth::check()) {
				// Check if the logged in user is the same as the invite user
				if (@Auth::user()->email == $invite->invite_email) {
					// Get request data
					$data = Request::all();
					// Check that response is set
					if ($data['response']) {
						// Switch response
						switch ($data['response']) {
							case 'accept':
								// Accept invitation
								$response = API::respondInviteRepresentativeToCharity($invite_token, 'accept');
								// Check if response was a success and that the slug has been found
								if (@$response->charity_slug) {
									// Send user to charity dashboard/onboarding
									return Redirect::route('charities-dashboard', ['charity_slug' => $response->charity_slug]);
								}
							break;
							case 'decline':
								// Decline invitation
								$response = API::respondInviteRepresentativeToCharity($invite_token, 'decline');
								// Check if response was success
								if ($response) {
									// Send user to homepage
									return Redirect::route('home');
								}
							break;
						}
					}
				}
			}
		}
		// User needs to be sent to processing page
		return Redirect::route('charities-invite', ['invite_token' => $invite_token]);
	}




	// Sends an email to invite someone to represent a charity
	public static function captureCheckRepresentativeDetails($charity_slug) {
		// Capture request data
		$data = Request::all();
		// Check if trustee ID was empty
		if (@$data['trustee_id'] && strlen(trim($data['trustee_id'])) > 0) {
			// Handle validation that we can capture representative details
			$trustee = API::validateCharityTrustee($charity_slug, $data['trustee_id']);
			// Check trustee was found
			if ($trustee && @$trustee->trustee_number) {
				// Send user to representative personal info form
				return Redirect::route('charities-onboarding-collect_representative_personal', ['charity_slug' => $charity_slug, 'trustee_id' => $trustee->trustee_number]);
			} else {
				// Handle errors
				switch ($trustee) {
					default:
						// Return back with error
						return Redirect::back()->withErrors(['trustee_id' => 'The trustee you selected was not valid for this charity.']);
					break;
				}
			}
		} else {
			// Return back with error
			return Redirect::back()->withErrors(['trustee_id' => 'The trustee you selected was not valid for this charity.']);
		}
	}




	// Capture data from representative personal details form
	public static function captureRepresentativePersonalDetails($charity_slug) {
		// Capture request data
		$data = Request::all();
		// Check if trustee ID was empty
		if (@$data['trustee_id'] && strlen(trim($data['trustee_id'])) > 0) {
			// Handle validation that we can capture representative details
			$trustee = API::validateCharityTrustee($charity_slug, $data['trustee_id']);
			// Check trustee was found
			if ($trustee && @$trustee->trustee_number) {
				// Set representative info in database
				$trustee = API::createDashDonateRepresentative($charity_slug, $data, Auth::user()->id);
				// Handle response
				if ($trustee && @$trustee->success == true) {
					// Need to create/update connected account
					$connected_account = API::refreshCharityStripeAccount($charity_slug, Request::ip());
					// Check if account was refreshed
					if ($connected_account === true) {
						// Send to ID document collection page
						return Redirect::route('charities-onboarding-collect_representative_id', ['charity_slug' => $charity_slug]);
					} else {
						// Return back with error
						return Redirect::back()->withInput()->withErrors(['trustee_id' => 'Something went wrong, please try again.', 'err_report' => $connected_account]);
					}
				} else {
					// Return back with error
					return Redirect::back()->withInput()->withErrors($trustee);
				}
			}
		}
		// Return back with error
		return Redirect::back()->withInput()->withErrors(['trustee_id' => 'Something went wrong, please try again.', 'err_report' => $trustee]);
	}




	// Capture data from representative personal details form
	public static function submitIdentificationForRepresentative($charity_slug) {
		// Submit representative data to Stripe
		$representative = API::submitRepresentativeIdentificationStripe($charity_slug);
		// Send to charity dashboard
		return Redirect::route('charities-dashboard', ['charity_slug' => $charity_slug])->with(['success' => 'Your identification documents have been uploaded.']);
	}




	// Capture data from charity proof of address form
	public static function submitRegisteredAddressDocument($charity_slug) {
		// Submit charity proof of address data to Stripe
		$document = API::submitProofOfAddressToStripe($charity_slug);
		// Send to charity dashboard
		return Redirect::route('charities-dashboard', ['charity_slug' => $charity_slug])->with(['success' => 'Your document has been uploaded.']);
	}




	// Capture bank account details for a charity
	public static function captureCharityBankDetails($charity_slug) {
		// Capture request data
		$data = Request::all();
		// Submit bank details via API
		$bank_details = API::updateCharityBankDetails($charity_slug, Auth::user()->id, $data['sort_code'], $data['account_number']);
		// Check for success
		if (@$bank_details->id) {
			// Send to charity dashboard
			return Redirect::route('charities-dashboard', ['charity_slug' => $charity_slug])->with(['success' => 'Your charity\'s bank details have been updated.']);
		} else {
			// Decode error message
			$error = json_decode($bank_details);
			// Get error code from trace
			$error_code = @((json_decode($error->trace)[0])->args[5]);
			// Check if error trace didn't find anything
			if ($error_code == '') {
				// Replace with error from API
				$error_code = $bank_details;
			}
			// Switch error codes
			switch (@$error_code) {
				case 'invalid_sortcode':
					// Set message
					$message = 'This sort code is invalid.';
				break;
				case 'invalid_account_number':
					// Set message
					$message = 'This bank account number is invalid.';
				break;
				case 'bank_account_unusable':
					// Set message
					$message = 'This bank account does not support transfers to and from your account.';
				break;
				default:
					// Set message
					$message = 'Something went wrong when updating your bank details.';
				break;
			}
			// Redirect with error message
			return Redirect::back()->withInput()->withErrors(['error' => $message]);
		}
	}




}
