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
				<h1>Register Account</h1>
				<p class='mb-3'>Let's create an account for you.</p>
			</div>
		</div>
		<form class='auto_validate_forms' id='public-onboarding-capture_email' action='{{ route('public-onboarding-register') }}' method='POST' class='container pb-5'>
			@csrf


			<div class='col d-flex mb-4 justify-content-center'>
				<div class='card card_form form'>
					<div class='row'>



						<div class='col-6'>
							<label for='firstname'>First name</label>
							<input class='w-100' form='public-onboarding-capture_email' type='text' name='firstname' id='firstname' value='{{ old('firstname') }}' required/>

							<div class='form_error_container' field='firstname'>
							@error('firstname')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-6'>
							<label for='firstname'>Last name</label>
							<input class='w-100' form='public-onboarding-capture_email' type='text' name='lastname' id='lastname' value='{{ old('lastname') }}' required/>

							<div class='form_error_container' field='lastname'>
							@error('lastname')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-12'>
							<label for='email'>Email address</label>

							@if (@Cookie::get('register_email'))
								<input class='w-100' form='public-onboarding-capture_email' type='email' name='email' id='email' value='{{ Cookie::get('register_email') }}' required/>
							@else
								<input class='w-100' form='public-onboarding-capture_email' type='email' name='email' id='email' value='{{ old('email') }}' required/>
							@endif


							<div class='form_error_container' field='email'>
							@error('email')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-12'>
							<label for='password'>Password</label>
							<input class='w-100' form='public-onboarding-capture_email' type='password' name='password' id='password' value='{{ old('password') }}' required/>

							<div class='form_error_container' field='password'>
							@error('password')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-12'>
							<label for='password_confirmation'>Confirm password</label>
							<input class='w-100' form='public-onboarding-capture_email' type='password' name='password_confirmation' id='password_confirmation' value='{{ old('password_confirmation') }}' must_match='password' required/>

							<div class='form_error_container' field='password_confirmation'>
							@error('password_confirmation')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-12'>
							<p class='small_print my-1'>
								<small>
									By clicking "register" you are agreeing to our
									<a href='{{ route('public-legal-terms') }}' target='_blank'>terms of service</a>
									and
									<a href='{{ route('public-legal-privacy') }}' target='_blank'>privacy policy</a>.
								</small>
							</p>
						</div>


						<div class='col-12 mt-3'>
							<input type='submit' class='btn btn-block btn-primary mx-0' form='public-onboarding-capture_email' value='Register'/>
						</div>


					</div>
				</div>
			</div>
		</form>
	</div>

@endsection
