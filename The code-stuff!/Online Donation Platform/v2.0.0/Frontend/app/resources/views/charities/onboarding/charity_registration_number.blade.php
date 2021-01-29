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
				<h1>Charity Details</h1>
				<p class='mb-3'>We need some information about your charity.</p>
			</div>
		</div>
		<form class='auto_validate_forms container pb-5' id='charities-onboarding-charity_registration_number' action='{{ route('charities-onboarding-capture_details') }}' method='POST'>
			@csrf


			<div class='col d-flex mb-4 justify-content-center'>
				<div class='card card_form form'>
					<div class='row'>


						<div class='col-12 mb-3 mt-0'>
							<div class='alert alert-info w-100 m-0'>
								<p class='m-0 p-0'>
									<i class='fas fa-info ml-0'></i>
									Our on-boarding process currently only supports charities registered in England and Wales. <a href='mailto:charities@dashdonate.org' target='_blank'>Get in touch</a> with us if you wish to register today.
								</p>
							</div>
						</div>


						<div class='col-12'>
							<label for='country'>Select country</label>
							<select class='w-100' id='country' disabled>
								<option value='United Kingdom'>United Kingdom</option>
							</select>
						</div>


						<div class='col-12'>
							<label for='crn'>Charity registration number</label>
							<input class='w-100' form='charities-onboarding-charity_registration_number' type='text' name='crn' id='crn' value='{{ old('crn') }}' required/>

							<div class='form_error_container' field='crn'>
							@error('crn')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-12'>
							<p class='m-0'><small>By clicking "next" you are agreeing to our <a href='{{ route('public-legal-terms_for_charities') }}' target='_blank'>terms for charities</a>.</small></p>
						</div>


						<div class='col-12 mt-3'>
							<input type='submit' class='btn btn-block btn-primary mx-0' form='charities-onboarding-charity_registration_number' value='Next'/>
						</div>


					</div>
				</div>
			</div>


		</form>
	</div>
@endsection
