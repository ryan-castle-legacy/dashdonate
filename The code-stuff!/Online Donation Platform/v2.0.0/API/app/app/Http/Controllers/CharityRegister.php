<?php

namespace App\Http\Controllers;

// Include the error logging controller (to aid finding and fixing bugs)
use \App\Http\Controllers\LogError;

use Illuminate\Http\Request;
use DB;
use SoapClient;
use GuzzleHttp\Client as APIRequest;
use CkanApi;


class CharityRegister extends Controller
{

	public static $registers = array(
		'englandWales'			=> array(
			'endpoint'				=> 'http://www.charitycommission.gov.uk',
			'search_by_crn'			=> '/GetCharityTrustees',
			'api_key'				=> 'adff0a1a-0cc3-4418-9',
			'wsdl'					=> 'https://apps.charitycommission.gov.uk/Showcharity/API/SearchCharitiesV1/SearchCharitiesV1.asmx?wsdl',
			'docs'					=> 'https://apps.charitycommission.gov.uk/Showcharity/API/SearchCharitiesV1/Docs/DevGuideHome.aspx',
		),
	);


	// Find which register a charity belongs to
	public static function findRegister($crn) {
		// Holding variable
		$commission_name = false;
		// Loop through registers
		foreach (CharityRegister::$registers as $register_name => $register) {
			// Get commission data
			$data = CharityRegister::searchForCharity_englandWales($crn);
			// Cast as array
			$data = (array) $data;
			// Check if not empty
			if (!empty($data)) {
				return $register_name;
			}
		}
		// Return false as not found
		return false;
	}


	// Search Charity Commission for England and Wales
	public static function searchForCharity_englandWales($crn) {
		try {
			// Get API details
			$details = CharityRegister::$registers['englandWales'];
			// Create soap request
			$soap = new \SoapClient($details['wsdl'], array(
				'trace'			=> 1,
			));
			// Create soap data array
			$data = array(
				'APIKey'					=> $details['api_key'],
				'registeredCharityNumber'	=> $crn,
			);
			// Get charity by registered number
			$res = $soap->GetCharityByRegisteredCharityNumber($data);
			// Cast to array
			$cast = (array) $res;
			// Return response
			return $cast;
		} catch (SoapFault $e) {
			return json_encode($e->getMessage());
		}
	}


	// Get data from the Charity Commission for England and Wales
	public static function getCharityInfo_englandWales($crn) {
		try {
			// Get API details
			$details = CharityRegister::$registers['englandWales'];
			// Create soap request
			$soap = new \SoapClient($details['wsdl'], array(
				'trace'			=> 1,
			));
			// Create soap data array
			$data = array(
				'APIKey'					=> $details['api_key'],
				'registeredCharityNumber'	=> $crn,
			);
			// Get charity by registered number
			$res = $soap->GetCharityByRegisteredCharityNumber($data);
			// Get data from commission
			$data = $res->GetCharityByRegisteredCharityNumberResult;
			// Charity info container
			$charity_info = array(
				'charity_name'				=> trim($data->CharityName),
				'public_telephone'			=> trim($data->PublicTelephoneNumber),
				'public_emailaddress'		=> trim($data->EmailAddress),
				'public_website'			=> trim($data->WebsiteAddress),
				'address_line_1'			=> trim($data->Address->Line1),
				'address_line_2'			=> trim($data->Address->Line2).', '.trim($data->Address->Line3),
				'address_town_city'			=> trim($data->Address->Line4),
				'address_postcode'			=> trim($data->Address->Postcode),
				'description_of_charity'	=> trim($data->CharitableObjects),
				'companies_house_number'	=> trim($data->RegisteredCompanyNumber),
			);
			// Return charity info array
			return $charity_info;
		} catch (SoapFault $e) {
			return json_encode($e->getMessage());
		}
	}




