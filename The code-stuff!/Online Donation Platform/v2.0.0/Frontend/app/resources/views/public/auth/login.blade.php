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
				<h1>Welcome Back</h1>
				<p class='mb-3'>Log in to access your account.</p>
			</div>
		</div>
		<form class='auto_validate_forms' id='public-login' action='{{ route('login') }}' method='POST' class='container pb-5'>
			@csrf


			<div class='col d-flex mb-4 justify-content-center'>
				<div class='card card_form form'>
					<div class='row'>


						<div class='col-12'>
							<label for='email'>Email address</label>

							@if (@Cookie::get('login_email'))
								<input class='w-100' form='public-login' type='email' name='email' id='email' value='{{ Cookie::get('login_email') }}' required/>
							@else
								<input class='w-100' form='public-login' type='email' name='email' id='email' value='{{ old('email') }}' required/>
							@endif

							<div class='form_error_container' field='email'>
							@error('email')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-12'>
							{{-- <label for='password'>Password</label> --}}
							<label for='password' class='flex-apart'>Password<span class='forgot-password'><a href='{{ route('forgot-password') }}'>Forgot password?</a></span></label>

							<input class='w-100' form='public-login' type='password' name='password' id='password' value='{{ old('password') }}' required/>

							<div class='form_error_container' field='password'>
							@error('password')
								<p>{{ $message }}</p>
							@enderror
							</div>
						</div>


						<div class='col-12'>
							<div class='checkbox-input mb-0'>
								<input type='checkbox' form='public-login' name='remember' id='remember'>
								<label class='form-check-label' for='remember'>Keep me logged in</label>
							</div>
						</div>


						<div class='col-12 mt-3'>
							<input type='submit' class='btn btn-block btn-primary mx-0' form='public-login' value='Log In'/>
						</div>


					</div>
				</div>
			</div>
		</form>
	</div>

@endsection
