<?php


// Terms of service page for public
Route::get('/legal/terms-of-service', function() {

	return 'Terms';

})->name('public-legal_terms');




// Privacy policy page for public
Route::get('/legal/privacy-policy', function() {

	return 'Privacy';

})->name('public-legal_privacy');




// Terms page for connected charities
Route::get('/legal/connected-charities', function() {

	return 'Terms of Connected Charities';

})->name('public-terms_connected_charities');
