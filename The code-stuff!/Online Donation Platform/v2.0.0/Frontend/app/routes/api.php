<?php

use Illuminate\Http\Request;
use \App\Http\Controllers\DashDonate as API;
use \App\Http\Controllers\StripeController as DD_Stripe;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });





Route::post('/id-document-upload', function(Request $request) {
	// Wrapped in try statement so that errors can be caught
	try {
		// Check if file is in request
		if ($request->hasFile('file_upload')) {
			// Valid file extensions
			$valid_extensions = array('jpeg', 'png', 'jpg');
			// Get file
			$file = $request->file('file_upload');
			// Get name of file
			$file_name = $file->getClientOriginalName();
			// Get file's extension
			$file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			// Check file is valid format
			if (in_array($file_extension, $valid_extensions)) {
				$get_file = fopen($file->getPathName(), 'r');
				// Upload image to Stripe
				$img = DD_Stripe::upload_id_document($get_file);
				// Check if image was uploaded to Stripe
				if ($img && $img['id']) {
					// Save file to DD Database
					$upload = API::upload_id_document($request->get('type'), $img['id'], $request->get('charity_id'), $request->get('user_id'));
					// Return ID document
					return json_encode($upload);
				}
			}
			return json_encode('Invalid file format. Allowed formats are png, jpeg and jpg.');
		} else {
			return json_encode('No file attached.');
		}
	} catch (Exception $e) {
		$err = array(
			'msg' => $e->getMessage(),
			'line' => $e->getLine(),
		);

		return json_encode($err);
	}
	return json_encode(false);
})->middleware('ajax');










Route::post('/file-upload', function(Request $request) {
	// Wrapped in try statement so that errors can be caught
	try {
		// Check if file is in request
		if ($request->hasFile('file_upload')) {
			// Valid file extensions
			$valid_extensions = array('jpeg', 'png', 'jpg');
			// Get file
			$file = $request->file('file_upload');
			// Get name of file
			$file_name = $file->getClientOriginalName();
			// Get file's extension
			$file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			// Check file is valid format
			if (in_array($file_extension, $valid_extensions)) {
				// Get file data
				$file_data = fopen($file->getPathName(), 'r');
				// Switch file intent
				switch ($request->get('file_intent')) {
					case 'stripe_id_front':
					case 'stripe_id_back':
					case 'stripe_proof_of_address':
					case 'charity_utility_bill':
						// Upload image to Stripe
						$upload = DD_Stripe::uploadIdentityDocument($file_data);


						// Need to do error handling here (for colour, size, etc)


						// Check if image was uploaded to Stripe successfully
						if ($upload && $upload['id']) {
							// Save ID document upload
							$saved_file = API::uploadTrusteeDocument(
								$request->get('file_intent'),
								$upload['id'],
								$request->get('charity_id'),
								$request->get('user_id')
							);
							// Return saved file info
							return json_encode(['success' => true, 'data' => $saved_file]);
						} else {
							// Return error
							return json_encode(['success' => false, 'error' => 'Failed to upload document for processing.']);
						}
					break;
					case 'charity_logo':
						// Generate final image name
						$final_file_name = sha1(sha1(rand().time()).md5(time().sha1(time()))).'-'.$file_name;
						// Attempt to move file
						try {
							// Create new S3 Client object
							$s3Client = new S3Client([
								'profile' 		=> 'default',
								'region' 		=> 'eu-west-2',
								'version' 		=> '2006-03-01',
								'credentials' 	=> array(
									'key'			=> env('AWS_ACCESS_KEY'),
									'secret'		=> env('AWS_SECRET_ACCESS_KEY'),
								),
							]);
							// Put object into S3 Storage
							$obj = $s3Client->putObject([
								'Bucket'		=> env('AWS_BUCKET'),
								'Key'			=> $final_file_name,
								'SourceFile'	=> $file,
								'ACL'			=> 'public-read',
							]);
							// Check that object was saved in S3 (or moved to storage successfully)
							if (@$obj) {
								// Set the return filename (for thumbnail)
								$return_filename = $final_file_name;
								// Set default intent
								$intent = 'feed_media';
								// Check if intent was sent
								if (@$request->input('file_intent')) {
									// Set intent to submitted intent
									$intent = $request->input('file_intent');
								}
								// Create path string
								$path = '/'.$final_file_name;
								// Save uploaded image to database
								$image = API::saveUploadedimage(
									$final_file_name,
									$request->input('user_id'),
									$path,
									$intent
								);
								// Return image path so that preview can be shown
								return json_encode(['success' => true, 'path' => $path, 'image' => $image->id]);
							}
							// Return error
							return json_encode(['success' => false, 'error' => 'Failed to upload this file, please try again.']);
						} catch (AwsException $e) {
							return json_encode($e);
						}
					break;
				}
				// Return error
				return json_encode(['success' => false, 'error' => 'Unknown intent for upload, please refresh this page and try again.']);
			}
			// Return error
			return json_encode(['success' => false, 'error' => 'Invalid file format. Allowed formats are png, jpeg and jpg.']);
		} else {
			// Return error
			return json_encode(['success' => false, 'error' => 'You need to select a file to upload.']);
		}
	} catch (Exception $e) {
		$err = array(
			'msg' => $e->getMessage(),
			'line' => $e->getLine(),
			'trace' => $e->getTrace(),
		);
		return json_encode($err);
	}
})->middleware('ajax');




Route::post('/widget/donation/submit-next', function(Request $request) {
	try {
		// Get data
		$data = $request->all();
		// Set tasks on API
		$res = API::sendProgressForDonateWidget($data);
		// Return response
		return json_encode($res);
	} catch (Exception $e) {
		$err = array(
			'msg' => $e->getMessage(),
			'line' => $e->getLine(),
			'trace' => $e->getTrace(),
		);
		return json_encode($err);
	}
})->middleware('ajax');




Route::post('/widget/donation/set-tasks', function(Request $request) {
	try {
		// Get data
		$data = $request->all();
		// Set tasks on API
		$res = API::sendSetTasksForDonateWidget($data);
		// Return response
		return json_encode($res);
	} catch (Exception $e) {
		$err = array(
			'msg' => $e->getMessage(),
			'line' => $e->getLine(),
			'trace' => $e->getTrace(),
		);
		return json_encode($err);
	}
})->middleware('ajax');
