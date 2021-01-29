@extends('layouts.main')




@section('pre-scripts')
@endsection




@section('post-scripts')
@endsection




@section('pre-styles')
@endsection




@section('post-styles')
@endsection




@section('content')
	<div class='bg-blue w-100 min-height-100 pb-5'>
		<div class='container pt-5'>
			<div class='col py-3 text-center'>
				<h1>Representative Details</h1>
				<p class='mb-3'>We need some personal information about you.</p>
			</div>
		</div>


		<form class='auto_validate_forms container pb-5' id='charities-onboarding-representative_details_personal' action='{{ route('charities-onboarding-representative_details_personal', ['charity_slug' => $charity->slug]) }}' method='POST'>
			@csrf
			<input type='hidden' name='trustee_id' value='{{ $trustee->trustee_number }}' required/>


			<div class='col d-flex mb-4 justify-content-center'>
				<div class='card card_form form'>
					<div class='row'>


						@error('trustee_id')
							<div class='col px-0 d-flex mb-1 justify-content-center'>
								<div class='alert alert-danger w-100 mx-3'>
									<p class='m-0 p-0'>
										<i class='fas fa-times-circle'></i>
										{{ $message }}
									</p>
								</div>
							</div>
						@enderror


						<div class='col-12 mb-1 mt-0'>
							<h5 class='mb-0'>Basic information</h5>
							<p><small>We need some personal information about you.</small></p>
						</div>


						<div class='col-6'>
							<label for='legal_firstname'>Legal first name</label>

							@if (old('legal_firstname'))
								<input class='w-100' type='text' name='legal_firstname' id='legal_firstname' value='{{ old('legal_firstname') }}' required/>
							@else
								<input class='w-100' type='text' name='legal_firstname' id='legal_firstname' value='{{ @Auth::user()->firstname }}' required/>
							@endif

							<div class='form_error_container' field='legal_firstname'>
							@error('legal_firstname')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-6'>
							<label for='legal_lastname'>Legal last name</label>

							@if (old('legal_lastname'))
								<input class='w-100' type='text' name='legal_lastname' id='legal_lastname' value='{{ old('legal_lastname') }}' required/>
							@else
								<input class='w-100' type='text' name='legal_lastname' id='legal_lastname' value='{{ @Auth::user()->lastname }}' required/>
							@endif

							<div class='form_error_container' field='legal_lastname'>
							@error('legal_lastname')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-12'>
							<label for='telephone_number'>Telephone number</label>
							<div class='input-group'>
								<div class='input-group-prepend'>
									<span class='input-group-text'>&plus;44</span>
								</div>
								<input class='w-100 form-control' type='tel' name='telephone_number' id='telephone_number' value='{{ old('telephone_number') }}' maxlength='11' placeholder='1234 567890' autocomplete='no' required/>
							</div>

							<div class='form_error_container' field='telephone_number'>
							@error('telephone_number')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-12'>
							<label for='date_of_birth-day'>Date of birth</label>
							<div class='input-group'>
								@if (@old('date_of_birth'))
									<input class='w-100 form-control date-format form_collective' type='number' collective='date_of_birth' id='date_of_birth-day' value='{{ date('d', strtotime(old('date_of_birth'))) }}' maxlength='2' maxvalue='31' minvalue='1' placeholder='DD' autocomplete='no' required/>

									<input class='w-100 form-control date-format form_collective' type='number' collective='date_of_birth' id='date_of_birth-month' value='{{ date('m', strtotime(old('date_of_birth'))) }}' maxlength='2' maxvalue='12' minvalue='1' placeholder='MM' autocomplete='no' required/>

									<input class='w-100 form-control date-format form_collective' type='number' collective='date_of_birth' id='date_of_birth-year' value='{{ date('Y', strtotime(old('date_of_birth'))) }}' maxlength='4' maxvalue='{{ date('Y', time()) }}' minvalue='1' placeholder='YYYY' autocomplete='no' required/>
								@else
									<input class='w-100 form-control date-format form_collective' type='number' collective='date_of_birth' id='date_of_birth-day' value='' maxlength='2' maxvalue='31' minvalue='1' placeholder='DD' autocomplete='no' required/>

									<input class='w-100 form-control date-format form_collective' type='number' collective='date_of_birth' id='date_of_birth-month' value='' maxlength='2' maxvalue='12' minvalue='1' placeholder='MM' autocomplete='no' required/>

									<input class='w-100 form-control date-format form_collective' type='number' collective='date_of_birth' id='date_of_birth-year' value='' maxlength='4' maxvalue='{{ date('Y', time()) }}' minvalue='1' placeholder='YYYY' autocomplete='no' required/>
								@endif
							</div>

							<input type='hidden' valid_date name='date_of_birth' value='{{ old('date_of_birth') }}' required/>

							<div class='form_error_container' field='date_of_birth'>
							@error('date_of_birth')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-12 mb-1 mt-4'>
							<h5 class='mb-0'>Your personal address</h5>
							<p><small>For us to perform identity checks, we need your personal address.</small></p>
						</div>


						<div class='col-12'>
							<label for='address_line_1'>Address line 1</label>
							<input class='w-100' type='text' name='address_line_1' id='address_line_1' value='{{ old('address_line_1') }}' required/>

							<div class='form_error_container' field='address_line_1'>
							@error('address_line_1')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-12'>
							<label for='address_line_2'>Address line 2</label>
							<input class='w-100' type='text' name='address_line_2' id='address_line_2' value='{{ old('address_line_2') }}' required/>

							<div class='form_error_container' field='address_line_2'>
							@error('address_line_2')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-7'>
							<label for='address_town_city'>Town or city</label>
							<input class='w-100' type='text' name='address_town_city' id='address_town_city' value='{{ old('address_town_city') }}' required/>

							<div class='form_error_container' field='address_town_city'>
							@error('address_town_city')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-5'>
							<label for='address_postcode'>Postcode</label>
							<input class='w-100' type='text' name='address_postcode' id='address_postcode' value='{{ old('address_postcode') }}' required/>

							<div class='form_error_container' field='address_postcode'>
							@error('address_postcode')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-12'>
							<p class='m-0 w-100 mt-3'>
								<input type='submit' form='charities-onboarding-representative_details_personal' class='btn btn-block mx-0 my-0 btn-primary' value='Submit'/>
							</p>
						</div>


						@error('err_report')
							<div class='col px-0 d-flex mb-0 mt-3 justify-content-center'>
								<div class='alert alert-danger w-100 mx-3'>
									<p class='m-0 p-0'>
										<i class='fas fa-times-circle'></i>
										{{ (json_decode($message))->message }}
									</p>
								</div>
							</div>
						@enderror


					</div>
				</div>
			</div>


			<p class='w-100 text-center'><a href='{{ route('charities-onboarding-confirm_details', ['charity_slug' => $charity->slug, 'optional' => 'representative']) }}'>Go back</a></p>


		</form>
	</div>
@endsection
