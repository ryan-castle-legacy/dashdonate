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




/* This form is submitted from the front-end

<form method='POST' id='form_charity_logo' class='file_upload_form' enctype='multipart/form-data'>
	@csrf
	<input type='hidden' name='file_intent' value='charity_logo'/>
	<input type='hidden' name='user_id' value='{{ Auth::user()->id }}'/>
	<div class='col-12'>
		<input type='file' class='custom-file-input' id='charity_logo' name='file_upload' accept='image/png,image/jpeg'/>
		<label class='custom-file-label' for='charity_logo'>Choose file</label>
	</div>
</form>
<input type='submit' form='form_charity_logo' class='btn btn-primary w-100 m-0 mt-2 file-submit' value='Upload'/>

*/




/* JS code

// On form submitting
$('form.file_upload_form').on('submit', function(e) {
	// Prevent default
	e.preventDefault();
	// Get container
	var container = $(e.target).closest('.custom-file');
	// Perform upload
	sendFileToUploader(this, container, function(container, data) {

		// Callback actions here

	});
});


// Function to send a file via AJAX
function sendFileToUploader(form, container, callback) {
	// Perform AJAX request
	$.ajax({
		url: 			'/api/file-upload',
		type: 			'POST',
		data: 			new FormData(form),
		contentType: 	false,
		cache: 			false,
		dataType: 		'json',
		processData: 	false,
		success:		function(data) {

			console.log(data);

			if (data.success == true) {

				// Trigger callback
				callback(container, data);

			} else {
				// Return error
				// cancelFileUpload(container, data.error);
			}

		},
		error:	function(err) {
			console.log(err);

			// Return error
			cancelFileUpload(container, JSON.parse(err.responseText));
		}
	});
}


*/




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
