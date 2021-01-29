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
				<h1>Email Confirmation</h1>
				<p class='mb-3'>We've sent a code to your email address to verify your account.</p>
			</div>
		</div>
		<form class='auto_validate_forms' id='public-verify_email' action='{{ route('verify_email') }}' method='POST' class='container pb-5'>
			@csrf


			<div class='col d-flex mb-4 justify-content-center'>
				<div class='card card_form form'>
					<div class='row'>


						<div class='col-12'>
							<label for='code'>Verification code</label>
							<input class='w-100' form='public-verify_email' type='number' name='code' id='code' value='{{ old('code') }}' minlength='4' maxlength='4' required/>

							<div class='form_error_container' field='code'>
							@error('code')
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
							<input type='submit' class='btn btn-block btn-primary mx-0' form='public-verify_email' value='Confirm Code'/>
						</div>


						<p class='mb-0 mt-3 text-center w-100'><a href='{{ route('public-onboarding-register_resend') }}'>Resend code</a></p>


					</div>


				</div>
			</div>
		</form>
	</div>

@endsection