	// Get trustee data from the Charity Commission for England and Wales
	public static function getTrusteesInfo_englandWales($crn) {
		try {
			// Get API details
			$details = CharityRegister::$registers['englandWales'];
			// Create soap request
			$soap = new \SoapClient($details['wsdl'], array(
				'trace'			=> 1,
			));
			// Create soap data array
			$data = array(
				'APIKey'					=> $details['api_key'],
				'registeredCharityNumber'	=> $crn,
			);
			// Get charity by registered number
			$res = $soap->GetCharityByRegisteredCharityNumber($data);
			// Get data from commission
			$data = $res->GetCharityByRegisteredCharityNumberResult;
			// Trustee list container
			$trustees_list = array();
			// Check if trustees were found
			if (@$data->Trustees) {
				// Get trustees
				$trustees = $data->Trustees;
				// Loop through list of trustees
				for ($i = 0; $i < sizeof($trustees); $i++) {
					// Add item
					$trustees_list[sizeof($trustees_list)] = array(
						'trustee_number'	=> $trustees[$i]->TrusteeNumber,
						'name'				=> $trustees[$i]->TrusteeName,
					);
				}
			}
			// Return trustee list
			return $trustees_list;
		} catch (SoapFault $e) {
			return json_encode($e->getMessage());
		}
	}




	// Get trustee data from the Charity Commission for England and Wales for specific trustee
	public static function getTrustee_englandWales($crn, $trustee_number) {
		try {
			// Get API details
			$details = CharityRegister::$registers['englandWales'];
			// Create soap request
			$soap = new \SoapClient($details['wsdl'], array(
				'trace'			=> 1,
			));
			// Create soap data array
			$data = array(
				'APIKey'					=> $details['api_key'],
				'registeredCharityNumber'	=> $crn,
			);
			// Get charity by registered number
			$res = $soap->GetCharityByRegisteredCharityNumber($data);
			// Get data from commission
			$data = $res->GetCharityByRegisteredCharityNumberResult;
			// Get trustees
			$trustees = $data->Trustees;
			// Trustee data container
			$trustee = array();
			// Loop through list of trustees
			for ($i = 0; $i < sizeof($trustees); $i++) {
				// Check if trustee matches trustee number
				if ($trustees[$i]->TrusteeNumber == $trustee_number) {
					// Set trustee data
					$trustee = array(
						'trustee_number'	=> $trustees[$i]->TrusteeNumber,
						'name'				=> $trustees[$i]->TrusteeName,
					);
				}
			}
			// Return trustee data
			return $trustee;
		} catch (SoapFault $e) {
			return json_encode($e->getMessage());
		}
	}











	// Search Charity Commission for England and Wales
	public static function searchForCharities_englandWales() {
		try {
			// Get API details
			$details = CharityRegister::$registers['englandWales'];
			// Create soap request
			$soap = new \SoapClient($details['wsdl'], array(
				'trace'			=> 1,
			));
			// Create soap data array
			$data = array(
				'APIKey'					=> $details['api_key'],
				'strSearch'					=> array(
					'SearchFor'							=> 'OnlyRegisterCharities',
					'Keyword'							=> 'MatchAllWords',
					'SearchIn'							=> 'CharityNameAndActivities',

					'WhereOperates'						=> array(
						'EnglandAndWales'					=> 'All',
					),

					'RegistrationDateFrom_Day'			=> 25,
					'RegistrationDateFrom_Month'		=> 6,
					'RegistrationDateFrom_Year'			=> 2020,
					'RegistrationDateFromIsSpecified'	=> true,

					'RegistrationDateTo_Day'			=> 30,
					'RegistrationDateTo_Month'			=> 6,
					'RegistrationDateTo_Year'			=> 2020,
					'RegistrationDateToIsSpecified'		=> true,


					'RemovedDateFrom_Day'				=> 0,
					'RemovedDateFrom_Month'				=> 0,
					'RemovedDateFrom_Year'				=> 0,
					'RemovedDateFromIsSpecified'		=> false,

					'RemovedDateTo_Day'					=> 0,
					'RemovedDateTo_Month'				=> 0,
					'RemovedDateTo_Year'				=> 0,
					'RemovedDateToIsSpecified'			=> false,


					// 'IncomeRangeFrom'					=> '00',
					// 'IncomeRangeTo'
				),
			);
			// Get charity by registered number
			$res = $soap->GetCharities($data);
			// Cast to array
			$cast = (array) $res;
			// Return response
			return $cast;
		} catch (SoapFault $e) {
			return json_encode($e->getMessage());
		}
	}




}
