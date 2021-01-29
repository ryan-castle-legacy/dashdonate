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
				<h1>Invite a Trustee</h1>
				<p class='mb-3'>Invite a trustee to represent your charity on DashDonate.org.</p>
			</div>
		</div>
		<form class='auto_validate_forms container pb-5' id='charities-onboarding-invite_representative' action='{{ route('charities-onboarding-invite_representative', ['charity_slug' => $charity->slug]) }}' method='POST'>
			@csrf


			<div class='col d-flex mb-4 justify-content-center'>
				<div class='card card_form form'>
					<div class='row'>


						<div class='col-12'>
							<label for='email'>Email address</label>
							<input class='w-100' type='email' name='email' id='email' value='{{ old('email') }}' required/>

							<div class='form_error_container' field='email'>
							@error('email')
								<p>{{ $message }}</p>
							@enderror
							</div>

							@if(session('success'))
								<div class='form_success_container'>
									<p>{{ session('success') }}</p>
								</div>
							@enderror

						</div>


						<div class='col-12 mt-3'>
							<input type='submit' class='btn btn-block btn-primary mx-0' form='charities-onboarding-invite_representative' value='Invite Representative'/>
						</div>


					</div>
				</div>
			</div>


			<p class='w-100 text-center'><a href='{{ route('charities-onboarding-confirm_details', ['charity_slug' => $charity->slug]) }}'>Go back</a></p>


		</form>
	</div>
@endsection
