<?php


use \App\Http\Controllers\DashDonate as API;




// Donating page
Route::get('/donate', function() {

	return view('public/donate');

})->name('public-donate');
