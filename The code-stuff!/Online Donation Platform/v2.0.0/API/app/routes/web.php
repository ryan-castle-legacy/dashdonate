<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
// Route::get('/apikey', function() {
// 	$key = DB::table('apikeys')->insert([
// 		'key' => 'demo_token',
// 		'author_ip' => 'xxxx',
// 		'date_generated' => date('Y-m-d H:i:s', time()),
// 	]);
// 	var_dump($key);
// });


Route::get('/', function() {
	// return Redirect::to('https://dashdonate.org')
	return Redirect::to('http://xxxx');
});

Route::get('/testryan', function() {
	echo 'Hi';
});
