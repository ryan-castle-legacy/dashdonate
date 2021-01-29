@extends('layouts.main')

@section('content')
	<div class='bg-blue w-100'>
		<div class='container pt-5'>
			<div class='col py-3 text-center'>
				<h1>Charity Employee Details</h1>
				<p class='mb-3'>We need some information about you.</p>
			</div>
		</div>
		<div class='container pb-5'>
			<form id='form_submit_charity_staff_form' action='{{ route('register') }}' method='POST'>@csrf</form>
			<div class='col d-flex mb-4 justify-content-center'>
				<div class='card card_form form'>

					<div class='row'>
						<div class='col-6'>
							<label for='firstname'>Your firstname</label>
							<input class='w-100' form='form_submit_charity_staff_form' type='text' name='firstname' id='firstname' value='{{ old('firstname') }}' required/>
							<p class='form_error_message' for='firstname'>Your firstname is required.</p>
						</div>

						<div class='col-6'>
							<label for='lastname'>Your lastname</label>
							<input class='w-100' form='form_submit_charity_staff_form' type='text' name='lastname' id='lastname' value='{{ old('lastname') }}' required/>
							<p class='form_error_message' for='lastname'>Your lastname is required.</p>
						</div>
					</div>

					<div>
						<label for='email'>Your work email address</label>
						<input class='w-100' form='form_submit_charity_staff_form' type='email' name='email' id='email' value='{{ old('email') }}' required/>
						<p class='form_error_message' for='email'>Your work email address is required.</p>
					</div>

					<div>
						<label for='password'>Password</label>
						<input class='w-100' form='form_submit_charity_staff_form' type='password' name='password' id='password' required/>
						<p class='form_error_message' for='password'>A password is required.</p>
					</div>

					<div>
						<label for='password_confirmation'>Confirm password</label>
						<input class='w-100' form='form_submit_charity_staff_form' type='password' name='password_confirmation' id='password_confirmation' required/>
						<p class='form_error_message' for='password_confirmation'>Please confirm your password.</p>
					</div>

					<div>
						<p class='small_print my-1'>
							<small>
								By clicking "register" you are agreeing to our
								<a href='{{ route('public-legal_terms') }}' target='_blank'>terms of service</a>
								and
								<a href='{{ route('public-legal_privacy') }}' target='_blank'>privacy policy</a>
								.
							</small>
						</p>
					</div>

					<div class='mt-3'>
						<a class='btn btn-primary m-0 w-100' id='submit_charity_staff_form'>
							<i class='spinner fas fa-circle-notch'></i>
							Register
						</a>
					</div>

				</div>
			</div>
		</div>
	</div>
@endsection
