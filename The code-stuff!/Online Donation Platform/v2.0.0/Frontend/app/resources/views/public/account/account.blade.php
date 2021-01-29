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
	<hero class='bg-blue w-100 d-flex align-items-center'>
		<div class='container py-5'>
			<div class='col py-3 text-center'>
				<h1>Account Settings</h1>
				<p class='mb-0'>Manage your DashDonate.org account</p>
			</div>
		</div>
	</hero>

	<div class='w-100'>
		<div class='container px-0 py-5 d-flex justify-content-center'>
			<div class='py-3 px-0'>


				@php $error_messages = 0; @endphp


				@if(session('success'))
					<div class='col px-0 d-flex mb-1 justify-content-center'>
						<div class='alert mb-1 alert-success w-100 mx-0'>
							<p class='m-0 p-0'>
								<i class='fas fa-check-circle'></i>
								{{ session('success') }}
							</p>
						</div>
					</div>
				@endif

				@error('error')
					<div class='col px-0 d-flex mb-1 justify-content-center'>
						<div class='alert mb-1 alert-danger w-100 mx-0'>
							<p class='m-0 p-0'>
								<i class='fas fa-exclamation-triangle'></i>
								{{ $message }}
							</p>
						</div>
					</div>
				@enderror


				<div class='col-12 px-0 mb-4 mt-0 max_w_460'>
					<div class='alert alert-info w-100 m-0'>
						<p class='m-0 p-0'>
							<i class='fas fa-info'></i>
							If you have any queries or requests regarding the data we store, please get in touch with us at <a href='mailto:team@dashdonate.org' target='_blank'>team@dashdonate.org</a>.
						</p>
					</div>
				</div>


				<div class='max_w_460 mb-4'>
					<div class='card'>
						<div class='col-12 px-0 mb-0 mt-0'>
							<h5 class='mb-3'>Your Details</h5>
						</div>
						<form class='row auto_validate_forms' id='public-account-update_details' action='{{ route('public-account-update_details') }}' method='POST'>@csrf

							<div class='col-6'>
								<label for='firstname'>First name</label>
								@if (old('firstname'))
									<input class='w-100' form='public-account-update_details' type='text' name='firstname' id='firstname' value='{{ old('firstname') }}' required/>
								@else
									<input class='w-100' form='public-account-update_details' type='text' name='firstname' id='firstname' value='{{ Auth::user()->firstname }}' required/>
								@endif

								<div class='form_error_container' field='firstname'>
								@error('firstname')
									<p>{{ $message }}</p>
								@enderror
								</div>
							</div>


							<div class='col-6'>
								<label for='lastname'>Last name</label>
								@if (old('lastname'))
									<input class='w-100' form='public-account-update_details' type='text' name='lastname' id='lastname' value='{{ old('lastname') }}' required/>
								@else
									<input class='w-100' form='public-account-update_details' type='text' name='lastname' id='lastname' value='{{ Auth::user()->lastname }}' required/>
								@endif

								<div class='form_error_container' field='lastname'>
								@error('lastname')
									<p>{{ $message }}</p>
								@enderror
								</div>
							</div>


							<div class='col-12 mt-3'>
								<input type='submit' class='btn btn-block btn-primary mx-0 mb-0' form='public-account-update_details' value='Update your details'/>
							</div>


						</form>
					</div>
				</div>


				<div class='max_w_460 mb-4'>
					<div class='card'>
						<div class='col-12 px-0 mb-0 mt-0'>
							<h5 class='mb-3'>Your Saved Card</h5>
						</div>
						<div class='row user_cards'>
							@if (@sizeof($billing->sources) == 0)
								<div class='alert alert-info w-100 m-0 mx-3'>
									<p class='m-0 p-0'>
										<i class='fas fa-info ml-0'></i>
										Your card will show up here once you have made your first donation.
									</p>
								</div>
							@else
								<div class='billing_card'>
									<i class='fas fa-credit-card'></i>
									<p class='card_num'>**** **** **** {{ $billing->sources[0]->last_four_digits }}</p>
									<p class='expires'>Expiry: {{ date('m/Y', strtotime($billing->sources[0]->expiry_date)) }}</p>
									<p class='date_added'>Added on the {{ date('jS F Y \a\t g:ia', strtotime($billing->sources[0]->date_added)) }}</p>
								</div>
							@endif
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>
@endsection
