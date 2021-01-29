<?php

namespace App\Http\Controllers;

// Include the error logging controller (to aid finding and fixing bugs)
// use \App\Http\Controllers\LogError;

use Illuminate\Http\Request;
use DB;

class StripeController extends Controller
{


	// Upload identity document to stripe
	public static function uploadIdentityDocument($file) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));
			// Create file
			$file = \Stripe\File::create([
				'file' => $file,
				'purpose' => 'identity_document',
			]);
			// Return file object
			return $file;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}





	public static function upload_id_document($file) {
		try {
			// Connect to Stripe
			\Stripe\Stripe::setApiKey(env('STRIPE_SK'));

			$file = \Stripe\File::create([
				'file' => $file,
				'purpose' => 'identity_document',
			]);

			return $file;

		} catch (Exception $e) {
			return $e->getMessage();
		}
	}


}
