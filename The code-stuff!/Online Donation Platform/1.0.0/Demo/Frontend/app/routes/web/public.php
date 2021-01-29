<?php

use \App\Http\Controllers\DashDonate as API;





Route::get('/', function() {

	echo '<title>Donation Widget</title>';
	echo "<meta name='viewport' content='width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no'/>";
	echo '<style>body { margin: 20px; }</style>';





	// Add stylesheet
	echo '<link rel="stylesheet" href="'.asset('widgets/donation.css').'"/>';
	// Add DashDonate donation widget to page
	echo '<script src="'.asset('widgets/donation.js').'"></script>';
	echo '<script>window.DashDonate=window.DashDonate||{};window.DashDonate.site="DD-1234";</script>';


	// Add DashDonate form's canvas
	echo '<div id="dd_donation_form"></div>';

});
