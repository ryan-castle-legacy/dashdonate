<?php

use \App\Http\Controllers\DashDonate as API;




Route::get('/widgets/donation.min.js', function(Request $request) {

	// Set file as JS
	header('Content-Type: application/javascript');

	// Toggle logs
	$show_logs = true;

	// Get widget JS code
	$code = file_get_contents('../public/widgets/donation.js');

	// Check if dev not server
	if (env('APP_ENV') != 'dev') {
		// Replace dev URL with live URL
		$code = str_replace('http://ec2-0-0-0-0.eu-west-2.compute.amazonaws.com', 'https://dashdonate.org', $code);
	}

	// Pattern for comments
	$pattern = '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\')\/\/.*))/';
	// Replace comments
	$code = preg_replace($pattern, '', $code);

	// Check if dev not server
	if (!$show_logs && env('APP_ENV') != 'dev') {
		// Remove console logs
		$code = str_replace("console.log(response);", 						'', 		$code);
		$code = str_replace("console.log(data);", 							'', 		$code);
		$code = str_replace("console.log('Needs payment method');", 		'', 		$code);
		$code = str_replace("console.log('Error:');", 						'', 		$code);
		$code = str_replace("console.log('Error:');", 						'', 		$code);
		$code = str_replace("console.log(xhr.status);", 					'', 		$code);
		$code = str_replace("console.log(xhr.responseText);", 				'', 		$code);
		$code = str_replace("console.log('X');", 							'', 		$code);
		$code = str_replace("console.clear();", 							'', 		$code);
	}

	// Replace non-functional items
	$code = str_replace("\n", 		'', 		$code);
	$code = str_replace('	', 		'', 		$code);
	$code = str_replace(': \'', 	':\'', 		$code);
	$code = str_replace(': {', 		':{', 		$code);
	$code = str_replace(') {', 		'){', 		$code);
	$code = str_replace('= ', 		'=', 		$code);
	$code = str_replace(' =', 		'=', 		$code);
	$code = str_replace('} else', 	'}else', 	$code);
	$code = str_replace('else {', 	'else{', 	$code);
	$code = str_replace('; }', 		';}', 		$code);
	$code = str_replace('if (', 	'if(', 		$code);
	$code = str_replace('{ ', 		'{', 		$code);
	$code = str_replace('} ', 		'}', 		$code);
	$code = str_replace(' !=', 		'!=', 		$code);
	$code = str_replace(', ', 		',', 		$code);
	$code = str_replace('+ ', 		'+', 		$code);
	$code = str_replace(' +', 		'+', 		$code);
	$code = str_replace(' &&', 		'&&', 		$code);
	$code = str_replace('&& ', 		'&&', 		$code);
	$code = str_replace(' (', 		'(', 		$code);
	$code = str_replace(') ', 		')', 		$code);
	$code = str_replace('; ', 		';', 		$code);
	$code = str_replace(' <', 		'<', 		$code);
	$code = str_replace('< ', 		'<', 		$code);

	// Output code
	echo $code;
});



//
// // Get donation widget
// Route::post('/widget/donation/', function(Request $request) {
// 	// Get data
// 	$data = Request::all();
// 	// Send data to API to create paymentIntent
// 	$intent = API::donate_via_widget($data);
// 	// Return intent
// 	return json_encode($intent);
// }); // APPLY API MIDDLEWARE
//



// // Get intent
// Route::get('/widget/get-intent/{intent_id}', function(Request $request, $intent_id) {
// 	// Get paymentIntent
// 	$intent = API::get_intent($intent_id);
//
// 	return json_encode($intent);
//
// }); // APPLY API MIDDLEWARE




// Route::get('/widget/donation/secure-confirmation', function(Request $request) {
// 	echo '<script type="text/javascript">window.parent.postMessage("dd_3ds_donateForm_done", location.origin);</script>';
// 	return '3D Secure DONE';
// }); // APPLY API MIDDLEWARE
























