<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as APIRequest;
use Auth;
use DateTime;
use Exception;
use Redirect;
use Hash;


class DashDonate extends Controller
{




	public static function xx() {
		try {
			// Perform API request
			$res = DashDonate::api_call('GET', '/xx');
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}







	// public static function addEmailToQueue() {
	// 	try {
	// 		// Perform API request
	// 		$res = DashDonate::api_call('POST', '/queue/add-email', ['x' => 'y']);
	// 		// Check response body is success
	// 		if (@$res->status == 200) {
	// 			// Return data to method caller
	// 			return json_decode($res->body);
	// 		}
	// 		return $res;
	// 	} catch (Exception $e) {
	// 		// Create error info array
	// 		$error = array(
	// 			'message'	=> $e->getMessage(),
	// 			'line'		=> $e->getLine(),
	// 		);
	// 		// Return error
	// 		return $error;
	// 	}
	// }




	public static function getDateWeekdays() {
		return array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
	}




	public static function taskRunner_getTasks() {
		try {
			// Perform API request
			$res = DashDonate::api_call('GET', '/task-runner/get-tasks/');
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function taskRunner_getTask($task_token) {
		try {
			// Perform API request
			$res = DashDonate::api_call('GET', '/task-runner/get-task/'.$task_token);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function taskRunner_markTaskAsProcessing($task_token) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/task-runner/mark-task-as-processing/', ['task_token' => $task_token]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function taskRunner_markTaskAsNeedsFurtherProcessing($task_token) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/task-runner/mark-task-as-needs-further-processing/', ['task_token' => $task_token]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function taskRunner_markTaskAsDone($task_token) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/task-runner/mark-task-as-done/', ['task_token' => $task_token]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function taskRunner_sendEmailReceipt($task) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/task-runner/send-email-receipt/', ['task' => $task]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function taskRunner_sendDonationAuthorisation($task) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/task-runner/send-email-off-session-auth/', ['task' => $task]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function taskRunner_sendEmailDonationReminder($task) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/task-runner/send-email-donation-reminder/', ['task' => $task]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function taskRunner_processOffSessionDonation($task) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/task-runner/process-off-session-donation/', ['task' => $task]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function getOffSessionAuthorisationTask($task_token, $user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('GET', '/task-runner/get-task-for-authorisation/'.$task_token.'/'.$user_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function processOffSessionAuthorisationTask($task_token, $card_token, $card_id, $user_id, $setupIntent, $paymentIntent) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/widget/authorise-off-session-donation/', [
				'task_token'	=> $task_token,
				'card_token'	=> $card_token,
				'card_id'		=> $card_id,
				'user_id'		=> $user_id,
				'setupIntent'	=> $setupIntent,
				'paymentIntent'	=> $paymentIntent,
			]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




















































	public static function sendWidgetDataForDonationProcessing($data) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/widget/process-payment/', $data);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function saveWidgetSession($data) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/widget/create-session-record/', $data);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}












































	public static function calculateDonationFees($amount) {
		try {
			// Perform API request
			$res = DashDonate::api_call('GET', '/calculate-donation-fees/'.$amount);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function getUserBillingSettings($user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('GET', '/user/billing-settings/'.$user_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function updateUserAccountDetails($user_id, $data) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/user/update-account-details/', ['user_id' => $user_id, 'data' => $data]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function completeDonationTask($task_token, $user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/donor/complete-donation-task', [
				'task_token'	=> $task_token,
				'user_id'		=> $user_id,
			]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function failDonationTask($task_token, $user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/donor/fail-donation-task', [
				'task_token'	=> $task_token,
				'user_id'		=> $user_id,
			]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function getTaskForUserAuth($task_token, $user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('GET', '/donation/get-donation-task-for-auth/'.$task_token.'/'.$user_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function getTaskForUser($task_token, $user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('GET', '/donation/get-donation-task/'.$task_token.'/'.$user_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function sendDonationAuthRequest($task_token) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/donation/send-authentication-for-donation-task/', ['task_token' => $task_token]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function deleteDonationTask($task_token, $user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/donor/delete-donation-task', [
				'task_token'	=> $task_token,
				'user_id'		=> $user_id,
			]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function removeAuthorisedWebsite($charity_slug, $website_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/charity/remove-authorised-website', [
				'charity_slug'	=> $charity_slug,
				'user_id'		=> Auth::user()->id,
				'website_id'	=> $website_id,
			]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function addAuthorisedWebsite($charity_slug, $url) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/charity/add-authorised-website', [
				'charity_slug'	=> $charity_slug,
				'user_id'		=> Auth::user()->id,
				'url'			=> $url,
			]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function resetPasswordViaToken($token, $password) {
		try {
			// Perform API request
			$res = DashDonate::api_call('PUT', '/donor/reset-password/', ['token' => $token, 'password' => Hash::make($password)]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function resetPasswordViaForced($password, $user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('PUT', '/donor/set-password/', ['user_id' => $user_id, 'password' => Hash::make($password)]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function getResetPasswordToken($token) {
		try {
			// Perform API request
			$res = DashDonate::api_call('GET', '/donor/reset-password/'.$token);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function getUserDonations($user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('GET', '/donor/all-donations/'.$user_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function getUserDashboard($user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('GET', '/donor/dashboard/'.$user_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function setNextDonationTask($task_token) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/donation/set-next-donation-task/', ['task_token' => $task_token]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function performDonationTask($task_token) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/donation/perform-donation-task/', ['task_token' => $task_token]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function sendDonationReminderEmail($task_token) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/donation/send-reminder-email/', ['task_token' => $task_token]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function sendProgressForDonateWidget($data) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/widget/donation/submit-next/', ['data' => $data]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function sendSetTasksForDonateWidget($data) {
		try {
			// Perform API request
			$res = DashDonate::api_call('POST', '/widget/donation/set-tasks/', ['data' => $data]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function checkIfUserExists($email) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/user/check-if-exists/'.$email);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function confirmUserEmail($user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/user/confirm-email', ['user_id' => $user_id]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function sendEmailToConfirm($user, $search_user_id = false) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/user/send-verification-email', ['user' => $user, 'search_user_id' => $search_user_id]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function checkIfCRNIsInUse($crn) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/charity/crn-in-use/'.$crn);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function createInitialCharityApplication($crn, $owner_user_id, $registration_goals = '') {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/charity/create-initial-charity-application/', array(
				'crn'					=> $crn,
				'owner_user_id'			=> $owner_user_id,
				'registration_goals'	=> $registration_goals,
			));
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function getCharityBySlug($slug, $staff_user_id = 0, $donation_data = false) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/charity/get-by-slug/'.$slug.'/'.$staff_user_id.'/'.$donation_data);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function getCharityByAPIKey($apikey) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/charity/get-by-api-key/'.$apikey);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function getRoleInCharity($charity_slug, $user_id = 0) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/charity/get-staff-role/'.$charity_slug.'/'.$user_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function inviteRepresentativeToCharity($charity_slug, $recipient_email, $inviter_user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/charity/invite-representative/', [
				'charity_slug'		=> $charity_slug,
				'recipient_email'	=> $recipient_email,
				'inviter_user_id'	=> $inviter_user_id,
			]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function inviteStaffToCharity($charity_slug, $recipient_email, $inviter_user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/charity/invite-staff/', [
				'charity_slug'		=> $charity_slug,
				'recipient_email'	=> $recipient_email,
				'inviter_user_id'	=> $inviter_user_id,
			]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function handleInviteRepresentativeToCharity($invite_token) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/charity/invite-representative/'.$invite_token);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function respondInviteRepresentativeToCharity($invite_token, $response = 'decline') {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/charity/respond-invite-representative/'.$invite_token.'/'.$response);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function getCharityTrustees($crn) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/charity/get-trustees-from-commission/'.$crn);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function validateCharityTrustee($charity_slug, $trustee_number) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/charity/is-trustee-valid/'.$charity_slug.'/'.$trustee_number);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function createDashDonateRepresentative($charity_slug, $data, $rep_user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/charity/create-representative/', array(
				'charity_slug'				=> $charity_slug,
				'representative_data'		=> $data,
				'representative_user_id'	=> $rep_user_id,
			));
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function refreshCharityStripeAccount($charity_slug, $ip) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/charity/refresh-stripe-account/', array(
				'charity_slug'		=> $charity_slug,
				'ip'				=> $ip,
			));
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function uploadTrusteeDocument($intent, $stripe_file_id, $charity_id, $user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/files/upload/identity', [
				'file_intent' 		=> $intent,
				'stripe_file_id' 	=> $stripe_file_id,
				'charity_id' 		=> $charity_id,
				'user_id' 			=> $user_id,
			]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function submitRepresentativeIdentificationStripe($charity_slug) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/charity/submit-representative-identity/', ['charity_slug' => $charity_slug]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function submitProofOfAddressToStripe($charity_slug) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/charity/submit-proof-charity-of-address/', ['charity_slug' => $charity_slug]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function getRepresentativeIdentificationStatus($charity_slug) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/charity/representative-identity-status/'.$charity_slug);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function updateCharityBankDetails($charity_slug, $rep_user_id, $sort_code, $account_number) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/charity/update-bank-account/', [
				'charity_slug' 		=> $charity_slug,
				'rep_user_id' 			=> $rep_user_id,
				'sort_code' 			=> $sort_code,
				'account_number' 		=> $account_number,
			]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function updateCharityDisplayInformation($charity_slug, $admin_user_id, $form_data) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/charity/update-charity-display-details/', [
				'charity_slug' 			=> $charity_slug,
				'admin_user_id' 		=> $admin_user_id,
				'form_data' 			=> $form_data,
			]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function saveUploadedimage($file_name, $user_id, $path, $intent) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/files/save-upload/', [
				'file_name' 		=> $file_name,
				'user_id' 			=> $user_id,
				'path' 				=> $path,
				'intent' 			=> $intent,
			]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}


























































































	public static function create_charity_application($name, $crn) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/charity/application/create', ['name' => $name, 'crn' => $crn, 'owner_id' => Auth::user()->id]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function get_charity_application($charity_id, $owner_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/charity/application/get/'.$charity_id.'/'.$owner_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function update_charity_application($data, $owner_id, $ip) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/charity/application/update/', ['data' => $data, 'owner_id' => $owner_id, 'ip' => $ip]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function get_charity_by_id($charity_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/charity/get/'.$charity_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function update_charity_data_from_commission($charity_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/charity/update-from-commission/'.$charity_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function get_charity_data_from_commission($charity_id, $user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/charity/get-from-commission/'.$charity_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function get_trustees_data_from_commission($charity_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/charity/trustees/get-from-commission/'.$charity_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function get_connected_charities($user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/connected-charities/'.$user_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function update_connected_charity($charity_id, $user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/update/connected-charity/'.$charity_id.'/'.$user_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function invite_to_charity($charity_id, $email, $user_id, $is_admin = false) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/invite/new-charity-staff/', ['charity_id' => $charity_id, 'email' => $email, 'user_id' => $user_id, 'is_admin' => $is_admin]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function get_invite($invite_token) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/invite/get/'.$invite_token);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function accept_invite($invite_token, $user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/invite/accept/'.$invite_token.'/'.$user_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function decline_invite($invite_token, $user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/invite/decline/'.$invite_token.'/'.$user_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function upload_id_document($file_type, $stripe_file_id, $charity_id, $user_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/files/upload/identity', [
				'file_type' 		=> $file_type,
				'stripe_file_id' 	=> $stripe_file_id,
				'charity_id' 		=> $charity_id,
				'user_id' 			=> $user_id,
			]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function submit_charity_representative($charity_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/submit/charity-representative', ['charity_id' => $charity_id, 'user_id' => Auth::user()->id]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}









































	public static function initialiseWidgetIntent($site_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/widget/donation/initialise', ['site_id' => $site_id]);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function donate_via_widget($data) {
		try {
			// Perform API request
			$res = DashDonate::api_call('post', '/widget/donation', $data);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}




	public static function get_intent($intent_id) {
		try {
			// Perform API request
			$res = DashDonate::api_call('get', '/widget/get-intent/'.$intent_id);
			// Check response body is success
			if (@$res->status == 200) {
				// Return data to method caller
				return json_decode($res->body);
			}
			return $res;
		} catch (Exception $e) {
			// Create error info array
			$error = array(
				'message'	=> $e->getMessage(),
				'line'		=> $e->getLine(),
			);
			// Return error
			return $error;
		}
	}























	// Perform API Call
	public static function api_call($method, $endpoint, $data = []) {
		try {
			// Create request object
			$api_req = new APIRequest();
			// Create request body array
			$api_req_body = [
				// Create headers
				'headers'	=> [
					'Authorization' => 'Bearer '.env('API_TOKEN'),
				],
				'json'		=> $data,
			];
			// Send request to API route
			$api_res = $api_req->request(strtoupper($method), env('API_URL').$endpoint, $api_req_body);
			// Create response object
			$response = (object)[];
			// Add response status and data to response object
			$response->status = $api_res->getStatusCode();
			$response->body = $api_res->getBody()->getContents();
			// Return response object
			return $response;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public static function boolToString($bool) {
		// Check if boolean is true
		if ($bool) {
			return 'true';
		}
		return 'false';
	}

	public static function phone_to_international($number) {
		// Remove spaces
		$number = str_replace(' ', '', $number);
		// Make sure the number is actually a number
		if (is_numeric($number)) {
			// If number doesn't start with a 0 or a 4 add a 0 to the start
			if ($number[0] != 0 && $number[0] != 4) {
				$number = '0'.$number;
			}
			// If number starts with a 0 replace with 4
	        if ($number[0] == 0) {
	            $number[0] = str_replace('0', '4', $number[0]);
	            $number = '4'.$number;
	        }
			// Remove any spaces in the number
			$number = str_replace(' ', '', $number);
			// Return the number
			return $number;
		}
		return $number;
	}

}
