<?php


/*
 #	dashboard.php
 #
 #	This file contains routes relating to the public dashboard
*/




// Include controller for onboarding
use \App\Http\Controllers\DashDonate as API;




// Dashboard main page
Route::get('/dashboard/', function(Request $request) {

	// Get user's dashboard data
	$dashboard_data = API::getUserDashboard(Auth::user()->id);

	// Return view
	return view('public/dashboard/dashboard', ['dashboard_data' => $dashboard_data]);

})->middleware('auth', 'verified_user')->name('public-dashboard');




// Dashboard donation listing page
Route::get('/dashboard/donations', function(Request $request) {

	// Get user's donations
	$donation_data = API::getUserDonations(Auth::user()->id);

	// List of days
	$dateDays = array('1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th', '12th', '13th', '14th', '15th', '16th', '17th', '18th', '19th', '20th', '21st', '22nd', '23rd', '24th', '25th', '26th', '27th', '28th');
	// List of weekdays
	$dateWeekdays = array('Sunday', 'Monday', 'Tueday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

	// echo '<pre>';
	// var_dump($donation_data);
	// return;

	// Return view
	return view('public/dashboard/donations', ['donation_data' => $donation_data, 'dateDays' => $dateDays, 'dateWeekdays' => $dateWeekdays]);

})->middleware('auth', 'verified_user')->name('public-dashboard-donations');
