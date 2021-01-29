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
				<p class='mb-3'>As a trustee, we need you to represent your charity on DashDonate.org.</p>
			</div>
		</div>


		<form class='auto_validate_forms container pb-5' id='charities-onboarding-representative_details' action='{{ route('charities-onboarding-confirm_details_representative', ['charity_slug' => $charity->slug]) }}' method='POST'>
			@csrf


			<div class='col d-flex mb-4 justify-content-center'>
				<div class='card card_form form'>
					<div class='row'>


						<div class='col-12'>

							@switch($trustees)
								@case(false)
								@case('invalid_crn')
								@case('commission_not_found')

									<div class='form_error_container'>
										<p>Something went wrong when searching for your trustees, please refresh to try again. If this keeps happening, contact us at <a href='mailto:charities@dashdonate.org'>charities@dashdonate.org</a>.</p>
									</div>

								@break
								@default

									<label for='trustee_id'>Choose your name</label>
									<select class='w-100' name='trustee_id' id='trustee_id' required>
										<option selected value=''>Please select</option>
										<optgroup label='Your trustees'>
										@foreach ($trustees as $trustee)
											<option value='{{ $trustee->trustee_number }}'>{{ $trustee->name }}</option>
										@endforeach
										</optgroup>
									</select>


									<div class='form_error_container' field='trustee_id'>
									@error('trustee_id')
										<p>{{ $message }}</p>
									@enderror
									</div>

									@if(session('success'))
										<div class='form_success_container'>
											<p>{{ session('success') }}</p>
										</div>
									@enderror

								@break
							@endswitch

						</div>


						@if (@sizeof($trustees) > 0 && @gettype($trustees) == 'array')

							<div class='col-12'>
								<div class='checkbox-input mb-0'>
									<input type='checkbox' id='must_agree' required>
									<label class='form-check-label' for='must_agree'>I confirm that I am legally responsible for this charity.</label>
								</div>

								<div class='form_error_container' field='must_agree'>
								@error('must_agree')
									<p>{{ $message }}</p>
								@enderror
								</div>
							</div>


							<div class='col-12'>
								<p class='m-0 w-100 mt-3'>
									<input type='submit' form='charities-onboarding-representative_details' class='btn btn-block mx-0 my-0 btn-primary' value='Next'/>
								</p>
							</div>

						@endif


					</div>
				</div>
			</div>


			<p class='w-100 text-center'><a href='{{ route('charities-onboarding-confirm_details', ['charity_slug' => $charity->slug]) }}'>Go back</a></p>


		</form>
	</div>
@endsection
