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
				<h1>Set Your Password</h1>
				<p class='mb-3'>Please enter a password for your account.</p>
			</div>
		</div>
		<form class='auto_validate_forms' id='public-set_password' action='{{ route('set-password-new') }}' method='POST' class='container pb-5'>
			@csrf


			<div class='col d-flex mb-4 justify-content-center'>
				<div class='card card_form form'>
					<div class='row'>


						<div class='col-12'>
							<label for='email'>New password</label>

							<input class='w-100' form='public-set_password' type='password' name='password' id='password' required/>

							<div class='form_error_container' field='password'>
							@error('password')
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
							<input type='submit' class='btn btn-block btn-primary mx-0 mb-0' form='public-set_password' value='Set Password'/>
						</div>


					</div>
				</div>
			</div>


		</form>
	</div>

@endsection
