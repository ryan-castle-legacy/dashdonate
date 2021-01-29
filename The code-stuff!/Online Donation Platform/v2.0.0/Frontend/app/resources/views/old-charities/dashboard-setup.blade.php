@extends('layouts.main')

@section('content')
	<div class='dashboard'>
		<div class='dash_nav'>
			@if ($charity->verified == false)
				<p><a href='{{ route('charities-dashboard_setup', ['charity_id' => $charity->id]) }}'>Verify my charity</a></p>
			@endif
			<p><a href='{{ route('charities-dashboard', ['charity_id' => $charity->id]) }}'>Dashboard</a></p>
			<p><a href='{{ route('charities-dashboard_donations', ['charity_id' => $charity->id]) }}'>Donations</a></p>
			<p><a href='{{ route('charities-dashboard_staff', ['charity_id' => $charity->id]) }}'>Staff</a></p>
		</div>
		<div class='dash_main'>
			<div class='col px-0 d-flex mb-4 justify-content-center'>
				<div class='row w-100'>
					<div class='col-12'>
						<div class='card form' id='charity_details_records'>
							<form id='charity_details_records_form' action='{{ route('charities-dashboard_setup', ['charity_id' => $charity->id]) }}' method='POST'>@csrf</form>
							<div class='row'>

								<div class='col-3'>
									<label for='charity_reg'>Charity reg no</label>
									<input class='w-100' type='text' name='charity_reg' id='charity_reg' value='{{ $charity->charity_registration_number }}' disabled/>
									<p class='form_error_message' for='charity_reg'>A charity registration number is required.</p>
								</div>


								<div class='col-5'>
									<label for='charity_name'>Charity name</label> {{-- Choice from 'trading names' in companies house --}}
									<input class='w-100' form='charity_details_records_form' type='text' name='charity_name' id='charity_name' value='{{ $charity->details->charity_name }}' required/>
									<p class='form_error_message' for='charity_name'>A charity name is required.</p>
								</div>


								<div class='col-4'>
									<label for='country'>Select country</label>
									<select name='country' id='country' disabled/>
										<option default selected value='United Kingdom' disabled>United Kingdom</option>
									</select>
								</div>


								<div class='col-8'>
									<label for='charity_website'>Website address (or a verified social media profile)</label>
									<div class='website_input_block'>
										<input class='w-100' form='charity_details_records_form' type='text' name='charity_website' id='charity_website' value='{{ $charity->details->charity_website }}' required/>
										<label for='charity_website' class='website_input'>https://</label>
									</div>
									<p class='form_error_message' for='charity_website'>A charity website is required.</p>
								</div>


								<div class='col-4'>
									<label for='phone_number'>Main phone number</label>
									<input class='w-100' form='charity_details_records_form' type='text' name='phone_number' id='phone_number' value='{{ $charity->details->phone_number }}' required/>
									<p class='form_error_message' for='phone_number'>A phone number is required.</p>
								</div>

								<div class='col-12'>
									<p class='mt-3 mb-3'>Your charity's registered address <small>(If this is incorrect, please update your address with your local charity commission)</small></p>
								</div>

								<div class='col-3'>
									<label for='address_line_1'>Address Line 1</label>
									<input class='w-100' type='text' id='address_line_1' value='{{ $charity->details->address_line_1 }}' disabled/>
								</div>


								<div class='col-4'>
									<label for='address_line_2'>Address Line 2</label>
									<input class='w-100' type='text' id='address_line_2' value='{{ $charity->details->address_line_2 }}' disabled/>
								</div>


								<div class='col-3'>
									<label for='address_town_city'>Town/City</label>
									<input class='w-100' type='text' id='address_town_city' value='{{ $charity->details->address_town_city }}' disabled/>
								</div>


								<div class='col-2'>
									<label for='address_postcode'>Postcode</label>
									<input class='w-100' type='text' id='address_postcode' value='{{ $charity->details->address_postcode }}' disabled/>
								</div>

							</div>


							<div class='row mt-4'>
								<div class='col-12 d-flex justify-content-end'>
									<a class='btn btn-secondary mr-2' id='refresh_charity_records' charity_id='{{ $charity->id }}'>
										<i class='spinner fas fa-circle-notch'></i>
										Refresh Records
									</a>
									<a class='btn btn-primary mr-0' id='submit_charity_details_records' charity_id='{{ $charity->id }}'>
										<i class='spinner fas fa-circle-notch'></i>
										Submit Information</a>
									</a>
								</div>
							</div>
						</div>



						<div class='card form mt-4' id='charity_details_records'>
							<form id='form_charity_representative_records' action='{{ route('charities-dashboard_representative', ['charity_id' => $charity->id]) }}' enctype='multipart/form-data' method='POST'>@csrf</form>
							<div class='row'>

								<div class='col-12 mb-3'>
									<h4>Representative Details</h4>
									<p><small>We need one of your trustees to represent your charity on DashDonate.org.</small></p>
								</div>

								<div class='col-6 border-right'>
									<label for='invite_staff_email'>Invite a trustee to represent your charity</label></br>
									<div class='input-group'>
										<input type='text' id='invite_staff_email' value='' placeholder='trustee@charity.org' name='invite_staff_email'/>
										<span class='input-group-btn'>
											<a class='btn btn-primary' charity_id='{{ $charity->id }}' id='invite_rep_submit'>Invite</a>
										</span>
									</div>
									<p class='form_error_message' for='invite_staff_email'>Please select a trustee.</p>
								</div>

								<div class='col-6'>
									<label for='trustee'>If you are a trustee of this charity, select your name</label>
									<select name='trustee_id' form='form_charity_representative_records' id='trustee'/>
										<option selected value=''>Please select</option>
										<optgroup label='Your trustees'>
										@foreach ($trustees as $trustee)
											@if (@$charity->representative->trustee_number == $trustee->trustee_number)
												<option value='{{ $trustee->trustee_number }}' selected>{{ $trustee->name }}</option>
											@else
												<option value='{{ $trustee->trustee_number }}'>{{ $trustee->name }}</option>
											@endif
										@endforeach
										</optgroup>
									</select>
									<p class='form_error_message' for='trustee'>Please select a trustee.</p>
								</div>

							</div>


							@if (@$charity->representative)
								<div class='representative_details_block row mx-0 px-0 show'>
							@else
								<div class='representative_details_block row mx-0 px-0'>
							@endif
								<div class='row'>

									<hr/>

									<div class='col-4'>
										<label for='representative_firstname'>Legal first name</label>
										<input class='w-100' form='form_charity_representative_records' type='text' name='representative_firstname' id='representative_firstname' value='{{ @$charity->representative->legal_firstname }}' required/>
										<p class='form_error_message' for='representative_firstname'>A charity name is required.</p>
									</div>

									<div class='col-5'>
										<label for='representative_lastname'>Legal last name</label>
										<input class='w-100' form='form_charity_representative_records' type='text' name='representative_lastname' id='representative_lastname' value='{{ @$charity->representative->legal_lastname }}' required/>
										<p class='form_error_message' for='representative_lastname'>A charity name is required.</p>
									</div>


									<div class='col-3'>
										<label for='representative_dob'>Date of Birth</label>
										<input class='w-100' form='form_charity_representative_records' type='date' name='representative_dob' id='representative_dob' value='{{ @date('Y-m-d', strtotime(@$charity->representative->date_of_birth)) }}' required/>
										<p class='form_error_message' for='representative_dob'>A charity name is required.</p>
									</div>



									<div class='col-6'>
										<label for='representative_phone'>Trustee phone number</label>
										<input class='w-100' form='form_charity_representative_records' type='text' name='representative_phone' id='representative_phone' value='{{ @$charity->representative->phone_number }}' required/>
										<p class='form_error_message' for='representative_phone'>A phone number is required.</p>
									</div>

									<div class='col-6'>
										<label for='representative_email'>Trustee email address</label>
										<input class='w-100' form='form_charity_representative_records' type='text' name='representative_email' id='representative_email' value='{{ @$charity->representative->email_address }}' required/>
										<p class='form_error_message' for='representative_email'>A phone number is required.</p>
									</div>



									<div class='col-12 mb-0 mt-4'>
										<h6>Correspondance Address</h6>
									</div>

									<div class='col-3'>
										<label for='representative_address_line_1'>Address Line 1</label>
										<input class='w-100' type='text' name='representative_address_line_1' form='form_charity_representative_records' id='representative_address_line_1' value='{{ @$charity->representative->address_line_1 }}'/>
									</div>


									<div class='col-4'>
										<label for='representative_address_line_2'>Address Line 2</label>
										<input class='w-100' type='text' name='representative_address_line_2' form='form_charity_representative_records' id='representative_address_line_2' value='{{ @$charity->representative->address_line_2 }}'/>
									</div>


									<div class='col-3'>
										<label for='representative_address_town_city'>Town/City</label>
										<input class='w-100' type='text' name='representative_address_town_city' form='form_charity_representative_records' id='representative_address_town_city' value='{{ @$charity->representative->address_town_city }}'/>
									</div>


									<div class='col-2'>
										<label for='representative_address_postcode'>Postcode</label>
										<input class='w-100' type='text' name='representative_address_postcode' form='form_charity_representative_records' id='representative_address_postcode' value='{{ @$charity->representative->address_postcode }}'/>
									</div>





									<div class='col-12 mb-0 mt-4'>
										<h6>Supporting Documents</h6>
										<p><small>We need to verify your identify.</small></p>
									</div>




									<div class='col-4'>
										<label for='id_front'>ID front<i class='fas fa-question-circle tooltip_handle' data-toggle='tooltip' data-placement='left' title='XXX'></i></label>
										<div class='custom-file'>
										@if (@$charity->representative->stripe_id_front)
											<input type='text' form='form_charity_representative_records' name='rep_stripe_id_front' value='{{ $charity->representative->stripe_id_front }}'/>
										@else
											<form id='upload_id_front' class='id_document_uploader_form' method='POST' enctype='multipart/form-data'>
												<input type='hidden' name='charity_id' value='{{ $charity->id }}'/>
												<input type='hidden' name='user_id' value='{{ Auth::user()->id }}'/>
												<input type='hidden' name='type' value='id_front'/>
												<input class='form-control custom-file-input id_document_uploader' accept='image/png,image/jpeg' id='id_front' name='file_upload' type='file'/>
											</form>
											<label class='custom-file-label' for='id_front'>Choose file</label>
											<div class='invalid-feedback'>Example invalid custom file feedback</div>
										@endif
										</div>
									</div>


									<div class='col-4'>
										<label for='id_back'>ID back<i class='fas fa-question-circle tooltip_handle' data-toggle='tooltip' data-placement='left' title='XXX'></i></label>
										<div class='custom-file'>
										@if (@$charity->representative->stripe_id_back)
											<input type='text' form='form_charity_representative_records' name='rep_stripe_id_back' value='{{ $charity->representative->stripe_id_back }}'/>
										@else
											<form id='upload_id_back' class='id_document_uploader_form' method='POST' enctype='multipart/form-data'>
												<input type='hidden' name='charity_id' value='{{ $charity->id }}'/>
												<input type='hidden' name='user_id' value='{{ Auth::user()->id }}'/>
												<input type='hidden' name='type' value='id_back'/>
												<input class='form-control custom-file-input id_document_uploader' accept='image/png,image/jpeg' id='id_back' name='file_upload' type='file'/>
											</form>
											<label class='custom-file-label' for='id_back'>Choose file</label>
											<div class='invalid-feedback'>Example invalid custom file feedback</div>
										@endif
										</div>
									</div>



									<div class='col-4'>
										<label for='proof_of_address'>Proof of address<i class='fas fa-question-circle tooltip_handle' data-toggle='tooltip' data-placement='left' title='XXX'></i></label>
										<div class='custom-file'>
										@if (@$charity->representative->stripe_proof_of_address)
											<input type='text' form='form_charity_representative_records' name='rep_stripe_proof_of_address' value='{{ $charity->representative->stripe_proof_of_address }}'/>
										@else
											<form id='upload_proof_of_address' class='id_document_uploader_form' method='POST' enctype='multipart/form-data'>
												<input type='hidden' name='charity_id' value='{{ $charity->id }}'/>
												<input type='hidden' name='user_id' value='{{ Auth::user()->id }}'/>
												<input type='hidden' name='type' value='proof_of_address'/>
												<input class='form-control custom-file-input id_document_uploader' accept='image/png,image/jpeg' id='proof_of_address' name='file_upload' type='file'/>
											</form>
											<label class='custom-file-label' for='proof_of_address'>Choose file</label>
											<div class='invalid-feedback'>Example invalid custom file feedback</div>
										@endif
										</div>
									</div>










									{{-- Requirements for ID verification

	Acceptable documents vary by country, although a passport scan is always acceptable and preferred.
	Scans of both the front and back are usually required for government-issued IDs and driver’s licenses.
	Files need to be JPEGs or PNGs smaller than 10MB. We can’t verify PDFs.
	Files should be in color, be rotated with the image right-side up, and have all information clearly legible. --}}

								</div>


								<div class='row mt-4 w-100 mx-0'>
									<div class='col-12 d-flex justify-content-end px-0 mx-0'>
										<a class='btn btn-primary mr-0' id='submit_charity_representative_records' charity_id='{{ $charity->id }}'>
											<i class='spinner fas fa-circle-notch'></i>
											Submit Information</a>
										</a>
									</div>
								</div>


							{{-- <pre>
								{{ var_dump($charity) }}
							</pre> --}}
							</div>
						</div>


						@if (@$charity->representative->user_id == Auth::user()->id)
							<div class='card form mt-4'>

								<form id='charity_details_records_form' action='{{ route('charities-dashboard_setup', ['charity_id' => $charity->id]) }}' method='POST'>@csrf</form>
								<div class='row'>


									<div class='col-12 mb-3'>
										<h4>Bank Account Details</h4>
										<p><small>To receive donations you must register a bank account.</small></p>
									</div>

									<div class='col-3'>
										<label for='charity_reg'>Charity reg no</label>
										<input class='w-100' type='text' name='charity_reg' id='charity_reg' value='{{ $charity->charity_registration_number }}' disabled/>
										<p class='form_error_message' for='charity_reg'>A charity registration number is required.</p>
									</div>


									<div class='col-5'>
										<label for='charity_name'>Charity name</label> {{-- Choice from 'trading names' in companies house --}}
										<input class='w-100' form='charity_details_records_form' type='text' name='charity_name' id='charity_name' value='{{ $charity->details->charity_name }}' required/>
										<p class='form_error_message' for='charity_name'>A charity name is required.</p>
									</div>


									<div class='col-4'>
										<label for='country'>Select country</label>
										<select name='country' id='country' disabled/>
											<option default selected value='United Kingdom' disabled>United Kingdom</option>
										</select>
									</div>


									<div class='col-8'>
										<label for='charity_website'>Website address (or a verified social media profile)</label>
										<div class='website_input_block'>
											<input class='w-100' form='charity_details_records_form' type='text' name='charity_website' id='charity_website' value='{{ $charity->details->charity_website }}' required/>
											<label for='charity_website' class='website_input'>https://</label>
										</div>
										<p class='form_error_message' for='charity_website'>A charity website is required.</p>
									</div>


									<div class='col-4'>
										<label for='phone_number'>Main phone number</label>
										<input class='w-100' form='charity_details_records_form' type='text' name='phone_number' id='phone_number' value='{{ $charity->details->phone_number }}' required/>
										<p class='form_error_message' for='phone_number'>A phone number is required.</p>
									</div>

									<div class='col-12'>
										<p class='mt-3 mb-3'>Your charity's registered address <small>(If this is incorrect, please update your address with your local charity commission)</small></p>
									</div>

									<div class='col-3'>
										<label for='address_line_1'>Address Line 1</label>
										<input class='w-100' type='text' id='address_line_1' value='{{ $charity->details->address_line_1 }}' disabled/>
									</div>


									<div class='col-4'>
										<label for='address_line_2'>Address Line 2</label>
										<input class='w-100' type='text' id='address_line_2' value='{{ $charity->details->address_line_2 }}' disabled/>
									</div>


									<div class='col-3'>
										<label for='address_town_city'>Town/City</label>
										<input class='w-100' type='text' id='address_town_city' value='{{ $charity->details->address_town_city }}' disabled/>
									</div>


									<div class='col-2'>
										<label for='address_postcode'>Postcode</label>
										<input class='w-100' type='text' id='address_postcode' value='{{ $charity->details->address_postcode }}' disabled/>
									</div>

								</div>


								<div class='row mt-4'>
									<div class='col-12 d-flex justify-content-end'>
										<a class='btn btn-secondary mr-2' id='refresh_charity_records' charity_id='{{ $charity->id }}'>
											<i class='spinner fas fa-circle-notch'></i>
											Refresh Records
										</a>
										<a class='btn btn-primary mr-0' id='submit_charity_details_records' charity_id='{{ $charity->id }}'>
											<i class='spinner fas fa-circle-notch'></i>
											Submit Information</a>
										</a>
									</div>
								</div>


							</div>
						@endif






					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
