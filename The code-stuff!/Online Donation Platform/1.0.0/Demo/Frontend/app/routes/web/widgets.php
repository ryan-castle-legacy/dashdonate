<?php

use \App\Http\Controllers\DashDonate as API;


// Get donation widget
Route::post('/widget/donation/', function(Request $request) {

	// Get data
	$data = Request::all();

	// Send data to API to create paymentIntent
	$intent = API::donate_via_widget($data);

	return json_encode($intent);

}); // APPLY API MIDDLEWARE

// Get intent
Route::get('/widget/get-intent/{intent_id}', function(Request $request, $intent_id) {
	// Get paymentIntent
	$intent = API::get_intent($intent_id);

	return json_encode($intent);

}); // APPLY API MIDDLEWARE


Route::get('/widget/donation/secure-confirmation', function(Request $request) {
	echo '<script type="text/javascript">window.parent.postMessage("dd_3ds_donateForm_done", location.origin);</script>';
	return '3D Secure DONE';
}); // APPLY API MIDDLEWARE





// Get donation widget
Route::get('/widget/donation/{site_id}', function(Request $request, string $site_id) {
	// Get external website that is requesting the widget
	$ext_host = Request::server('HTTP_HOST');



	// Check if $ext_host and $site_id are a match and are allowed to show widget




	$charity_logo 		= 'https://dashdonate.org/img/logo.png';
	$charity_name 		= 'The Acme Corporation Foundation';
	$primary_colour		= '#1db87f';

	$powered_by_link 	= env('APP_URL', 'https://dashdonate.org');
	$show_credit 		= true;

	// Get widget view and turn into HTML code
	$html = view('widgets/donation', [
		'charity_site' 		=> $site_id,
		'charity_name' 		=> $charity_name,
		'charity_logo' 		=> $charity_logo,
		'powered_by_link' 	=> $powered_by_link,
		'show_credit' 		=> $show_credit,
		'primary_colour'	=> $primary_colour,
	])->render();
	// Holder for widget data
	$widget = array(
		'html'		=> $html,
	);
	// Send JSON object with widget info
	return json_encode($widget);
}); // APPLY API MIDDLEWARE
