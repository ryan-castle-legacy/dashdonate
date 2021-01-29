<?php

use \App\Http\Controllers\DashDonate as API;




// Send widget DOM
Route::post('/widget/donate/process-payment', function(Request $request) {
	try {
		// Get data from request
		$data = Request::all();
		// Send widget data to the API
		$response = API::sendWidgetDataForDonationProcessing($data);
		// Return response to JS
		return json_encode($response);
	} catch (Exception $e) {
		// Return error
		return json_encode(['message' => $e->getMessage(), 'line' => $e->getLine(), 'trace' => json_encode($e->getTrace())]);
	}
})->middleware('ajax_widget');




// Send widget DOM
Route::put('/widget/donate/{apiKey?}', function(Request $request, $apiKey = false) {
	try {


		// Default state of widget
		$isEnabled					= false;
		// Pre-filling of email input
		$emailPrefilled				= false;
		// Pre-filling of card input
		$cardPrefilled				= false;
		// Get user session data
		$userSession 				= Request::get('session');
		// Get host website (The website where the widget is being requested from)
		$hostWebsite 				= Request::header('host');
		// Get host webpage (The webpage where the widget is being requested from)
		$hostWebpage 				= Request::header('referer');
		// Get referer webpage (The webpage where the user was directed from to the donation page)
		$referer 					= $userSession['referer'];
		// Check if referer is empty
		if ($referer == '') {
			// Set value
			$referer = 'none';
		}
		// Get user agent (type of device being used)
		$userAgent 					= Request::header('user-agent');
		// User's CSRF token
		$csrfToken 					= Request::header('x-csrf-token');
		// Get host webpage title
		$hostPageTitle 				= $userSession['pageTitle'];
		// Get session start time
		$startTime 					= $userSession['startDateStamp'];
		// Get session start time and parse it (It will be UTC - same as GMT)
		$startTime 					= date('Y-m-d H:i:s e', strtotime($userSession['startDateStamp']));
		// Check if request was made with HTTPS
		$isHTTPS 					= Request::secure();
		// Check if request was made from DashDonate.org
		$viaDashDonate				= false;
		// Default value
		$isFundraisingPage 			= false;
		// Default value
		$fundraiserName				= '';
		// Default value
		$donorUserId				= null;
		// List of DashDonate origins
		$dashdonateOrigins 			= array(
			'ec2-0-0-0-0.eu-west-2.compute.amazonaws.com',
			'dashdonate.org',
		);


		// Check if host site is DashDonate.org
		if (in_array($hostWebsite, $dashdonateOrigins)) {
			// Set value to allow logged-in users to skip email input
			$viaDashDonate 	= true;
			$isHTTPS 		= true;
			// If they are logged in on DashDonate.org
			if (@Auth::check()) {
				// Set donor ID
				$donorUserId = Auth::user()->id;
				// Pre-filling of email input
				$emailPrefilled = Auth::user()->email;
				// Pre-filling of card input
				$cardPrefilled = API::getUserBillingSettings($donorUserId);
			}
			// Enable widget
			$isEnabled = true;
		} else {
			// NOTE: For now, the widget is not allowed on other sites so no need to write code here

				// - If authorised website for the charity

			// Disallow use of widget
			$isEnabled = false;
		}


		// Get charity data
		$charity = API::getCharityByAPIKey($apiKey);
		// Check if charity does not exists or that it is not published
		if (!$charity || $charity->is_activated_for_public == false) {
			// Set as not enabled
			$isEnabled = false;
		}


		// Check if the widget session is not enabled
		if (!$isEnabled === true) {
			// Set session data
			$session = array(
				'enabled'					=> false,
			);
		} else {
			// Create session token for tracking
			$sessionToken = 'ddws_'.sha1('widget-session'.sha1(time().rand()).'DashDonate.org');
			// // Save session to database
			API::saveWidgetSession([
				'session_token'			=> $sessionToken,
				'session_start'			=> $startTime,
				'host_website'			=> $hostWebsite,
				'host_webpage'			=> $hostWebpage,
				'host_webpage_title'	=> $hostPageTitle,
				'referer_url'			=> $referer,
				'user_agent'			=> $userAgent,
				'csrf_token'			=> $csrfToken,
				'user_id'				=> $donorUserId,
				'charity_id'			=> $charity->id,
			]);


			// Check if host page is a fundraiser page
			if ($isFundraisingPage === true) {

				// Not needed until fundraising pages feature exists

			} else {
				// Set sharing contents for charity page
				$sharingLink			= 'https://dashdonate.org/charities/'.$charity->slug;
				$sharingPrewritten		= 'I\'m supporting '.$charity->details->display_name.' via DashDonate.org, take a look at the amazing work they are doing!';
				$sharingSubject			= 'I\'m supporting '.$charity->details->display_name.'!';
				$sharingBody			= 'I\'m supporting '.$charity->details->display_name.' via DashDonate.org, take a look at the amazing work they are doing!'."\n\n".$sharingLink;
			}


			// Set session data
			$session = array(
				'token'						=> $sessionToken,
				'enabled'					=> true,
				'minimumDonation'			=> 1.00,
				'feeFormula'				=> array(
					'percentage'			=> env('FEE_CALC_PERCENTAGE'),
					'pence'					=> env('FEE_CALC_PENCE'),
					'penceStripe'			=> env('FEE_CALC_PENCE_STRIPE'),
					'penceDD'				=> env('FEE_CALC_PENCE_DD'),
					'percentageStripe'		=> env('FEE_CALC_PERCENTAGE_STRIPE'),
					'percentageDD'			=> env('FEE_CALC_PERCENTAGE_DD'),
				),
				'stripePublicKey'			=> env('STRIPE_PK'),
				'stripeSDK'					=> 'https://js.stripe.com/v3/',
				'stripeStyles'				=> array(
					'base'						=> array(
						'color'						=> '#000000',
						'textTransform'				=> 'uppercase',
						'fontFamily'				=> 'sans-serif',
						'fontSmoothing'				=> 'antialiased',
						'fontSize'					=> '22px',
						'::placeholder'				=> array(
							'color'						=> '#aab7c4',
						),
					),
					'invalid'					=> array(
						'color'						=> '#fa755a',
						'iconColor'					=> '#fa755a',
					),
				),
				'stripeStylesCVCExpiry'		=> array(
					'base'						=> array(
						'color'						=> '#000000',
						'textTransform'				=> 'uppercase',
						'textAlign'					=> 'left',
						'fontFamily'				=> 'sans-serif',
						'fontSmoothing'				=> 'antialiased',
						'fontSize'					=> '14px',
						'::placeholder'				=> array(
							'color'						=> '#aab7c4',
						),
					),
					'invalid'					=> array(
						'color'						=> '#fa755a',
						'iconColor'					=> '#fa755a',
					),
				),
				'sharingLink'				=> $sharingLink,
				'sharingPrewritten'			=> $sharingPrewritten,
				'sharingSubject'			=> $sharingSubject,
				'sharingBody'				=> $sharingBody,
			);
		}


		// Convert commission name to readable
		switch ($charity->commission_name) {
			case 'englandWales':
				$charity->commission_name = 'England and Wales';
			break;
		}


		// Get widget for rendering to the user
		$widget = view('widgets/donation', [
			'session'				=> $session,
			'emailPrefilled'		=> $emailPrefilled,
			'cardPrefilled'			=> $cardPrefilled,
			'charityInfo'			=> array(
				'name'					=> $charity->details->display_name,
				'logoURL'				=> env('S3_URL').$charity->details->logo->s3_url,
				'commissionName'		=> $charity->commission_name,
				'registrationNumber'	=> $charity->charity_registration_number,
				'thank_you_title'		=> 'Thank you for your support!',
				'thank_you_message'		=> 'It makes a huge difference to our cause.',
			),
			'defaultDonation'		=> array(
				'now'					=> 10.00,
				'scheduled'				=> 25.00,
				'repeating'				=> 15.00,
			),
			'giftaidInfoURL'		=> 'https://www.gov.uk/donating-to-charity/gift-aid',
			'accountURL'			=> 'https://dashdonate.org/account',
			'isFundraisingPage'		=> $isFundraisingPage,
			'fundraiserName'		=> $fundraiserName,
		])->render();
		// Send widget data as JSON object
		return json_encode(['session' => $session, 'widget' => $widget]);
	} catch (Exception $e) {
		// Return error
		return json_encode(['message' => $e->getMessage(), 'line' => $e->getLine(), 'trace' => json_encode($e->getTrace())]);
	}
})->middleware('ajax_widget');
