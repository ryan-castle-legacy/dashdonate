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
				<h1>Identification Documents</h1>
				<p class='mb-3'>To prove your identity, we need some documents from you.</p>
			</div>
		</div>


		<div class='container pb-0'>
			<form id='charities-administration-representative_identity' action='{{ route('charities-onboarding-representative_identity', ['charity_slug' => $charity->slug]) }}' method='POST'>@csrf</form>


			<div class='col d-flex mb-4 justify-content-center'>
				<div class='card card_form form'>
					<div class='row'>


						<div class='col-12 mb-1 mt-0'>
							<h5 class='mb-0'>Proof of identity</h5>
							<p><small>We need a valid identity document from you.</small></p>
						</div>


						<div class='col-12 collapsable_file_container'>
							@if (@$charity->representative->details->stripe_id_front != null)
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
							@if (@$charity->representative->details->stripe_id_front != null)
								<div class='collapsable_file collapsed'>
							@else
								<div class='collapsable_file'>
							@endif
								<label for='stripe_id_front'>Upload your passport or driving license</label>
								<div class='custom-file' file_name='stripe_id_front'>
									<form method='POST' id='form_stripe_id_front' class='file_upload_form' enctype='multipart/form-data'>
										@csrf
										<input type='hidden' name='file_intent' value='stripe_id_front'/>
										<input type='hidden' name='charity_id' value='{{ $charity->id }}'/>
										<input type='hidden' name='user_id' value='{{ Auth::user()->id }}'/>
										<div class='col-12'>
											<input type='file' class='custom-file-input' id='stripe_id_front' name='file_upload' accept='image/png,image/jpeg'/>
											<label class='custom-file-label' for='stripe_id_front'>Choose file</label>
										</div>
									</form>
									<input type='submit' form='form_stripe_id_front' class='btn btn-primary w-100 m-0 mt-2 file-submit' value='Upload'>
									<div class='form_error_container mt-2' field='stripe_id_front'></div>
									<div class='form_success_container mt-2' field='stripe_id_front'></div>
								</div>
							</div>
						</div>


						<div class='col-12 mb-1 mt-4'>
							<h5 class='mb-0'>Proof of address</h5>
							<p><small>We need you to prove your address.</small></p>
						</div>


						<div class='col-12 collapsable_file_container'>
							@if (@$charity->representative->details->stripe_proof_of_address != null)
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
							@if (@$charity->representative->details->stripe_proof_of_address != null)
								<div class='collapsable_file collapsed'>
							@else
								<div class='collapsable_file'>
							@endif
								<label for='stripe_proof_of_address'>Upload proof of your address</label>
								<div class='custom-file' file_name='stripe_proof_of_address'>
									<form method='POST' id='form_stripe_proof_of_address' class='file_upload_form' enctype='multipart/form-data'>
										@csrf
										<input type='hidden' name='file_intent' value='stripe_proof_of_address'/>
										<input type='hidden' name='charity_id' value='{{ $charity->id }}'/>
										<input type='hidden' name='user_id' value='{{ Auth::user()->id }}'/>
										<div class='col-12'>
											<input type='file' class='custom-file-input' id='stripe_proof_of_address' name='file_upload' accept='image/png,image/jpeg'/>
											<label class='custom-file-label' for='stripe_proof_of_address'>Choose file</label>
										</div>
									</form>
									<input type='submit' form='form_stripe_proof_of_address' class='btn btn-primary w-100 m-0 mt-2 file-submit' value='Upload'>
									<div class='form_error_container mt-2' field='stripe_proof_of_address'></div>
									<div class='form_success_container mt-2' field='stripe_proof_of_address'></div>
								</div>
							</div>
						</div>


						<div class='col-12 id_submit_btn d-none'>
							<p class='m-0 w-100 mt-3'>
								<input type='submit' form='charities-administration-representative_identity' class='btn btn-block mx-0 my-0 btn-primary' value='Submit' disabled/>
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
	{{-- <pre>{{ var_dump($charity->representative->details) }}</pre> --}}
@endsection
