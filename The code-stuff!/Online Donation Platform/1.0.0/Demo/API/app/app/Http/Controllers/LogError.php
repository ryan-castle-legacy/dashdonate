<?php

namespace App\Http\Controllers;

use DB;

class LogError extends Controller {

	// Log errors to the database
	public static function log_error($message, $line, $trace) {
		// Search for existing error
		$existing = DB::table('error_recording')->where(['resolved' => false, 'error_trace' => $trace])->first();
		// Check if error already exists
		if ($existing) {
			// Update counter for existing record
			$update = DB::table('error_recording')->where([
				'id' 			=> $existing->id,
			])->update([
				'error_count' 	=> ($existing->error_count + 1),
				'updated_at'	=> date('Y-m-d H:i:s', time()),
			]);
			// Check if update worked
			if ($update) {
				// Return success
				return json_encode(array(
					'message'	=> $message,
					'line'		=> $line,
					'trace'		=> $trace,
				));
			}
		} else {
			// Create record of error
			$new_error = DB::table('error_recording')->insert([
				'line_number' 		=> $line,
				'error_message'		=> $message,
				'error_trace'		=> $trace,
				'created_at'		=> date('Y-m-d H:i:s', time()),
				'updated_at'		=> date('Y-m-d H:i:s', time()),
			]);
			// Check if new error was logged successfully
			if ($new_error) {
				// Return success
				return json_encode(array(
					'message'	=> $message,
					'line'		=> $line,
					'trace'		=> $trace,
				));
			}
		}
		// Return failure to log the error
		return json_encode(false);
	}

}

?>
