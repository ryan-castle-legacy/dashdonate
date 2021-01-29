<?php


Route::get('/error/404', function() {

	return '404 Error - Not found';

})->name('error-404');



Route::get('/error/403', function() {

	return '403 Error - Unauthorised';

})->name('error-403');