//
//
// // Get donation widget
// Route::get('/widget/donation/{site_id}/{email_prefil?}', function(Request $request, string $site_id, $email_prefil = '') {
// 	try {
//
// 		// Get charity that has a site ID as sent over
// 		$charity = DB::table('charities')->where(['api_site_id' => $site_id])->first();
//
//
// 		// Set defaults
// 		$is_https 					= Request::secure();
// 		$is_authorised 				= false;
// 		$is_on_dashdonate			= false;
// 		$intent_id 					= '';
// 		$charity_logo 				= 'https://dashdonate.org/img/logo.png';
// 		$primary_colour				= '#1db87f';
// 		$powered_by_link 			= env('APP_URL', 'https://dashdonate.org');
// 		$show_credit 				= true;
// 		$email_prefillable			= false;
// 		$email_prefillable_value	= '';
// 		$stripe_pk					= '';
// 		$is_activated				= false;
// 		$initial_stage 				= 'disabled';
//
//
// 		// List DashDonate.org origins
// 		$dashdonate_origins = array(
// 			'ec2-0-0-0-0.eu-west-2.compute.amazonaws.com',
// 			'demo.dashdonate.org',
// 			'dashdonate.org',
// 		);
// 		// Check if origin is in allowed origins list
// 		if (in_array(Request::header('host'), $dashdonate_origins)) {
// 			// Set value to allow logged-in users to skip email input
// 			$is_on_dashdonate = true;
// 			$is_https = true;
// 		}
//
//
// 		// Check if charity was found
// 		if ($charity && $is_https) {
// 			// Get allow sites for this charity
// 			$allowed_sites = DB::table('authorised_websites')->where(['charity_id' => $charity->id, 'is_enabled' => true])->get();
// 			// Loop through authorised sites
// 			for ($i = 0; $i < sizeof($allowed_sites); $i++) {
// 				// Check for match
// 				if (parse_url($allowed_sites[$i]->website_url, PHP_URL_HOST) == Request::header('host')) {
// 					// Set as authorised
// 					$is_authorised = true;
// 				}
// 			}
// 			// Check if authorised
// 			if ($is_authorised || $is_on_dashdonate) {
// 				// Get charity full info
// 				$charity = API::getCharityBySlug($charity->slug);
// 				// Check if widget is disabled
// 				if ($charity && $charity->is_activated_for_public == true) {
// 					// Set Stripe key
// 					$stripe_pk = env('STRIPE_PK');
// 					// Set is activated
// 					$is_activated = true;
// 					// Create initial intent
// 					$intent = API::initialiseWidgetIntent($site_id);
// 					// Set defaults
// 					$intent_id = $intent->id;
// 					// Trim and remove empty characters from email
// 					$email_prefil = trim(str_replace(' ', '', $email_prefil));
// 					// Check if charity is pre-selected
// 					if ($charity) {
// 						// Set initial stage
// 						$initial_stage = 'amount';
// 					} else {
// 						// Set initial stage
// 						$initial_stage = 'charity';
// 					}
// 					// Check if widget is on DashDonate site
// 					if ($is_on_dashdonate && $email_prefil != '') {
// 						// Check if email is a registered and approved DashDonate user
// 						if (API::checkIfUserExists($email_prefil) == true) {
// 							// Set prefill values
// 							$email_prefillable = true;
// 							$email_prefillable_value = $email_prefil;
// 						} else {
// 							// Empty as user is not registered
// 							$email_prefillable_value = $email_prefil;
// 						}
// 					}
// 				}
// 			}
// 		}
//
//
//
//
// 		// Create a random token for this widget session
// 		$widget_session = 'ddws_'.sha1('widget-session'.sha1(time().rand()).'DashDonate.org');
// 		// Get CSRF token
// 		$csrf_token = csrf_token();
// 		// Save session to database
// 		DB::table('donation_sessions')->insert([
// 			'session_token'	=> $widget_session,
// 			'csrf_token'	=> $csrf_token,
// 			'date_updated'	=> date('Y-m-d H:i:s', time()),
// 			'user_id'		=> null,
// 			'site_id'		=> $charity->id,
// 			'active_url'	=> Request::header('host'),
//         ]);
//
//
//
//
// 		// Get widget view and turn into HTML code
// 		$html = view('widgets/donation', [
// 			'csrf_token'				=> $csrf_token,
// 			'widget_session'			=> $widget_session,
// 			'is_activated'				=> $is_activated,
// 			'is_on_dashdonate'			=> $is_on_dashdonate,
// 			'charity'					=> $charity,
// 			'intent_id'					=> $intent_id,
// 			'site_id'					=> $site_id,
// 			'giftaid_eligible'			=> true,
// 			'initial_stage'				=> $initial_stage, // Can be set as 'charity' if no charity chosen
// 			'charity_chosen'			=> true, // Can be set to false if not chosen
// 			'charity_site' 				=> $site_id,
// 			'charity_logo' 				=> $charity_logo,
// 			'powered_by_link' 			=> $powered_by_link,
// 			'show_credit' 				=> $show_credit,
// 			'primary_colour'			=> $primary_colour,
// 			'email_prefillable'			=> $email_prefillable,
// 			'email_prefillable_value'	=> $email_prefillable_value,
// 			'stripe_pk'					=> $stripe_pk,
// 		])->render();
// 		// Holder for widget data
// 		$widget = array(
// 			'html'		=> $html,
// 		);
// 		// Send JSON object with widget info
// 		return json_encode($widget);
// 	} catch (Exception $e) {
// 		// Return error message
// 		return json_encode($e->getMessage());
// 	}
// })->middleware('ajax_widget');
