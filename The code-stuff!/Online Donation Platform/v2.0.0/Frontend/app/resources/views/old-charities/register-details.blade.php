@extends('layouts.main')

@section('content')
	<div class='bg-blue w-100'>
		<div class='container pt-5'>
			<div class='col py-3 text-center'>
				<h1>Details about your Charity</h1>
				<p class='mb-3'>Please complete this form so that we can set your charity up.</p>
			</div>
		</div>
		<div class='container pb-5'>
			<form id='form_submit_charity_details_form' action='{{ route('charities-register_details_submit') }}' method='POST'>
				@csrf
				<input type='hidden' name='charity_id' value='{{ $details->id }}'/>
			</form>
			<div class='col d-flex mb-4 justify-content-center'>
				<div class='card card_form_wide form'>
					<div class='row'>
						<div class='col-3'>
							<label for='charity_reg'>Charity reg no</label>
							<input class='w-100' form='form_submit_charity_details_form' type='text' name='charity_reg' id='charity_reg' value='{{ $details->charity_registration_number }}' disabled/>
							<p class='form_error_message' for='charity_reg'>A charity registration number is required.</p>
						</div>
						<div class='col-5'>
							<label for='charity_name'>Charity name</label>
							<input class='w-100' form='form_submit_charity_details_form' type='text' name='charity_name' id='charity_name' value='{{ $details->name }}' required/>
							<p class='form_error_message' for='charity_name'>A charity name is required.</p>
						</div>
						<div class='col-4'>
							<label for='country'>Select country</label>
							<select name='country' form='form_submit_charity_details_form' id='country' disabled/>
								<option default selected value='United Kingdom' disabled>United Kingdom</option>
							</select>
						</div>
						<div class='col-8'>
							<label for='charity_website'>Website address (or a verified social media profile)</label>
							<div class='website_input_block'>
								<input class='w-100' form='form_submit_charity_details_form' type='text' name='charity_website' id='charity_website' value='{{ old('charity_website') }}' required/>
								<label for='charity_website' class='website_input'>https://</label>
							</div>
							<p class='form_error_message' for='charity_website'>A charity website is required.</p>
						</div>
						<div class='col-4'>
							<label for='phone_number'>Main phone number</label>
							<input class='w-100' form='form_submit_charity_details_form' type='text' name='phone_number' id='phone_number' value='{{ old('phone_number') }}' required/>
							<p class='form_error_message' for='phone_number'>A phone number is required.</p>
						</div>
					</div>

					<p class='my-1'><small>By clicking 'Register my Charity' you agree to the <a href='{{ route('public-terms_connected_charities') }}' target='_blank'>terms of connected charities</a>.</small></p>

					<div class='mt-2'>
						<a class='btn btn-primary m-0 w-100' id='submit_charity_details_form'>
							<i class='spinner fas fa-circle-notch'></i>
							Register my Charity
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
