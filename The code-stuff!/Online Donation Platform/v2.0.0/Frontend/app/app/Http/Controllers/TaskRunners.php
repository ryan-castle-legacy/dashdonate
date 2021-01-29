<?php


/*
 #	TaskRunners.php
 #
 #	This file contains the functionality specific to donation task runners.
*/




// Include namespace
namespace App\Http\Controllers;


// Declare controllers
use Request;
use DB;
use Carbon\Carbon;




// Include controller for connecting to the API
use \App\Http\Controllers\DashDonate as API;




// Extend controller
class TaskRunners extends Controller {




	public static function runDonationTasks() {
		try {


			// DB::table('donations_task_list')->where(['id' => 5])->update(['processing' => false]);


			// Get tasks from database
			$tasks = TaskRunners::getTasks();
			// Check if tasks exist
			if ($tasks) {
				// Loop through tasks
				for ($i = 0; $i < sizeof($tasks); $i++) {
					// Get task token
					$task_token = $tasks[$i]->task_token;
					// Mark existing task as processing (if not already being processed (could've been completed by another concurrent task runner) and continue
					if (TaskRunners::markTaskAsProcessing($task_token)) {
						// Holding variable for whether the task is complete or not
						$done = false;
						// Get most up-to-date version of the task data
						$task = DB::table('donations_task_list')->where(['task_token' => $task_token])->first();


						// Check whether reminder email is needing to be sent
						if (TaskRunners::needsReminderEmail($task)) {
							// Send reminder email
							TaskRunners::sendReminderEmail($task);
						}


						// Check if a scheduled payment is in need of being processed
						if (TaskRunners::needsPaymentProcessed($task)) {
							// Process payment
							$donation = TaskRunners::processPayment($task);
							// Check if donation was made successfully
							if (TaskRunners::checkIfDonationWasSuccessful($donation)) {
								// Check if task needs to be repeated again
								if (TaskRunners::checkIfNeedToSetNextTask($task)) {
									// Set next task
									$next = TaskRunners::setNextTask($task);
								}
								// Mark task as complete
								$done = TaskRunners::markTaskAsDone($task_token);
							} else {
								// Notify user about action needed
								TaskRunners::needsActionEmail($task);
							}
						}


						// Check whether task needs to be processed at some point again
						if (!$done) {
							// Mark task as needing processed again (a case of this could be a task to take payment, and this runner has sent a notification of a future payment task rather than taking payment at this moment - upcoming payment reminders, etc)
							TaskRunners::markTaskAsNeedsFurtherProcessing($task_token);
						}
					}
				}
			}
			// Return tasks
			return $tasks;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
				'trace'		=> $e->getTrace(),
			);
			// Return error
			return $error;
		}
	}





	// Sends user a notification to authenticate payment
	public static function needsActionEmail($task) {
		// Check if user needs action email sent
		if ($task->auth_req_sent == false) {
			// Send email
			return API::sendDonationAuthRequest($task->task_token);
		}
	}




	// Set next task as this current task has been processed
	public static function setNextTask($task) {
		// Set next task for repeating task
		$next = API::setNextDonationTask($task->task_token);
		// Return result
		return $next;
	}




	// Check if repeating payment needs to be set
	public static function checkIfNeedToSetNextTask($task) {
		// Check if the donation is repeating
		if ($task && $task->recurring == true) {
			// Return success
			return true;
		}
		// Return false as donation failed
		return false;
	}




	// Check if payment was processed successfully
	public static function checkIfDonationWasSuccessful($donation) {
		// Check if the donation returned success
		if ($donation && @$donation->success === true) {
			// Return success
			return true;
		}
		// Return false as donation failed
		return false;
	}




	// Process payment
	public static function processPayment($task) {
		// Perform donation that has been set
		return API::performDonationTask($task->task_token);
	}




	// Check if payment needs to be processed
	public static function needsPaymentProcessed($task) {
		// Check whether payment is due now
		if (strtotime($task->date_to_process) < time()) {
			// Return that payment needs to be processed
			return true;
		}
		// Return default
		return false;
	}




	// Send a reminder email about the scheduled action
	public static function sendReminderEmail($task) {
		// Send reminder email via API
		$send = API::sendDonationReminderEmail($task->task_token);
		// Check if email was sent
		if ($send && @$send->success == true) {
			// Mark reminder as being sent
			DB::table('donations_task_list')->where(['task_token' => $task->task_token])->update([
				'reminder_sent' 	=> true,
				'reminder_needed' 	=> false,
				'date_updated'		=> date('Y-m-d H:i:s', time()),
			]);
		}
	}




	// Check if reminder needs sending
	public static function needsReminderEmail($task) {
		// Check whether reminder email is needing to be sent
		if ($task->reminder_sent == false && $task->reminder_needed == true) {
			// Return that reminder is needed
			return true;
		}
		// Return default
		return false;
	}




	// Get tasks that need to be processed
	public static function getTasks() {
		// Get tasks from database
		return DB::table('donations_task_list')->where([
			'active'		=> true,
			'processing'	=> false,
		])->where('date_to_process', '<', Carbon::now()->addDays(1))->orderBy('date_to_process', 'ASC')->get();
	}




	// Mark a task as being processed
	public static function markTaskAsProcessing($task_token) {
		// Mark existing task as processing (if not already being processed (could've been completed by another concurrent task runner)
		return DB::table('donations_task_list')->where([
			'active'			=> true,
			'processing'		=> false,
			'task_token'		=> $task_token,
		])->update([
			'processing' 		=> true,
			'date_processed'	=> date('Y-m-d H:i:s', time()),
			'date_updated'		=> date('Y-m-d H:i:s', time()),
		]);
	}




	// Mark a task as being done
	public static function markTaskAsDone($task_token) {
		// Mark task as done
		return DB::table('donations_task_list')->where(['task_token' => $task_token])->update([
			'active' 			=> false,
			'processing' 		=> false,
			'date_processed'	=> date('Y-m-d H:i:s', time()),
			'date_updated'		=> date('Y-m-d H:i:s', time()),
		]);
	}




	// Mark a task as needing further processing
	public static function markTaskAsNeedsFurtherProcessing($task_token) {
		// Mark task as needing processed again (a case of this could be a task to take payment, and this runner has sent a notification of a future payment task rather than taking payment at this moment - upcoming payment reminders, etc)
		return DB::table('donations_task_list')->where(['task_token' => $task_token])->update([
			'active' 			=> true,
			'processing' 		=> false,
			'date_updated'		=> date('Y-m-d H:i:s', time()),
		]);
	}




}
