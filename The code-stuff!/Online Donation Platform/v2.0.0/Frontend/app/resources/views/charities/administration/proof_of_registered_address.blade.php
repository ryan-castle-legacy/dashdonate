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
				<h1>Charity Document</h1>
				<p class='mb-3'>We need some documents from your charity.</p>
			</div>
		</div>


		<div class='container pb-0'>
			<form id='charities-administration-collect_registered_address' action='{{ route('charities-onboarding-registered_address', ['charity_slug' => $charity->slug]) }}' method='POST'>@csrf</form>


			<div class='col d-flex mb-4 justify-content-center'>
				<div class='card card_form form'>
					<div class='row'>


						<div class='col-12 mb-1 mt-0'>
							<h5 class='mb-2'>Proof of registered address</h5>
							<p><small>We need a valid document from your charity that proves you are operating out of your registered address, <strong>
								{{ @$charity->details->address_line_1 }}
								{{ @$charity->details->address_line_2 }}
								{{ @$charity->details->address_town_city }}
								{{ @$charity->details->address_postcode }}
							</strong></small></p>
						</div>

						<div class='col-12 collapsable_file_container'>
							@if (@$charity->charity_proof_of_address_file_id != null)
								<div class='collapsable_file_removable'>
							@else
								<div class='collapsable_file_removable d-none'>
							@endif
								<div class='alert pl-2 mb-0 alert-success w-100'>
									<p class='m-0 p-0'>
										<i class='fas fa-check-circle'></i> Your document has been uploaded.
									</p>
								</div>
								<p class='m-0 mb-2 collapsable_file_replace'><small>Click here to replace file</small></p>
							</div>
							@if (@$charity->charity_proof_of_address_file_id != null)
								<div class='collapsable_file collapsed'>
							@else
								<div class='collapsable_file'>
							@endif
								<label for='stripe_id_front'>Upload a charity utility bill or bank statement</label>
								<div class='custom-file' file_name='charity_utility_bill'>
									<form method='POST' id='form_charity_utility_bill' class='file_upload_form' enctype='multipart/form-data'>
										@csrf
										<input type='hidden' name='file_intent' value='charity_utility_bill'/>
										<input type='hidden' name='charity_id' value='{{ $charity->id }}'/>
										<input type='hidden' name='user_id' value='{{ Auth::user()->id }}'/>
										<div class='col-12'>
											<input type='file' class='custom-file-input' id='charity_utility_bill' name='file_upload' accept='image/png,image/jpeg'/>
											<label class='custom-file-label' for='charity_utility_bill'>Choose file</label>
										</div>
									</form>
									<input type='submit' form='form_charity_utility_bill' class='btn btn-primary w-100 m-0 mt-2 file-submit' value='Upload'>
									<div class='form_error_container mt-2' field='charity_utility_bill'></div>
									<div class='form_success_container mt-2' field='charity_utility_bill'></div>
								</div>
							</div>
						</div>




						<div class='col-12 id_submit_btn d-none'>
							<p class='m-0 w-100 mt-3'>
								<input type='submit' form='charities-administration-collect_registered_address' class='btn btn-block mx-0 my-0 btn-primary' value='Submit' disabled/>
							</p>
						</div>


					</div>
				</div>
			</div>


			<div class='col py-3 text-center'>
				<p class='w-100 text-center'><a href='{{ route('charities-dashboard', ['charity_slug' => $charity->slug]) }}'>Go back</a></p>
			</div>


		</div>
	</div>
	<pre>{{ var_dump($charity->charity_proof_of_address_file_id) }}</pre>
@endsection
