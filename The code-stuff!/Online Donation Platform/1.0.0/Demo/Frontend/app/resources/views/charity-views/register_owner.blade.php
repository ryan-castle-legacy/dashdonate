@extends('layouts.main')

@section('content')
	<div class='flex-middle bg-blue min-height-100'>
		<div class='container w-100 flex-middle'>
			<div class='col py-3'>
				<div class='row'>
					<div class='col align-center flex-middle'>
						<h1 class='mb-0'>Employee Details</h1>
						<p>We need some information about you</p>
					</div>
				</div>
				<div class='row align-center flex-middle'>
					<div class='card login_card'>
						<form method='POST' class='col' action='{{ route('register') }}'>
							@csrf
							<label for='firstname'>First name</label>
							<input type='text' name='firstname' id='firstname'/>
							<label for='lastname' class='flex-apart'>Last name</label>
							<input type='text' name='lastname' id='lastname'/>
							<label for='email'>Work email address</label>
							<input type='email' name='email' id='email'/>
							<label for='password' class='flex-apart'>Create password</label>
							<input type='password' name='password' id='password'/>
							<label for='password_confirmation' class='flex-apart'>Confirm password</label>
							<input type='password' class='mb-0' name='password_confirmation' id='password_confirmation'/>
							<input type='submit' class='btn btn-primary mt-1 ml-0 mr-0 mb-0' value='Register'/>
							<p class='small_print mb-0'><small>By clicking "register" you are agreeing to our <a href='{{ route('public-terms') }}' target='_blank'>terms of service</a> and <a href='{{ route('public-privacy') }}' target='_blank'>privacy policy</a>.</small></p>
						</form>
					</div>
				</div>
				<div class='row align-center flex-middle'>
					<hr class='small mt-3'/>
				</div>
				<div class='row align-center flex-middle'>
					<p>Already have a DashDonate account?</p>
				</div>
				<div class='row align-center flex-middle'>
					<a href='{{ route('login') }}' class='btn btn-primary'>Login</a>
				</div>
			</div>
		</div>
	</div>
@endsection
