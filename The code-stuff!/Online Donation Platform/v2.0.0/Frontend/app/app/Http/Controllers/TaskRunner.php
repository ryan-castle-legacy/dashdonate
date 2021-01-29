<?php


/*
 #	TaskRunner.php
 #
 #	This file contains the functionality specific to task runners.
*/




// Include namespace
namespace App\Http\Controllers;
// Include controller for connecting to the API
use \App\Http\Controllers\DashDonate as API;


use Request;
use DB;
use Carbon\Carbon;




// Extend controller
class TaskRunner extends Controller {


	public static function processTasks() {


// TESTING
// DB::table('cron_tasks')->where(['id' => 52])->update(['processing' => false, 'active' => true, 'auth_req_sent' => false]);


		// Get tasks
		$tasks = TaskRunner::getTasks();
		// Check if tasks exist
		if ($tasks && gettype($tasks) == 'array') {
			// Loop through tasks
			for ($i = 0; $i < sizeof($tasks); $i++) {
				// Mark existing task as processing (if not already being processed (could've been completed by another concurrent task runner) and continue
				if (TaskRunner::markTaskAsProcessing($tasks[$i]->task_token)) {
					// Get most up-to-date version of the task data
					$task = TaskRunner::getTask($tasks[$i]->task_token);
					// Check if task was found
					if ($task && gettype($task) == 'object') {


						echo '<pre>';
						var_dump($task);
						echo '</pre><hr/>';


						// Switch type of task
						switch ($task->task_type) {
							case 'donation_receipt':
							case 'donation_receipt_offsession':
								// Attempt sending the email
								$sent = TaskRunner::sendEmailReceipt($task);
							break;
							case 'donation_authorise_offsession':
								// Attempt sending the email
								$sent = TaskRunner::sendDonationAuthorisation($task);
							break;
							case 'scheduled_donation':
							case 'repeating_donation':
								// Check if a donation reminder needs sent
								if ($task->reminder_needed == true) {
									// Attempt sending the reminder email
									$sent = TaskRunner::sendEmailDonationReminder($task);
								}
								// Check if date is in the past
								if (time() >= strtotime($task->date_to_process) && $task->auth_req_sent == false) {
									// Take off-session donation
									$donation = TaskRunner::processOffSessionDonation($task);
								}
							break;
						}
					}
				}
			}
		}

		// echo '<pre>';
		// var_dump($tasks);
		// echo '</pre>';

		return $tasks;
	}




	// Get tasks that need to be processed
	public static function getTasks() {
		// Get tasks
		$tasks = API::taskRunner_getTasks();
		// Return tasks
		return $tasks;
	}




	// Get task that needs to be processed
	public static function getTask($task_token) {
		// Get task
		$task = API::taskRunner_getTask($task_token);
		// Return task
		return $task;
	}




	// Mark a task as being processed
	public static function markTaskAsProcessing($task_token) {
		// Mark existing task as processing (if not already being processed (could've been completed by another concurrent task runner)
		return API::taskRunner_markTaskAsProcessing($task_token);
	}




	// Mark a task as being done
	public static function markTaskAsDone($task_token) {
		// Mark task as done
		return API::taskRunner_markTaskAsDone($task_token);
	}




	// Mark a task as needing further processing
	public static function markTaskAsNeedsFurtherProcessing($task_token) {
		// Mark task as needing processed again (a case of this could be a task to take payment, and this runner has sent a notification of a future payment task rather than taking payment at this moment - upcoming payment reminders, etc)
		return API::taskRunner_markTaskAsNeedsFurtherProcessing($task_token);
	}




	// Send receipt email
	public static function sendEmailReceipt($task) {
		// Send email
		return API::taskRunner_sendEmailReceipt($task);
	}




	// Send auth email
	public static function sendDonationAuthorisation($task) {
		// Send email
		return API::taskRunner_sendDonationAuthorisation($task);
	}




	// Send reminder email
	public static function sendEmailDonationReminder($task) {
		// Send email
		return API::taskRunner_sendEmailDonationReminder($task);
	}




	// Take off-session donation
	public static function processOffSessionDonation($task) {
		// Take off-session donation
		return API::taskRunner_processOffSessionDonation($task);
	}











}
