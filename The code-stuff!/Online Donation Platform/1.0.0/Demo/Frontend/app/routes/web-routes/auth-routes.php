<?php

use \App\Http\Controllers\DashDonate as API;

// Auth::routes();

Route::get('/pre-signup', function() {
	$data = API::get_presignups();
	echo '<pre>';
	var_dump($data);
});

//
// Route::get('/home', function() {
// 	// Check if cookie exists
// 	if (Cookie::has('original_action')) {
// 		// Redirect user to original action and clear cookie
// 		return Redirect::to(Cookie::get('original_action'))->withCookie(Cookie::forget('original_action'));
// 	}
// 	// Return homepage
// 	return view('auth-views/home');
// })->middleware('auth')->name('home');
//
//
//
//
// // 'My profile' page
// Route::get('/account/profile', function() {
// 	return 'My profile';
// })->middleware('auth')->name('account-my_profile');
//
// // 'My profile' page
// Route::get('/account/settings', function() {
// 	return 'My settings';
// })->middleware('auth')->name('account-settings');
