<?php




require_once 'web/public.php';
require_once 'web/widgets.php';
require_once 'web/donations.php';







// // Get web routes from their folders
// require_once 'web-routes/public-website.php';
// require_once 'web-routes/auth-routes.php';
// require_once 'web-routes/admin-routes.php';
// require_once 'web-routes/user-routes.php';
// require_once 'web-routes/donation-routes.php';
// require_once 'web-routes/charity-routes.php';
// require_once 'web-routes/error-routes.php';
//
//
//
//
// // For testing
// require_once 'web-routes/demo-routes.php';
//
//
//
//
// require_once 'ui_kit.php';






// Route::get('/api-test', function() {
// 	try {
//
// 		$response = API::test();
//
//
// 		echo '<h1>Success</h1>';
// 		echo '<pre>';
// 			var_dump($response);
// 		echo '</pre>';
//
//
// 		return;
// 	} catch (Exception $e) {
//
// 		$error = array(
// 			'message'	=> $e->getMessage(),
// 			'trace'		=> $e->getTraceAsString(),
// 			'line'		=> $e->getLine(),
// 		);
//
//
// 		echo '<h1>Error</h1>';
// 		echo '<pre>';
// 			var_dump($error);
// 		echo '</pre>';
//
//
// 		return;
// 	}
// });



// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');















// Route::get('/api-token-list', function() {
// 	$insert = DB::table('apikeys')->get();
// 	var_dump($insert);
// });

// Route::get('/api-token-create', function() {
// 	$insert = DB::table('apikeys')->insert(['key' => 'demo_token', 'author_ip' => Request::ip()]);
// 	var_dump($insert);
// });
